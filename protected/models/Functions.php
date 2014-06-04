<?php

class Functions
{
    public static function getCalendarDay($date,$checker=false)
    {
        if(!$checker)
            $list_mounth = array('Jan'=>'ЯНВ','Feb'=>'ФЕВ','Mar'=>'МАР','Apr'=>'АПР','May'=>'МАЙ','Jun'=>'ИЮН','Jul'=>'ИЮЛ','Aug'=>'АВГ','Sep'=>'СЕН','Oct'=>'ОКТ','Nov'=>'НОЯ','Dec'=>'ДЕК');
        else
            $list_mounth = array('Jan'=>'Января','Feb'=>'Февраля','Mar'=>'Марта','Apr'=>'Апреля','May'=>'Мая','Jun'=>'Июня','Jul'=>'Июля','Aug'=>'Августа','Sep'=>'Сентября','Oct'=>'Октября','Nov'=>'Ноября','Dec'=>'Декабря');
        $month = date('M',strtotime($date));
        $month = $list_mounth[$month];
        $day =  date('j',strtotime($date));
        $year =  date('Y',strtotime($date));
        if($checker)
            return $day.' '.$month.' '.$year;
        else return $month;
    }
    
    public static function saveIMG($file_name, $root, $model, $wish_name=true)
    {
        if ($file_name != '')
        {
            $fname_ext = explode('.', $file_name);
            $n = count($fname_ext);
            if ($n < 2)
                throw new CHttpException(404, 'Не задан формат изображения!');
                            
            else if (in_array(strtolower($fname_ext[$n-1]), array('jpg', 'jpeg', 'png', 'gif')))
            {
                $fname_ext[0] = md5(md5($fname_ext[0]) . md5(time()));
                $file_name = $fname_ext[0] . '.' . $fname_ext[$n-1];
                
                // удаляем старое изображение если есть
                if (isset($model->img))
                {
                    {
                        if (is_file($_SERVER['DOCUMENT_ROOT'] . $root . $model->img))
                            unlink($_SERVER['DOCUMENT_ROOT'] . $root . $model->img);
                        if (is_file($_SERVER['DOCUMENT_ROOT'] . $root . 'mini_' . $model->img))
                            unlink($_SERVER['DOCUMENT_ROOT'] . $root . 'mini_' . $model->img);
                    }
                }

                $model->img = CUploadedFile::getInstance($model, 'img');
                if(is_object($model))
                {
                    if (!is_dir($_SERVER['DOCUMENT_ROOT'] . $root))
                        mkdir($_SERVER['DOCUMENT_ROOT'] . $root);
                    $model->img->saveAs($_SERVER['DOCUMENT_ROOT'] . $root . $file_name);
                }
       
                Yii::import('ext.phpthumb.EasyPhpThumb');
                $thumbs = new EasyPhpThumb();
                $thumbs->init();
                $thumbs->setThumbsDirectory($root);
                
                $thumbs
                ->load($_SERVER['DOCUMENT_ROOT'] . $root . $file_name)
                ->resizeByGhz(150,100)
                ->save('mini_'.$file_name);
                
                $model->img = $file_name;
                      
            } else
                throw new CHttpException(404, 'Неподдерживаемый формат изображения!');

        }
        else unset($model->img);
        
        return $model;
    }    
    
    public static function getThumb($file_name, $root)
    {
        return $_SERVER["DOCUMENT_ROOT"].Yii::app()->request->baseUrl.DIRECTORY_SEPARATOR.$root.'mini_'.$file_name;
    }
    
    public static function getOriginal($file_name, $root)
    {
        return $_SERVER["DOCUMENT_ROOT"].Yii::app()->request->baseUrl.DIRECTORY_SEPARATOR.$root.$file_name;
    }
    
    /**
     * количество целых интервалов времени между двумя датами
     */
    public static function diffDate($date_left, $date_right, $interval='s')
    {
        $ts_left = (is_numeric($date_left)) ? $date_left : strtotime($date_left);
        $ts_right = (is_numeric($date_right)) ? $date_right : strtotime($date_right);
        $difference = $ts_right - $ts_left;
        switch($interval){
            case 's':
                return $difference;
                break;
            case 'i':
                return floor($difference / 60);
                break;
            case 'h':
                return floor($difference / (60*60));
                break;
            case 'd':
                return floor($difference / (60*60*24));
                break;
            case 'w':
                return floor($difference / (60*60*24*7));
                break;
            default:
                return $difference;
        }
    }    
    
    public static function when_it_was($date)
    {
        $ts_date = (is_numeric($date)) ? $date : strtotime($date);
        $today = time();
        $diff = self::diffDate($date, $today);
        if ($diff > -1)
        {
            if (strtotime("-1 day".date("Y-m-d"), $today)==strtotime(date("Y-m-d", strtotime($date))))
                $result = 'Вчера';
            else if (strtotime(date("Y-m-d"))==strtotime(date("Y-m-d", strtotime($date))))
                $result = 'Сегодня';
	        else
            {
//                $result = $days;
//                if ($days < 21) $last_num = $days % 20;
//                else $last_num = $days % 10;
//                if ($last_num == 1)
//                    $result .= ' день';
//                elseif ($last_num == 2 || $last_num == 3 || $last_num == 4)
//                    $result .= ' дня';
//                else
//                    $result .= ' дней';
                $name_month = array(
                    '1'=>'января','2'=>'февраля','3'=>'марта',
                    '4'=>'апреля','5'=>'мая','6'=>'июня',
                    '7'=>'июля','8'=>'августа','9'=>'сентября',
                    '10'=>'октября','11'=>'ноября','12'=>'декабря'
                );
                $day = date('j', $ts_date);
                $month = $name_month[ date('n', $ts_date) ];
                
                $result = $day.' '.$month;
	        }
	        $result .= ', '.date('H:i', $ts_date);
	        return $result;
        }
        return self::getCalendarDay($date, true);
    }
    
    public static function get_left_time($date, $output_fail = 'timeout')
    {
        $ts_date = (is_numeric($date)) ? $date : strtotime($date);
        $today = time();
        $diff = self::diffDate($today, $date);
    	if ($diff > -1) {
            if (strtotime(date("Y-m-d"))==strtotime(date("Y-m-d", strtotime($date))))
                $result = 'Сегодня';
            elseif (strtotime("+1 day".date("Y-m-d"), $today)==strtotime(date("Y-m-d", strtotime($date))))
                $result = 'Завтра';
            else
            {
                $days = floor($diff / (60 * 60 * 24));
                $result = 'Через ';
                if ($days < 21) $last_num = $days % 20;
                else $last_num = $days % 10;
                if ($last_num == 1)
                    $result .= $days.' день';
                elseif ($last_num == 2 || $last_num == 3 || $last_num == 4)
                    $result .= $days.' дня';
                else
                    $result .= $days.' дней';
    		}
    		return $result.', в '.date('H:i', $ts_date);
    	}
    	return $output_fail;
    }
    
    public static function sendMail($subject,$message,$to='',$from='')
    {
        if($to=='') $to = Yii::app()->params['adminEmail'];
        if($from=='') $from = 'no-reply@torsim.ru';
        $headers = "MIME-Version: 1.0\r\nFrom: $from\r\nReply-To: $from\r\nContent-Type: text/html; charset=utf-8";
	    $message = wordwrap($message, 70);
	    $message = str_replace("\n.", "\n..", $message);
        return mail($to,'=?UTF-8?B?'.base64_encode($subject).'?=',$message,$headers);
    }
    
    public static function generateKey($length)
    {
        $string = 'abcdefghijlklmnopqrstuvwxyzABCDEFGHIJLKLMNOPQRSTUVWXYZ1234567890';
        $result = '';
        $n = strlen($string);
        for ($i=0; $i<$length; $i++)
        {
            $result .= $string[rand(0, $n)];
        }        
        return $result;
    }
    
    public static function priceFormat($price, $currency = 'р.')
    {
        $string = "$price";
        $len = strlen($string);
        $result = "";
        for ($i = 1; $i <= $len; $i++) {
            $result.=$string[$len-$i];
            if ($i%3 == 0) $result.=" ";
        }
        return strrev($result);
    }
    
    public static function getWords($string)
    {
        $string=preg_replace("/  +/"," ",$string);
        $string=preg_replace("/, +/",",",$string);
        $arr = explode(' ', $string);
        $words = array();
        foreach ($arr as $item)
        {
            $words = array_merge($words, explode(',', $item));
        }
        return $words;
    }
    
    public static function extractIntro($string, $maxlen, $endintro = '...')
    {
        $_str = trim($string);
        $_len = strlen($_str);
        if ($_len <= $maxlen)
            return $string;
        else
            return mb_substr($_str, 0, $maxlen, 'UTF-8').$endintro;
    }
    
    // функция превода текста с кириллицы в траскрипт
    function translit($str)
    {
        $tr = array(
            "А"=>"a","Б"=>"b","В"=>"v","Г"=>"g",
            "Д"=>"d","Е"=>"e","Ж"=>"j","З"=>"z","И"=>"i",
            "Й"=>"y","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n",
            "О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
            "У"=>"u","Ф"=>"f","Х"=>"h","Ц"=>"ts","Ч"=>"ch",
            "Ш"=>"sh","Щ"=>"sch","Ъ"=>"","Ы"=>"yi","Ь"=>"",
            "Э"=>"e","Ю"=>"yu","Я"=>"ya","а"=>"a","б"=>"b",
            "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
            "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
            "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
            "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
            "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
            "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya", 
            " "=> "_", "."=> "", "/"=> "_"
        );
        return strtr($str,$tr);
    }
}