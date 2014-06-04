<?php $this->pageTitle = "Продажа автомобилей на ZIZIZ, доска объявлений в городе ".Citys::model()->findByPk($city_id)->city_name; ?>

<?php

$this->breadcrumbs=array(
	'Автообъявления',
);


//$this->menu=array(
//	array('label'=>'Создать объявление', 'url'=>array('create')),
//	//array('label'=>'Manage Auto', 'url'=>array('admin')),
//);
?>

<h1>Продажа автомобилей в городе <?=Citys::model()->findByPk($city_id)->city_name?></h1>

<div class="bottom">
    
	    <div class="left">
	    </div>
    
	    <div class="right">
	        
	        <div class="text_title_right"></div>
	        
	        <div id="search" class="autosearch">
         	   <?php $this->widget('AnnSearch', array(
                    'params' => array(
                        'url' => $this->createUrl('auto/index'),
                        'update'=>'#listview-container',
                        'mod-form'=>true,
                    ),
                )); ?>
	        </div>
            
            <h1 style="font-size: 20px;">Расширенный поиск:</h1>
            <form class="classifier_bar" method="GET" action="<?=$this->createUrl('index') ?>">
                <div class="triangle"></div>

                <div style="padding-top: 10px;">
                    <div id="brends_search" class="bar-item">
                        <label style="display: block;">Марка</label>
                        <?php //Yii::app()->request->baseUrl.$this->createUrl('/auto/renderModelByBrendId')
                        $this->widget('ext.combobox.EJuiComboBox', array(
                            'name' => 'AutoSearch[brend]',
                            'value' => $search_params['brend'],
                            // data to populate the select. Must be an array.
                            'data' =>  CHtml::listData(Brend::model()->findAll(), 'b_id', 'b_name'),
                            'assoc' => true,
                            //'cssFile' => false,
                            // options passed to plugin
                            'options' => array(
                                'onSelect' => "
                                    jQuery.ajax({
                                        type: 'GET',
                                        url: '/auto/renderModelByBrendId/',
                                        data: {
                                            brend_id: $('#AutoSearch_brend').val(),
                                        },
                                        success: function(data){
                                            jQuery('#models_search').html(data);
                                        }
                                    });
                                ",
                                //'onChange' => '',
                                'allowText' => true,
                            ),
                            // Options passed to the text input
                            'htmlOptions' => array('size' => 10),
                        )); ?>
                    </div>
                    <div id="models_search" class="bar-item">
                        <?php if ( $searchBrend ) {
                            $this->renderPartial('getModel', array('models'=>$searchBrend->models, 'model_id'=>$search_params['model'], 'staticLabel'=>true));
                        } ?>
                    </div>
                </div>
                
                <?php
//                    $info = Modification::getInfoArray();
//                    
//                    foreach ($info as $key => $item)
//                    {
//                        $info[$key][0] = 'Не важно';
////                        array_shift($info[$key]);
////                        array_unshift($info[$key], 'Не важно');
//                    }
                
                    $info = array(
                        'kuzov' => array(
                            '' => 'Любой',
                            1 => 'Седан',
                            2 => 'Хэтчбек',
                            3 => 'Универсал',
                            4 => 'Джи Кроссовер',
                            5 => 'Кабриолет',
                            6 => 'Пикап'
                        ),
                        'control' => array(
                            '' => 'Любой',
                            1 => 'Слева',
                            2 => 'Справа'
                        ),
                        'fuel' => array(
                            '' => 'Любое',
                            1 => 'Бензин',
                            2 => 'Дизель'
                        ),
                        'kpp' => array(
                            '' => 'Любая',
                            1 => 'Механика',
                            2 => 'Автомат'
                        ),
                        'drive' => array(
                            '' => 'Любой',
                            1 => 'Передний',
                            2 => 'Задний',
                            3 => '4WD'
                        )
                    );
                ?>
                <div id="kuzov" class="bar-item">
                    <label>Кузов</label>
                    <div class="drop_list unexpand">
                        <div class="drop_button"></div>
                    	<?php $listdata = $info['kuzov']; ?>
                        <?php
                            $seleketed_key = $search_params['kuzov'];
                        ?>
                    	<span class="selected_value"><?=$listdata[$seleketed_key]?></span>
                    	<?php echo CHtml::DropDownList('AutoSearch[kuzov]','mod_carcass',$listdata, array(
                            'options'=>array(
                                $search_params['kuzov']=>array('selected'=>'selected')
                            )
                        ));?>
                    	<div class="select_options">
                    		<?php
                    		foreach($listdata as $key => $item)
                    		{
                    		    $selected = ($key==$seleketed_key) ? ' selected' : '';
                    			echo CHtml::openTag('div', array('class'=>'select_option'.$selected, 'value'=>$key));
                    			echo $item;
                    			echo CHtml::closeTag('div');
                    		}
                    		?>
                    	</div>
                    </div>
                </div>
                
                <div id="fuel" class="bar-item">
                    <label>Топливо</label>
                    <div class="drop_list unexpand">
                        <div class="drop_button"></div>
                    	<?php $listdata = $info['fuel']; ?>
                        <?php
                            $seleketed_key = $search_params['fuel'];
                        ?>
                    	<span class="selected_value"><?=$listdata[$seleketed_key]?></span>
                    	<?php echo CHtml::DropDownList('AutoSearch[fuel]','mod_fuel',$listdata, array(
                            'options'=>array(
                                $search_params['fuel']=>array('selected'=>'selected')
                            )
                        ));?>
                    	<div class="select_options">
                    		<?php
                    		foreach($listdata as $key => $item)
                    		{
                    		    $selected = ($key==$seleketed_key) ? ' selected' : '';
                    			echo CHtml::openTag('div', array('class'=>'select_option'.$selected, 'value'=>$key));
                    			echo $item;
                    			echo CHtml::closeTag('div');
                    		}
                    		?>
                    	</div>
                    </div>
                </div>
                
                <div id="control" class="bar-item">
                    <label>Руль</label>
                    <div class="drop_list unexpand">
                        <div class="drop_button"></div>
                    	<?php $listdata = $info['control']; ?>
                        <?php
                            $seleketed_key = $search_params['control'];
                        ?>
                    	<span class="selected_value"><?=$listdata[$seleketed_key]?></span>
                    	<?php echo CHtml::DropDownList('AutoSearch[control]','mod_control',$listdata, array(
                            'options'=>array(
                                $search_params['control']=>array('selected'=>'selected')
                            )
                        ));?>
                    	<div class="select_options">
                    		<?php
                    		foreach($listdata as $key => $item)
                    		{
                    		    $selected = ($key==$seleketed_key) ? ' selected' : '';
                    			echo CHtml::openTag('div', array('class'=>'select_option'.$selected, 'value'=>$key));
                    			echo $item;
                    			echo CHtml::closeTag('div');
                    		}
                    		?>
                    	</div>
                    </div>
                </div>
                
                <div id="kpp" class="bar-item">
                    <label>КПП</label>
                    <div class="drop_list unexpand">
                        <div class="drop_button"></div>
                    	<?php $listdata = $info['kpp']; ?>
                        <?php
                            $seleketed_key = $search_params['box'];
                        ?>
                    	<span class="selected_value"><?=$listdata[$seleketed_key]?></span>
                    	<?php echo CHtml::DropDownList('AutoSearch[kpp]','mod_kpp',$listdata, array(
                            'options'=>array(
                                $search_params['box']=>array('selected'=>'selected')
                            )
                        ));?>
                    	<div class="select_options">
                    		<?php
                    		foreach($listdata as $key => $item)
                    		{
                    		    $selected = ($key==$seleketed_key) ? ' selected' : '';
                    			echo CHtml::openTag('div', array('class'=>'select_option'.$selected, 'value'=>$key));
                    			echo $item;
                    			echo CHtml::closeTag('div');
                    		}
                    		?>
                    	</div>
                    </div>
                </div>
                
                <div id="drive" class="bar-item">
                    <label>Привод</label>
                    <div class="drop_list unexpand">
                        <div class="drop_button"></div>
                    	<?php $listdata = $info['drive']; ?>
                        <?php
                            $seleketed_key = $search_params['drive'];
                        ?>
                    	<span class="selected_value"><?=$listdata[$seleketed_key]?></span>
                    	<?php echo CHtml::DropDownList('AutoSearch[drive]','mod_drive',$listdata, array(
                            'options'=>array(
                                $search_params['drive']=>array('selected'=>'selected')
                            )
                        ));?>
                    	<div class="select_options">
                    		<?php
                    		foreach($listdata as $key => $item)
                    		{
                    		    $selected = ($key==$seleketed_key) ? ' selected' : '';
                    			echo CHtml::openTag('div', array('class'=>'select_option'.$selected, 'value'=>$key));
                    			echo $item;
                    			echo CHtml::closeTag('div');
                    		}
                    		?>
                    	</div>
                    </div>
                </div>
                
                
                <div id="year_search" class="bar-item">
                    <label style="display: block;">Год выпуска</label>
                    <?echo CHtml::textField('AutoSearch[year]', $search_params['year'])?>
                </div>
                
                
                <div id="year_search" class="bar-item">
                    <label style="display: block;">Цена от</label>
                    <?echo CHtml::textField('AutoSearch[price_ot]', $search_params['price_ot'])?>
                </div>
                
                
                <div id="year_search" class="bar-item">
                    <label style="display: block;">Цена до</label>
                    <?echo CHtml::textField('AutoSearch[price_do]', $search_params['price_do'])?>
                </div>
                

                
                
                
                
                <div class="clear"></div>
                
                    <?php echo CHtml::ajaxSubmitButton('Поиск', $this->createUrl('auto/index', array('gorod'=>$gorod)), array(
                        'type' => 'POST',
                        'update' => '#listview-container',
                    ),
                    array(
                        'type' => 'submit',
                        'class' => 'default-button',
                        'style' => 'margin: 0 10px 10px;',
                    )); ?>
                
            </form>
            
            <div class="line_shadow" style="width: 100%;"></div>
	        
            <a class="button_add_announce normal" style="margin-bottom: 10px;" href="<?=$this->createUrl('auto/create') ?>"></a>
            <div class="clear"></div>
            
	        <div id="listview-container">
                <?php $this->renderPartial('_list-view', array(
                    'dataProvider' => $dataProvider,
                    'search_empty' => $search_empty,
                )) ?>
            </div>
	        
	    </div>
    </div>
    
    <script>
    
    $('#listview-container .button_clear_search').live('click', function(){
        $.ajax({
            url: '/auto/',
            type: 'POST',
            data: {clear_search: 1},
            success: function(data) {
                $("#AnnSearchForm_string").val("");
                
                $("#kuzov .drop_list .selected_value").text("Любой");
                $("#kuzov .drop_list .select_option.selected").removeClass("selected");
                $("#kuzov .drop_list .select_option:first").addClass("selected");
                $("#AutoSearch_kuzov option:selected").removeAttr("selected");
                
                $("#fuel .drop_list .selected_value").text("Любой");
                $("#fuel .drop_list .select_option.selected").removeClass("selected");
                $("#fuel .drop_list .select_option:first").addClass("selected");
                $("#AutoSearch_fuel option:selected").removeAttr("selected");
                
                $("#control .drop_list .selected_value").text("Любой");
                $("#control .drop_list .select_option.selected").removeClass("selected");
                $("#control .drop_list .select_option:first").addClass("selected");
                $("#AutoSearch_control option:selected").removeAttr("selected");
                
                $("#kpp .drop_list .selected_value").text("Любой");
                $("#kpp .drop_list .select_option.selected").removeClass("selected");
                $("#kpp .drop_list .select_option:first").addClass("selected");
                $("#AutoSearch_kpp option:selected").removeAttr("selected");
                
                $("#drive .drop_list .selected_value").text("Любой");
                $("#drive .drop_list .select_option.selected").removeClass("selected");
                $("#drive .drop_list .select_option:first").addClass("selected");
                $("#AutoSearch_drive option:selected").removeAttr("selected");
                
                $("#AutoSearch_brend_combobox").val('');
                $('#AutoSearch_brend option:selected').removeAttr('selected');
                $('#models_search').html('');
                
                $("#listview-container").html(data);
            }
        });
        return false;
    });
    
    $("#AutoSearch_brend_combobox").keyup(function(){
        if ($(this).val() == '')
        {
            $('#AutoSearch_brend option:selected').removeAttr('selected');
            $('#models_search').html('');
        }
    });
    
    
    
    </script>
