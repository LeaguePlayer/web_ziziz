<div class="products">

    <div class="product_img">
        <a href="<?php echo $this->createUrl('view', array('id'=>$data->ann_id, 'gorod'=>$data->user->city->translit)); ?>">
        <?php if (count($data->gall->all) != 0): ?>
            <?php echo CHtml::image(CHtml::encode(str_replace('original_','thumbs/mini_',$data->gall->original[0]->ph_url)),''); ?>
        <?php else: ?>
            <?php echo CHtml::image(Yii::app()->baseUrl.'/images/product_nofoto.jpg'); ?>
        <?php endif; ?>
        </a>
    </div>
    
    <div class="product_title">
        <?php echo CHtml::link(CHtml::encode($data->ann_name), array('view', 'id'=>$data->ann_id, 'gorod'=>$data->user->city->translit)); ?>
    </div>
    
    <div style="float: left; width: 160px;">
        <div class="product_price">
            <?php echo CHtml::encode(Functions::priceFormat($data->ann_price)); ?>
            <span style="color:#4b4b51"> р.</span>
        </div>
    </div>
    
    <div class="product_time">
        <?php echo CHtml::encode(Functions::when_it_was($data->ann_public_date, true)); ?>
    </div>
    
    
    <?php if (Functions::diffDate($data->ann_public_date, time(), 'd') < 2): ?>
        <span class="product_add" style="margin-left: 0;"></span>
    <?php endif; ?>
    

</div>