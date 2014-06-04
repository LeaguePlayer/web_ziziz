
<?if (count($modifications) > 0):?>

<label>Модификация</label>

<div class="drop_list unexpand">
    <div class="drop_button"></div>
	<?php
        $listdata[0] = 'Не указано';
        foreach (CHtml::listData($modifications, 'mod_id', 'mod_name') as $k => $v)
        {
            $listdata[$k] = $v;
        }
    ?>
    <?php
        $seleketed_key = ($modification->isNewRecord) ? 0 : $modification->mod_id;
    ?>
	<span class="selected_value"><?=$listdata[$seleketed_key]?></span>
	<?php echo CHtml::DropDownList('Auto[auto_modification_id]', 'mod_id', $listdata, array(
        //'empty'=>array('0'=>'Не указано'),
        'class'=>'modification-list',
        'options'=>array(
            "$modification->mod_id"=>array('selected'=>'seleceted'),
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

<?endif;?>

<div class="modification-form">
    <?php $this->renderPartial('getCheckModification', array(
        'model' => $modification,
    )) ?>
</div>
