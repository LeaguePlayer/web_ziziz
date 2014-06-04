<div class="text_title_objects_in_map">Объкты на карте</div>
<div id="map_menu">
	<ul>
    	<li class="map_item"><a href="#all" style="background-image: url(/images/maps_all.png);" rel="all" icon="/images/maps_all.png">Все</a></li>
        
        <? foreach (Company::types() as $type): ?>
            <li class="map_item"><a href="#<?=$type['name']?>" style="background-image:url(<?=$type['icon']?>);" rel="<?=$type['name']?>" icon="<?=$type['icon']?>"><?=$type['label']?></a></li>
        <? endforeach; ?>
    </ul>
</div>
<div id="map"></div>

<?php
    $session = Yii::app()->session;
    $session->open();
    $city_name = $session['cur_city'];
    $session->close();
    
    echo CHtml::hiddenField('cur_city', $city_name);
?>