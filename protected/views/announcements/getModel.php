
<label>Модель<span class="required"></label>

<div class="drop_list unexpand">
    <div class="drop_button"></div>
	<?php
        $listdata = array();
        $listdata[] = '';
        foreach($models as $item)
        {
            $listdata[$item->m_id] = $item->m_name;
        }
        reset($listdata);
        $seleketed_key = ($model_id==0) ? key($listdata) : $model_id;
    ?>
	<span class="selected_value"><?=$listdata[$seleketed_key]?></span>
	<?php echo CHtml::activeDropDownList(Announcements::model(), 'model_id', $listdata, array(
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


