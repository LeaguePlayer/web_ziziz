<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
        $news = News::model()->findAll(array(
            'order' => 'date_public',
            'limit' => 2,
        ));
//        $actions = Actions::model()->findAll(array(
//            'order' => 'date_public',
//            'limit' => 3,
//        ));

        $session = Yii::app()->session;
        $session->open();
        
        if (!empty($session['cur_city_id']))
        {
            $city_id = $session['cur_city_id'];
        }
        else if (!Yii::app()->user->isGuest)
        {
        	$user = Users::model()->findByPk(Yii::app()->user->id);
       		if (!empty($user->user_city_id))
       			$city_id = $user->user_city_id;
        }
        else
            $city_id = Yii::app()->params['def_city_id'];
        	
        
        $announcements = Announcements::model()->with(array(
            'user'=>array(
                'select'=>'user_city_id',
            ),
        ))->findAll(array(
            'condition'=>'ann_status='.Announcements::STATUS_PUBLISHED.' AND user.user_city_id='.$city_id,
			'order'=>'ann_public_date DESC',
			'limit'=>5,
		));
        
        $auto = Auto::model()->with(array(
            'automodel',
            'automodel.modelbrend',
            'user'=>array(
                'select'=>'user_city_id',
            ),
        ))->findAll(array(
            'condition'=>'auto_status='.Auto::STATUS_PUBLISHED.' AND user.user_city_id='.$city_id,
			'order' => 'auto_public_date DESC',
			'limit' =>5,
		));
		
		$counter = 0;
        $min = 0;
        for ($key_ann = 0; $key_ann < count($announcements); $key_ann++)
		{
            for ($key_auto = $min; $key_auto < count($auto); $key_auto++)
			{
				if(strtotime($announcements[$key_ann]->ann_public_date) - strtotime($auto[$key_auto]->auto_public_date) > 0)
                {
                    break;
                }
				else
                {
					$posts[$counter] = $auto[$key_auto];
                    $min++;
                    $counter++;
                    if ($counter > 4) break;
                }
			}
            $posts[$counter] = $announcements[$key_ann];
            $counter++;
            if ($counter > 4) break;
            
		}
        
        $cs=Yii::app()->getClientScript();
        $cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/map.js?v=2', CClientScript::POS_HEAD);
        
        $city = Citys::model()->findByPk($city_id);
        
		$this->render('index', array(
			'posts'=>$posts,
            'company'=>$company,
            'news' => $news,
            'city' => $city,
//            'actions' => $actions,
        ));
	}
    
    public function actionFullmap()
    {
        $cs=Yii::app()->getClientScript();
        //$cs->registerScriptFile("http://api-maps.yandex.ru/2.0-stable/?cordorder=longlat&load=package.full&lang=ru-RU", CClientScript::POS_HEAD);
        //$cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/map.js', CClientScript::POS_HEAD);
        //$company = Company::model()->findAll();
        $this->renderPartial('full_map', array(
            //'company'=>$company,
        ));
    }

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
	   /*
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
        */
	}
    
    public function actionDump()
	{
		 $command = Yii::app()->db->createCommand();
         /*$marks = $command->select('id, name, meta_keys, meta_title, meta_description, meta_html')->from('mod_catalog_marka')->queryAll();
         //print_r($marks);
         foreach($marks as $mark){
            $command->insert('brend',array(
                'b_id'=>$mark['id'],
                'b_name'=>$mark['name'],
                'b_meta_keys'=>$mark['meta_keys'],
                'b_meta_title'=>$mark['meta_title'],
                'b_meta_description'=>$mark['meta_description'],
                'b_meta_html'=>$mark['meta_html']
            ));
         }
         
         $models = $command->select('id, marka, name, meta_keys, meta_title, meta_desc, html')->from('mod_catalog_model')->queryAll();
         //print_r($marks);
         foreach($models as $model){
            $command->insert('carmodel',array(
                'm_id'=>$model['id'],
                'm_name'=>$model['name'],
                'm_brend_id'=>$model['marka'],
                'm_meta_keys'=>$model['meta_keys'],
                'm_meta_title'=>$model['meta_title'],
                'm_meta_description'=>$model['meta_desc'],
                'm_meta_html'=>$model['html']
            ));
         }*/
         //$command->select();
	}
	
	public function actionCompanys()
	{
		if (isset($_POST['map_marked']))
		{
			if ($_POST['map_marked'] == 'all')
			{
				$companys = Company::model()->findAll();
				$rows = array();
				foreach ($companys as $row)
				{
					$rows[] = array(
						'company_name'=>$row->company_name,
						'company_address'=>$row->company_address,
						'company_ymap_pos1'=>$row->company_ymap_pos1,
						'company_ymap_pos2'=>$row->company_ymap_pos2,
					);
				}
				if (function_exists('json_encode'))
					echo json_encode($rows);
				else
					echo CJSON::encode($result);
			}
		}
	}
    
    public function actionInitCity()
    {
        $session = Yii::app()->session;
        $session->open();

        if (isset($_POST['city_id']))
        {
            if ($city = Citys::model()->findByPk($_POST['city_id']))
            {
                $session->add('cur_city_id', $city->city_id);
	            $session->add('cur_city', $city->city_name);
            }
        }

        if (isset($_POST['city_name']))
        {
            $city = Citys::model()->find('city_name=:city', array(':city'=>$_POST['city_name']));
            
            if ( $city == null )
            {
                $city = new Citys;
                $city->city_name = $_POST['city_name'];
                if ($city->save(false))
                {
                    $session->add('cur_city_id', $city->city_id);
                    $session->add('cur_city', $city->city_name);
                }
                else
                {
                    $session->add('cur_city_id',  Yii::app()->params['def_city_id']);
                    $session->add('cur_city', Yii::app()->params['def_city_name']);
                }
            }
            else
            {
                $session->add('cur_city_id', $city->city_id);
                $session->add('cur_city', $city->city_name);
            }
            
            echo 1;
        }
        
        $session->close();
    }
    
    
    public function actionAuthenticate()
    {
        
        $session = Yii::app()->session;
        $session->open();
        //echo Yii::app()->user->returnUrl;
        // сохранение предыдущей страницы в первое обращение к контроллеру
        if (!isset($session['url_referrer'])) $session->add('url_referrer', Yii::app()->request->urlReferrer);
        
    	$model = new LoginForm;
    	if (isset($session['LoginForm']))
    	{
    		$model->attributes = $session->remove('LoginForm');
    		$model->validate();
    	}
    	
    	if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
            {
                if (isset($session['return_url']))
                {
                    $url = $session['return_url'];
                    $session->remove('return_url');
                }
                else
                {
                    $url = (empty($model->url)) ? '/' : $model->url;
                }
                    
                $session->close();
                $this->redirect($url);
            }
		}
        
        $urlReferrer = $session['url_referrer'];
        $session->close();
        if (Yii::app()->request->isAjaxRequest)
        {
            $this->renderPartial('authenticate', array('model'=>$model));
            Yii::app()->end();
        }

        $this->render('authenticate', array(
            'model'=>$model,
            'urlReferrer'=>$urlReferrer,
        ));
    }
    
    
    
    public function actionModeration()
    {
        if (!Yii::app()->user->checkAccess('moderator'))
        {
            throw new CHttpException(403, "У Вас не достаточно прав для выполнения указанного действия");
        }
        
        $with = array(
            'user'=>array(
                'select'=>array('user_city_id', 'user_login'),
            ),
            'user.city',
        );
        
        $criteriaAnnounce = new CDbCriteria;
        $criteriaAnnounce->with = $with;
        $criteriaAnnounce->order = 'ann_status ASC, last_update DESC';
        
        $criteriaAuto = new CDbCriteria;
        $criteriaAuto->with = $with;
        $criteriaAuto->order = 'auto_status ASC, last_update DESC';
        
        $criteriaActions = new CDbCriteria;
        $criteriaActions->with = $with;
        $criteriaActions->order = 'status ASC, last_update DESC';
        
        
        // Объявления запчасти
        if (isset($_GET['operation']))
        {
            if ($_GET['operation'] == 'public_ann')
            {
                $model = Announcements::model()->with('user')->findByPk($_GET['id']);
                if ($model)
                {
                    $model->ann_status = Announcements::STATUS_PUBLISHED;
                    $model->ann_public_date = date('Y-m-d H:i:s', time());
                    if ($model->save(false))
                    {
                        $message = new Messages;
                        $message->subject = "Ваше объявление опубликовано";
                        $message->text = "Ваше объявление прошло модерацию";
                        $message->from = Yii::app()->user->id;
                        $message->to = $model->user->user_id;
                        $message->post_type = 'ann';
                        $message->post_id = $model->ann_id;
                        $message->save(false);
                        Functions::sendMail($message->subject, $message->text, $model->user->user_email, 'no-repeat@ziziz.ru');
                    }
                }
                if (Yii::app()->request->isAjaxRequest)
                {
                    $dataProvider = new CActiveDataProvider('Announcements', array(
                        'criteria'=>$criteriaAnnounce,
                    ));
                    $this->renderPartial('_admin_ann',array('dataProvider'=>$dataProvider));
                    Yii::app()->end();
                }
            }
            
            if ($_GET['operation'] == 'block_ann')
            {
                $model = Announcements::model()->with('user')->findByPk($_GET['id']);
                if ($model)
                {
                    $model->ann_status = Announcements::STATUS_BLOCKED;
                    $model->ann_public_date = date('Y-m-d H:i:s', time());
                    if ($model->save(false))
                    {
                        $message = new Messages;
                        $message->subject = "Объявление заблокировано модератором";
                        $message->text = "Объявление заблокировано модератором";
                        $message->from = Yii::app()->user->id;
                        $message->to = $model->user->user_id;
                        $message->post_type = 'ann';
                        $message->post_id = $model->ann_id;
                        $message->save(false);
                        Functions::sendMail($message->subject, $message->text, $model->user->user_email, 'no-repeat@ziziz.ru');
                    }
                }
                if (Yii::app()->request->isAjaxRequest)
                {
                    $dataProvider = new CActiveDataProvider('Announcements', array(
                        'criteria'=>$criteriaAnnounce,
                    ));
                    $this->renderPartial('_admin_ann',array('dataProvider'=>$dataProvider));
                    Yii::app()->end();
                }
            }
            
            // Объявления авто
            if ($_GET['operation'] == 'public_auto')
            {
                $model = Auto::model()->with('user')->findByPk($_GET['id']);
                if ($model)
                {
                    $model->auto_status = Auto::STATUS_PUBLISHED;
                    $model->auto_public_date = date('Y-m-d H:i:s', time());
                    if ($model->save(false))
                    {
                        $message = new Messages;
                        $message->subject = "Ваше объявление опубликовано";
                        $message->text = "Ваше объявление прошло модерацию";
                        $message->from = Yii::app()->user->id;
                        $message->to = $model->user->user_id;
                        $message->post_type = 'auto';
                        $message->post_id = $model->auto_id;
                        $message->save(false);
                        Functions::sendMail($message->subject, $message->text, $model->user->user_email, 'no-repeat@ziziz.ru');
                    }
                }
                if (Yii::app()->request->isAjaxRequest)
                {
                    $dataProvider = new CActiveDataProvider('Auto', array(
                        'criteria'=>$criteriaAuto,
                    ));
                    $this->renderPartial('_admin_auto',array('dataProvider'=>$dataProvider));
                    Yii::app()->end();
                }
            }
            
            if ($_GET['operation'] == 'block_auto')
            {
                $model = Auto::model()->with('user')->findByPk($_GET['id']);
                if ($model)
                {
                    $model->auto_status = Auto::STATUS_BLOCKED;
                    $model->auto_public_date = date('Y-m-d H:i:s', time());
                    if ($model->save(false))
                    {
                        $message = new Messages;
                        $message->subject = "Объявление заблокировано модератором";
                        $message->text = "Объявление заблокировано модератором";
                        $message->from = Yii::app()->user->id;
                        $message->to = $model->auto_user;
                        $message->post_type = 'act';
                        $message->post_id = $model->auto_id;
                        $message->save(false);
                        Functions::sendMail($message->subject, $message->text, $model->user->user_email, 'no-repeat@ziziz.ru');
                    }
                }
                if (Yii::app()->request->isAjaxRequest)
                {
                    $dataProvider = new CActiveDataProvider('Auto', array(
                        'criteria'=>$criteriaAuto,
                    ));
                    $this->renderPartial('_admin_auto',array('dataProvider'=>$dataProvider));
                    Yii::app()->end();
                }
            }
            
            // Акции
            if ($_GET['operation'] == 'public_act')
            {
                $model = Actions::model()->with('user')->findByPk($_GET['id']);
                if ($model)
                {
                    $model->status = Actions::STATUS_PUBLISHED;
                    $model->date_public = date('Y-m-d H:i:s', time());
                    if ($model->save(false))
                    {
                        $message = new Messages;
                        $message->subject = "Акция опубликована";
                        $message->text = "Ваше объявление прошло модерацию";
                        $message->from = Yii::app()->user->id;
                        $message->to = $model->user_id;
                        $message->post_type = 'act';
                        $message->post_id = $model->id;
                        $message->save(false);
                        Functions::sendMail($message->subject, $message->text, $model->user->user_email, 'no-repeat@ziziz.ru');
                    }
                }
                if (Yii::app()->request->isAjaxRequest)
                {
                    $dataProvider = new CActiveDataProvider('Actions', array(
                        'criteria'=>$criteriaActions,
                    ));
                    $this->renderPartial('_admin_act',array('dataProvider'=>$dataProvider));
                    Yii::app()->end();
                }
            }
            
            if ($_GET['operation'] == 'block_act')
            {
                $model = Actions::model()->with('user')->findByPk($_GET['id']);
                if ($model)
                {
                    $model->status = Actions::STATUS_BLOCKED;
                    $model->date_public = date('Y-m-d H:i:s', time());
                    $model->last_update = $model->date_public;
                    if ($model->save(false))
                    {
                        $message = new Messages;
                        $message->subject = "Акция заблокирована модератором";
                        $message->text = "Акция заблокирована модератором";
                        $message->from = Yii::app()->user->id;
                        $message->to = $model->user_id;
                        $message->post_type = 'act';
                        $message->post_id = $model->id;
                        $message->save(false);
                        Functions::sendMail($message->subject, $message->text, $model->user->user_email, 'no-repeat@ziziz.ru');
                    }
                }
                if (Yii::app()->request->isAjaxRequest)
                {
                    $dataProvider = new CActiveDataProvider('Actions', array(
                        'criteria'=>$criteriaActions,
                    ));
                    $this->renderPartial('_admin_act',array('dataProvider'=>$dataProvider));
                    Yii::app()->end();
                }
            }
        }
        
        
        $dataProvider1 = new CActiveDataProvider('Announcements', array(
            'criteria'=>$criteriaAnnounce
        ));
        
        $dataProvider2 = new CActiveDataProvider('Auto', array(
            'criteria'=>$criteriaAuto
        ));
        
        $dataProvider3 = new CActiveDataProvider('Actions', array(
            'criteria'=>$criteriaActions
        ));
        
        
        
        $this->render('moderation', array(
            'dataProvider1'=>$dataProvider1,
            'dataProvider2'=>$dataProvider2,
            'dataProvider3'=>$dataProvider3
        ));
    }
    
    public function actionGetimage($source = null)
    {
        echo "<div class='image' style='display: none; width: 100%; height: 100%; background: url(\"". str_replace('original_','thumbs/big_', $source) ."\") no-repeat center center;'>";
    }
    
    
    public function actionParse()
    {
//        require_once('/protected/components/simple_html_dom.php');
//        
//        $data = file_get_html('http://www.cto.ru/tumen/schinomontazhi/?page=2');
//        $nodes = $data->find('.catalog-list-item');
//        if ($nodes)
//        {
//            $counter = 0;
//            foreach ($nodes as $node)
//            {
//                // Название
//                
//                // Адрес без названия города;
//                $items = $node->find('ul.object-info li');
//                $address = '';
//                foreach ($items as $item) {
//                    if ($item->find('span')) continue;
//                    
//                    $arr = explode(' ', $item->plaintext);
//                    foreach ($arr as $k => $word)
//                    {
//                        if ( preg_match("/Тюмень/i", $word) )
//                            $arr[$k] = '';
//                    }
//                    $address = trim( implode(' ', $arr) );
//                    break;
//                }
//                
//                $company = new Company;
//                $company->company_name = trim($node->find('h2', 0)->plaintext);
//                $company->company_address = $address;
//                $company->company_user_id = 1;
//                $company->company_type = 'tireservice';
//                $company->show_on_map = 1;
//                $company->save(false);
//                
//                ++$counter;
//                
//                // Описание
//                //echo $node->find('.excerpt', 0)->plaintext.'<br/>';
//            }
//            echo $counter;
//        }
    }
}