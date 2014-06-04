<div class="products">

    <div class="product_img">
        <?php if (count($data->gall->all) != 0): ?>
            <?php echo CHtml::image(CHtml::encode(str_replace('original_','thumbs/mini_',$data->gall->original[0]->ph_url)),''); ?>
        <?php else: ?>
            <?php echo CHtml::image(Yii::app()->baseUrl.'/images/product_nofoto.jpg'); ?>
        <?php endif; ?>
    </div>
    
    <div class="product_title">
        <?php $title = $data->automodel->modelbrend->b_name.', '.$data->automodel->m_name.' '.$data->auto_year.' г.в.' ?>
        <?php echo CHtml::link(CHtml::encode($title), array('view', 'id'=>$data->auto_id, 'gorod'=>$data->user->city->translit)); ?>
    </div>
    
    <?php $info = Modification::getInfoArray(); ?>
    <div class="product_mod_control">
        <?php echo CHtml::encode($info['control'][$data->modification->mod_control]) ?>
    </div>
    <div class="product_mod_fuel">
        <?php echo CHtml::encode($info['control'][$data->modification->mod_fuel]) ?>
    </div>
    
    <div class="product_price">
        <?php echo CHtml::encode(Functions::priceFormat($data->auto_price)); ?>
        <span style="color:#4b4b51">р.</span>
    </div>
    
    <div class="product_time">
        <?php echo CHtml::encode(Functions::when_it_was($data->auto_public_date, true)); ?>
    </div>
    
    <?php if (Functions::diffDate(time(), $data->auto_public_date) < 60 * 60 * 24): ?>
        <span class="product_add"></span>
    <?php endif; ?>

</div>