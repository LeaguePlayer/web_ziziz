
<?php if ( $staticLabel ): ?>
	<label style="display: block;">Модель</label>
<?php else: ?>
	<label class="required">Модель<span class="required"> *</span></label>
<?php endif; ?>

<div class="drop_list unexpand">
    <div class="drop_button"></div>
	<?php $listdata = CHtml::ListData($models, 'm_id', 'm_name'); ?>
    <?php
        reset($listdata);
        $seleketed_key = ($model_id==0) ? key($listdata) : $model_id;
    ?>
	<span class="selected_value"><?=$listdata[$seleketed_key]?></span>
	<?php echo CHtml::activeDropDownList(new Auto, 'auto_model_id', CHtml::ListData($models, 'm_id', 'm_name'), array(
        'class'=>'models-list',
        'options'=>array(
            "$seleketed_key"=>array('selected'=>'seleceted'),
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


