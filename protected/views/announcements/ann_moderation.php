<?php
$this->pageTitle = "ZIZIZ - Модерация";

$this->breadcrumbs=array(
	'Announcements'=>array('index'),
	$model->ann_id,
);
?>

<div id="product">
    <div class="top">
   	    <span class="text_title_product"><?=$model->ann_name ?></span>
        <span class="id_product" hidden="hidden"><?=$model->ann_id?></span>
    </div>
    <div class="bottom">
        <div class="left">
       	    <div class="left_img">
            <?php if (!empty($model->gall)): ?>
                <div id="big_img">
               	    <a href="<?=CHtml::encode($model->gall->original[0]->ph_url) ?>" class="fancybox" rel="rr" style="visibility: hidden; ">
                        <img src="/images/see_in_all.png" width="138" height="59"/>
                    </a>
                    <?= CHtml::image(CHtml::encode($model->gall->original[0]->ph_url), '', array(
                        'width' => 322,
                    )) ?>
                </div>
                <?php foreach($model->gall->original as $ph)
                {
                    echo CHtml::link(CHtml::image(CHtml::encode(str_replace('original_','thumbs/mini_',$ph->ph_url)), '', array(
                        'width' => 100,
                        'height' => 75,
                    )), $ph->ph_url, array(
                        'class' => '',
                        'style' => 'border: 1px solid rgb(255, 255, 255);',
                        //'rel' => 'rr',
                    ));
                }
                ?>
            <?php endif; ?>   
            </div>
        </div>
        <div class="right">
            <div class="price">
                <div class="price_start">
               	    <div>Цена:</div>
                    <div class="product_price"><?=$model->ann_price ?></div>
                    <div class="price_btn">
                   	    <a style="background-image:url(/images/kupit.png); height:30px; padding-top:10px;" href="#"><span style="border-bottom:dashed 1px #ffd304">Купить</span></a>
                    </div>
                    <div class="price_btn">
                   	    <a style="background-image:url(/images/predlojit.png); padding-left:25px; margin-top: 3px; margin-left: 5px;" href="#"><span style="border-bottom:dashed 1px #ffd304">Предложить свою цену</span></a>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            
            <div class="row">
           	    <div class="text_title_row">Продавец:</div>
                <div class="desc_row" style="background-image:url(/images/seler.png);">
                	<a href="#" class="nik"><?=$model->user->user_login ?>
                    <span class="count"><?=$model->user->ann_counts ?></span></a>
                    <?php echo CHtml::link('Задать вопрос продавцу', $this->createUrl('comments/create', array('ann_id' => $model->ann_id)), array(
                        'class' => 'query',
                    )) ?>
                </div>
            </div>
            <div class="row">
            	<div class="text_title_row">Состояние товара:</div>
                <div class="desc_row" style="background-image:url(/images/sostoyanie.png);">
                	<?php echo Lookup::item(Lookup::PRODUCT_STATE, $model->ann_state) ?>
                </div>
            </div>
            <?php foreach ($model->values as $value): ?>
            <div class="row">
            	<div class="text_title_row"><?=$value->classif->classif_name ?>:</div>
                <div class="desc_row"><?=$value->cv_value ?></div>
            </div>
            <?php endforeach; ?>
            <div>
            	<a href="#" id="favorites">Добавить в избранное</a>
                <a href="#" id="complain">Пожаловаться</a>
            </div>
            <div class="row_content">
            	<span class="text_row_title">Описание</span>
                <?php echo CHtml::encode($model->ann_desc) ?>
            </div>
            
            <div class="comments">
                <div class="row_content">
                	<span class="text_row_title">Вопросы и ответы</span>
                 </div>
                 
                <?php foreach($model->comments as $comment): ?>
                    <div class="row_content">
                        <?php if ($comment->autor)
                            $autor = ($comment->autor->user_id == $model->ann_user_id) ? $comment->autor->user_login.' (продавец)' : $comment->autor->user_login;
                        else
                            $autor = 'Гость';
                        
                        ?>
                        <span class="text_row_title"><?=$autor?> - <?=$comment->date_public?></span>
                        <?=$comment->text?>
                    </div>
                <?php endforeach; ?>
                
                <?php $this->renderPartial('_comment_form', array(
                    'model' => $new_comment,
                )) ?>
            </div>
                
        </div>
    </div>
</div>