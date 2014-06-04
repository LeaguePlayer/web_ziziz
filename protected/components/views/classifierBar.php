
<?php $url = $this->getController()->createUrl('announcements/index'); ?>
<?php echo CHtml::beginForm($url); ?>

    <?php if ($cur_category)
    {
        foreach ($cur_category->classifiers as $item)
        {
            echo CHtml::dropDownList('classif_values_list', 'classif_id', CHtml::listData($item->values, 'cv_id', 'cv_value'), array(
                'class' => 'classif_values_list',
                'empty' => $item->classif_name,
            ));
        }
        
        echo CHtml::submitButton('Применить');
    }
    ?>

<?php echo CHtml::endForm(); ?>

<?php 

    

?>

