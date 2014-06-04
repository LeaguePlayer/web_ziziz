<?php
$this->pageTitle = "ZIZIZ | Просмотр сообщений";

$this->breadcrumbs=array(
    'Личный кабинет'=>array('users/view', 'id'=>Yii::app()->user->id),
    'Сообщения'=>array('index'),
	$model->subject
);
?>

<h1>Просмотр сообщения - <?=$model->subject?></h1>

    <div class="row">
        <span class="message-title">Заголовок: </span>
        <span class="message-subject">
         <?php
            if (!empty($model->post_id))
            {
                switch ($model->post_type)
                {
                    case 'ann':
                        $post = Announcements::model()->findByPk($model->post_id);
                        echo CHtml::link($post->ann_name, $this->createUrl('announcements/view', array('id'=>$model->post_id, 'gorod'=>$post->user->city->translit, '#'=>'user-comments')), array('style'=>'font-weight: bold;'));
                        break;
                    
                    case 'auto':
                        $post = Auto::model()->findByPk($model->post_id);
                        echo CHtml::link($post->auto_title, $this->createUrl('auto/view', array('id'=>$model->post_id, 'gorod'=>$post->user->city->translit, '#'=>'user-comments')), array('style'=>'font-weight: bold;'));
                        break;
                    
                    case 'act':
                        $post = Actions::model()->findByPk($model->post_id);
                        echo CHtml::link($post->title, $this->createUrl('actions/view', array('id'=>$model->post_id)), array('style'=>'font-weight: bold;'));
                        break;
                }
            }
            else
                echo 'Без заголовка';
         ?>
        </span>
    </div>

    <div class="row">
        <span class="message-title">От кого: </span>
        <span class="message-sender">
            <?php echo ($model->from == 0) ? "Администрация сайта" : CHtml::link($model->sender->user_login, $this->createUrl('users/view', array('id'=>$model->sender->user_id))) ?>
        </span>
    </div>
    
    <div class="messageonce-text">
        <?php echo CHtml::encode(strip_tags($model->text)); ?>
    </div>
    
    <span class="message-date" style="margin-left: 0;"><?php echo CHtml::encode(Functions::when_it_was($model->send_date)); ?></span>
