<?php
$this->breadcrumbs=array(
	'Announcements'=>array('index'),
	$model->ann_id,
);
?>

<?php $this->beginWidget('CActiveForm') ;?>
    <span class="text_row_title">Объявления</span>
    <div id="actions_pannel">
    </div>
    
    <div class="products" style="height: 30px;">
        <div class="product_title">
            Название
        </div>
        
        <div class="shape_date">
            Статус
        </div>
         
    </div>
    
    <?php foreach($model as $announce): ?>
        <div class="products" style="height: 30px;">
            <div class="product_title">
                <?php echo CHtml::link(CHtml::encode($announce->ann_name), $this->createUrl('announcements/view', array('id' => $announce->ann_id)), array(
                    'class' => 'fancybox',
                    'rel' => $announce->ann_id,
                )); ?>
            </div>
            
            <div class="announce_status fleft">
                <?php echo CHtml::encode(Lookup::model()->item(Lookup::ANNOUNCEMENTS_STATUS, $announce->ann_status)); ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php $this->endWidget(); ?>