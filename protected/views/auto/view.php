
<?php
    $this->pageTitle = "Продажа автомобилей на ZIZIZ, доска объявлений в городе ".Citys::model()->findByPk($city_id)->city_name.' - '.$model->auto_title;
    $modctrl = Yii::app()->createController('modification');
    $info = $modctrl[0]->getInfoArray();
?>

<?php
$this->breadcrumbs=array(
	'Автообъявления'=>array('index'),
	$model->auto_title,
);
?>
<?php
//$this->menu=array(
//	array('label'=>'Список', 'url'=>array('index')),
//	array('label'=>'Создать', 'url'=>array('create')),
//	array('label'=>'Обновить', 'url'=>array('update', 'id'=>$model->auto_id)),
//	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->auto_id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage Announcements', 'url'=>array('admin')),
//);
?>


<div id="product">
    <div class="top">
   	    <h1><?=$model->auto_title ?></h1>
        <span class="id_product" hidden="hidden"><?=$model->auto_id?></span>
    </div>
    <div class="bottom">
        <div class="left">
       	    <div class="left_img">
            <?php if ($model->gall->photoCount > 0): ?>
                <div id="big_img">
               	    <div class="image" style="width: 100%; height: 100%; background: url('<?=str_replace('original_','thumbs/big_', $model->gall->original[0]->ph_url)?>') no-repeat center center;"></div>  
                    <a href="<?=CHtml::encode($model->gall->original[0]->ph_url) ?>" class="fancybox" style="visibility: hidden; " rel="rr">
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
            
            <?php if(Yii::app()->user->id === $model->auto_user): ?>
                <a class="default-button" href="<?=$this->createUrl('auto/update', array('id'=>$model->auto_id)) ?>" style="width: 149px;">Редактировать</a>
                <a class="default-button" href="<?=$this->createUrl('auto/delete', array('id'=>$model->auto_id)) ?>" style="width: 149px;">Удалить</a>
            <?php endif; ?>
            
        </div>
        <div class="right">
            <div class="price">
                <div class="price_start">
               	    <div>Цена:</div>
                    <div class="product_price"><?=Functions::priceFormat($model->auto_price) ?><span style="color:#4b4b51"> р.</span></div>
                    <div class="clear"></div>
                </div>
            </div>
            
            <div class="row">
           	    <div class="text_title_row">Продавец:</div>
                <div class="desc_row">
                    <div class="seler_icon"></div>
                    <div style="float: left; height: 100%; margin-left: 2px;"><a href="<?=$this->createUrl('users/view', array('id' => $model->auto_user))?>"><?=$model->user->user_login; ?></a></div>
                    <span class="count"><?=($model->user===null) ? 0 : $model->user->allPostCount() ?></span>
                    <?php if ($model->auto_user != Yii::app()->user->id)
                        echo CHtml::link('Задать вопрос продавцу', $this->createUrl('commentsAuto/create', array('auto_id' => $model->auto_id)), array(
                            'class' => 'query ajaxfancybox',
                        ))
                    ?>
                </div>
            </div>

            <div class="row">
            	<div class="text_title_row">Телефон</div>
                <div class="desc_row"><?=CHtml::encode($model->user->user_phone) ?></div>
            </div>
            
            <?php if($model->auto_carcass!=0): ?>
            <div class="row">
            	<div class="text_title_row">Кузов</div>
                <div class="desc_row"><?=CHtml::encode($info['kuzov'][$model->auto_carcass]) ?></div>
            </div>
            <?php endif; ?>
            
            <?php if($model->auto_fuel!=0): ?>
            <div class="row">
            	<div class="text_title_row">Топливо</div>
                <div class="desc_row"><?=CHtml::encode($info['fuel'][$model->auto_fuel]) ?></div>
            </div>
            <?php endif; ?>
            
            <?php if($model->auto_control!=0): ?>
            <div class="row">
            	<div class="text_title_row">Положение руля</div>
                <div class="desc_row"><?=CHtml::encode($info['control'][$model->auto_control]) ?></div>
            </div>
            <?php endif; ?>
            
            <?php if($model->auto_box!=0): ?>
            <div class="row">
            	<div class="text_title_row">КПП</div>
                <div class="desc_row"><?=CHtml::encode($info['kpp'][$model->auto_box]) ?></div>
            </div>
            <?php endif; ?>
            
            <?php if($model->auto_drive!=0): ?>
            <div class="row">
            	<div class="text_title_row">Привод</div>
                <div class="desc_row"><?=CHtml::encode($info['drive'][$model->auto_drive]) ?></div>
            </div>
            <?php endif; ?>
            
            <?php if($model->auto_vol!=0): ?>
            <div class="row">
            	<div class="text_title_row">Объем двигателя</div>
                <div class="desc_row"><?=CHtml::encode($model->auto_vol) ?></div>
            </div>
            <?php endif; ?>
            
            <div class="row">
            	<div class="text_title_row">Пробег</div>
                <div class="desc_row"><?=CHtml::encode(($model->auto_run==0).' км' ? 'Без пробега' : $model->auto_run) ?></div>
            </div>
            
            <?php if($model->auto_year!=0): ?>
            <div class="row">
            	<div class="text_title_row">Год выпуска</div>
                <div class="desc_row"><?=CHtml::encode($model->auto_year) ?></div>
            </div>
            <?php endif; ?>
            
            <div>
                <?php
                    $session = Yii::app()->session;
                    $session->open();
                    $session['return_url'] = $this->createUrl('messages/create', array('type'=>'complain'));
                    $session->close();
                ?>
                <?=CHtml::link('Пожаловаться', $this->createUrl('messages/create', array('type'=>'complain')), array('id'=>'complain', 'class'=>'ajaxfancybox'))?>
            </div>
            
            <?php if(!empty($model->auto_desc)): ?>
            <div class="row_content">
            	<span class="text_row_title">Описание</span>
                <?php echo CHtml::encode($model->auto_desc) ?>
            </div>
            <?php endif; ?>
            
            <?php if(count($model->commentBranchs)>0): ?>
            <div id="user-comments" class="comments">
                <div class="row_content">
                	<span class="text_row_title">Вопросы и ответы</span>
                 </div>
                 
                 <?php foreach($model->commentBranchs as $branch): ?>
                    <div id="branch-<?=$branch->id?>" class="comment-branch">
                        <?php foreach($branch->comments as $comment): ?>
                            <div class="comment-row">
                                <?php if ($comment->author)
                                {
                                    $seler_text = ($comment->author->user_id == $model->auto_user) ? "Продавец " : "Пользователь ";
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
                        <a class="button-answer ajaxfancybox" href="<?= $this->createUrl('commentsAuto/create', array('auto_id'=>$model->auto_id, 'branch_id'=>$branch->id)) ?>">
                            <?= ($model->auto_user==Yii::app()->user->id) ? "Ответить" : "Задать вопрос" ?>
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