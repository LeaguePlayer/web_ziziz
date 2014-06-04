<?php /*
	В основоном цикле выводим все классификаторы, 
 	соответствующие категории текущего объявления.
 	Во внутреннем цикле проверяем, какие классификаторы включены.
*/ ?>
<?php foreach ($model->cat->classifiers as $classif): ?>
	
    <?php $flag = true; ?>
    	
	<?php foreach ($model->values as $val): ?>
	
		<?php if ($val->classif->classif_id == $classif->classif_id): ?>
			
			<div id="classif_name">
				<input class="include_classif_checkbox" type="checkbox" checked="" value="<?php echo $classif->classif_id; ?>" />
				<?php echo $classif->classif_name; ?>
			</div>
            <div id="<?php echo 'classif_value_list'.$classif->classif_id; ?>">
	   		 	<?php echo CHtml::dropDownList(
   					'ClassifValues[]',
					$val->cv_id,
					CHtml::listData($classif->values, 'cv_id', 'cv_value'));
			    ?>
            </div>
		    <?php $flag = false; ?>
			<?php break; ?>
            
		<?php endif; ?>
		
	<?php endforeach; ?>
    
    <?php if ($flag): ?>
    
        <div id="classif_name">
    	   <input class="include_classif_checkbox" type="checkbox" value="<?php echo $classif->classif_id; ?>" />
    	   <?php echo $classif->classif_name; ?>
    	</div>
        <div id="classif_value_list<?php echo $classif->classif_id; ?>"></div>
        
     <?php endif; ?>
	
<?php endforeach; ?>