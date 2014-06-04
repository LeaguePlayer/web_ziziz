<?php
$this->pageTitle = "Продажа автомобилей на ZIZIZ, доска объявлений в городе ".Citys::model()->findByPk($city_id)->city_name.' - '.$model->ann_name;

$this->breadcrumbs=array(
	'Объявления'=>array('index'),
	$model->ann_name,
);
?>

<div id="product">
    <div class="top">
   	    <h1><?=$model->ann_name ?></h1>
        <span class="id_product" hidden="hidden"><?=$model->ann_id?></span>
    </div>
    <div class="bottom">
        <div class="left">
       	    <div class="left_img">
            <?php if ($model->gall->photoCount > 0): ?>
                <div id="big_img">
               	    <div class="image" style="width: 100%; height: 100%; background: url('<?=str_replace('original_','thumbs/big_', $model->gall->original[0]->ph_url)?>') no-repeat center center;"></div>  
                    <a href="<?=CHtml::encode($model->gall->original[0]->ph_url) ?>" class="fancybox" style="visibility: hidden;" rel="rr">
                        <img src="/images/see_in_all.png" width="138" height="59"/>
                    </a>
                </div>
                <?php foreach($model->gall->original as $ph)
                {
                    echo CHtml::link(CHtml::image(CHtml::encode(str_replace('original_','thumbs/mini_',$ph->ph_url)), '', array(
                        'width' => 100,
                        'height' => 75,
                    )), $ph->ph_url, array(
                        'style' => 'border: 1px solid rgb(255, 255, 255);',
                        'rel' => 'rr',
                    ));
                }
                ?>
            <?php else: ?>
                <div id="big_img" style="background: url('/images/no-photo2.png') no-repeat center center;">
                </div>
            <?php endif; ?>
                        
            </div>
            
            <?php if(Yii::app()->user->id === $model->ann_user_id): ?>
                <a class="default-button" href="<?=$this->createUrl('announcements/update', array('id'=>$model->ann_id)) ?>" style="width: 149px;">Редактировать</a>
                <a class="default-button" href="<?=$this->createUrl('announcements/delete', array('id'=>$model->ann_id)) ?>" style="width: 149px;">Удалить</a>
            <?php endif; ?>
            
        </div>
        <div class="right">
            <div class="price">
                <div class="price_start">
               	    <div>Цена:</div>
                    <div class="product_price"><?=Functions::priceFormat($model->ann_price); ?><span style="color:#4b4b51"> р.</span></div>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="row">
            	<div class="text_title_row">Город:</div>
                <div class="desc_row"><?=$model->user->city->city_name?></div>
            </div>
            <div class="row">
           	    <div class="text_title_row">Продавец:</div>
                <div class="desc_row">
                    <div class="seler_icon"></div>
                	<div style="float: left; height: 100%; margin-left: 2px;"><a href="<?=$this->createUrl('users/view', array('id'=>$model->ann_user_id))?>"><?=$model->user->user_login ?></a></div>
                    <span class="count"><?=($model->user===null) ? 0 : $model->user->allPostCount() ?></span>
                    <?php if ($model->ann_user_id != Yii::app()->user->id)
                        echo CHtml::link('Задать вопрос продавцу', $this->createUrl('comments/create', array('ann_id' => $model->ann_id)), array(
                            'class' => 'query ajaxfancybox',
                        ))
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="text_title_row">Телефон</div>
                <div class="desc_row"><?=CHtml::encode($model->user->user_phone) ?></div>
            </div>
            <?php if (!empty($model->model_id)): ?>
            <div class="row">
            	<div class="text_title_row">Для автомобиля:</div>
                <div class="desc_row"><?=$model->automodel->modelbrend->b_name.", ".$model->automodel->m_name ?></div>
            </div>
            <?php endif; ?>
            <div class="row">
            	<div class="text_title_row">Состояние товара:</div>
                <div class="desc_row">
                    <div class="state_icon"></div>
                	<div style="float: left; height: 100%; margin-left: 2px;"><?php echo Lookup::item(Lookup::PRODUCT_STATE, $model->ann_state) ?></div>
                </div>
            </div>
            <?php foreach ($model->values as $value): ?>
            <div class="row">
            	<div class="text_title_row"><?=$value->classif->classif_name ?>:</div>
                <div class="desc_row"><?=$value->cv_value ?></div>
            </div>
            <?php endforeach; ?>
            <div class="favor_complain">
            	 <?php
                    $session = Yii::app()->session;
                    $session->open();
                    $session['return_url'] = $this->createUrl('messages/create', array('type'=>'complain'));
                    $session->close();
                ?>
                <?=CHtml::link('Пожаловаться', $this->createUrl('messages/create', array('type'=>'complain')), array('id'=>'complain', 'class'=>'ajaxfancybox'))?>
            </div>
            
            <?php if(!empty($model->ann_desc)): ?>
            <div class="row_content">
            	<span class="text_row_title">Описание</span>
                <?php echo CHtml::encode($model->ann_desc) ?>
            </div>
            <?php endif; ?>
            
            <?php if(count($model->commentBranchs)>0): ?>
            <div id="user-comments" class="comments">
                <div class="row_content">
                	<span class="text_row_title">Вопросы и ответы</span>
                 </div>
                 
                <?php foreach($model->commentBranchs as $branch): ?>
                    <div class="comment-branch">
                        <?php foreach($branch->comments as $comment): ?>
                            <div class="comment-row">
                                <?php if ($comment->author)
                                {
                                    $seler_text = ($comment->author->user_id == $model->ann_user_id) ? "Продавец " : "Пользователь ";
                                    $author = $seler_text . Chtml::link(
                                        $comment->author->user_login,
                                        $this->createUrl('users/view', array('id'=>$comment->author->user_id))
                                    );
                                }
                                else
                                    $author = 'Пользователь';
                                ?>
                                <div class="comment-title">
                                    <span class="comment-author"><?=$author?></span>
                                    <span class="comment-date"><?=Functions::when_it_was($comment->date_public)?></span>
                                </div>
                                <div class="comment-text"><?=$comment->text?></div>
                            </div>
                        <?php endforeach; ?>
                        <a class="button-answer ajaxfancybox" href="<?= $this->createUrl('comments/create', array('ann_id'=>$model->ann_id, 'branch_id'=>$branch->id)) ?>">
                            <?= ($model->ann_user_id==Yii::app()->user->id) ? "Ответить" : "Задать вопрос" ?>
                        </a>
                    </div>
                <?php endforeach; ?>
                
            </div>
            <?php endif; ?>
                
        </div>
    </div>
</div>

<script>
    
    $("#moderation_menu").click(function() {
    	$('#moderation_submenu').slideToggle('fast');
        return false;
    });
    
    $("#moderation_submenu li a").click(function() {
        $.ajax({
            url: '/announcements/moderation',
            type: 'POST',
            data: {
                ajax: '1',
                ann_id: $("#product .id_product").text(),
                ann_status: $(this).attr('rel')
            },
            success: function(data) {
                alert(data);
                $('#moderation_submenu').slideToggle('fast');
            }
        });
        return false;
    });
</script>