<?php foreach($classifiers as $classifier): ?>
    <?php
    $its_checked = false;
    
    if (isset($check_classifvalues))
        foreach($check_classifvalues as $check_value){
            if($check_value->classif->classif_id == $classifier->classif_id){
                $its_checked = true;
                $checked_value_id = $check_value->cv_id;
                break;
            }
        }
    ?>
    
    <div id="checkboxDiv" class="checkbox<?=($its_checked) ? 'On' : 'Off'?>" style="width: 20px;">
        <label>
            <?php echo CHtml::checkBox('', $its_checked, array(
                'class'=>'include_classif_checkbox',
            )) ?>
        </label>
    </div>
    <label><?php echo $classifier->classif_name; ?></label>
    
    
    <div class="drop_list unexpand" style="<?=($its_checked) ? '' : 'display: none;'?> width: 155px;">
        <div class="drop_button"></div>
        <?php
            $listdata = CHtml::listData($classifier->values, 'cv_id', 'cv_value');
            
            if (isset($checked_value_id))
                $selected_value = $listdata[$checked_value_id];
            else
            {
                reset($listdata);
                $selected_value = $listdata[key($listdata)];
            }
        ?>
        <span class="selected_value"><?=$selected_value?></span>
        <?php
            if ($its_checked)
                $htmlOptions = array('id'=>'classifList-'.$classifier->classif_id);
            else
                $htmlOptions = array('id'=>'classifList-'.$classifier->classif_id, 'disabled'=>'disabled');
        ?>
        <?php echo CHtml::dropDownList('ClassifValues[]', $checked_value_id, $listdata, $htmlOptions); ?>
        <div class="select_options">
        	<?php
        	foreach($listdata as $key => $item)
        	{
                $selected = ($key==$checked_value_id) ? ' selected' : '';
                echo CHtml::openTag('div', array('class'=>'select_option'.$selected, 'value'=>$key));
                echo $item;
                echo CHtml::closeTag('div');
        	}
        	?>
        </div>
        
    </div>
    
<? endforeach; ?>