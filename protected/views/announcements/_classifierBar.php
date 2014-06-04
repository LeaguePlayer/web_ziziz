<div class="right_title_text">
    Расширенный поиск:
</div>
<?php $url = $this->createUrl('announcements/index'); ?>
<?php echo CHtml::beginForm($url, 'POST', array(
	'class'=>'classifier_bar',
)); ?>
	<div class="triangle"></div>

    <?php if ($cur_category)
    {
        foreach ($cur_category->classifiers as $item)
        {
            echo CHtml::openTag('div', array(
                'class' => 'bar-item',
            ));
                echo CHtml::label($item->classif_name, false);
                echo CHtml::openTag('div', array(
					'class'=>'drop_list unexpand',
				));
					$listdata = null;
					$listdata[0] = 'Любой';
					foreach(CHtml::listData($item->values, 'cv_id', 'cv_value') as $k=>$val)
						$listdata[$k] = $val;
						
					$selected_value = (isset($check_classif[$item->classif_id])) ? $check_classif[$item->classif_id] : 0;
					
					echo CHtml::openTag('span', array('class'=>'selected_value'));
						echo $listdata[$selected_value];
					echo CHtml::closeTag('span');
					
					echo CHtml::dropDownList('classif_values_list', $check_classif[$item->classif_id], $listdata, array(
	                    'class' => 'classif-list',
	                    'rel' => $item->classif_id,
	                    'options' => array(
							$selected_value => array('selected' => 'selected'),
						),
	                ));
	                echo CHtml::openTag('div', array('class'=>'select_options'));
						foreach($listdata as $key => $item)
						{
							$selected = ($key==$selected_value) ? ' selected' : '';
							echo CHtml::openTag('div', array('class'=>'select_option'.$selected, 'value'=>$key));
							echo $item;
							echo CHtml::closeTag('div');
						}
					echo CHtml::closeTag('div');
                echo CHtml::closeTag('div');
            echo CHtml::closeTag('div');
        }
    }
    ?>
    <div class="clear"></div>
    <div class="bottom_shadow"></div>

<?php echo CHtml::endForm(); ?>

<?php 

    

?>

