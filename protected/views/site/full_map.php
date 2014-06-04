<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
    
    <script type="text/javascript" src="/assets/45024759/jquery.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://api-maps.yandex.ru/2.0-stable/?cordorder=longlat&amp;load=package.full&amp;lang=ru-RU"></script>
    <script type="text/javascript" src="/js/map.js"></script>
    
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/css/ziziz/fullmap.css" />
</head>

<body>
        
    <div id="map_menu">
    	<ul>
        	<li class="map_item"><a href="#all" rel="all" icon="/images/maps_all.png"><img src="/images/maps_all.png" />Все</a></li>
        
            <? foreach (Company::types() as $type): ?>
                <li class="map_item"><a href="#<?=$type['name']?>" rel="<?=$type['name']?>" icon="<?=$type['icon']?>"><img src="<?=$type['icon']?>" /><?=$type['label']?></a></li>
            <? endforeach; ?>

            <li><a href="/">Вернуться на сайт</a></li>
        </ul>
    </div>
    <div id="map"></div>

</body>
</html>