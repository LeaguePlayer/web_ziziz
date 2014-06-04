
<h1>Вопросы и ответы</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comments-form',
	'enableAjaxValidation'=>false,
)); ?>

    <?php if($branch!==null): ?>
        <div class="comment-branch">
            <?php foreach($branch->comments as $comment): ?>
                <div class="comment-row">
                    <?php if ($comment->author)
                        $author = Chtml::link(
                            ($comment->author->user_id == $branch->auto->auto_user) ? $comment->author->user_login.' (продавец)' : $comment->author->user_login,
                            $this->createUrl('users/view', array('id'=>$comment->author->user_id))
                        ) ;
                    else
                        $author = 'Гость';
                    ?>
                    <div class="comment-title">
                        <span class="comment-author"><?=$author?></span>
                        <span class="comment-date"><?=Functions::when_it_was($comment->date_public)?></span>
                    </div>
                    <div class="comment-text"><?=$comment->text?></div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="row">
        Задайте Ваш вопрос продавцу.
    </div>

	<div class="row">
		<?php echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'text'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Отправить', array('class'=>'default-button', 'style'=>'width: 100px;')); ?>
        <?php if (!Yii::app()->request->isAjaxRequest) echo CHtml::submitButton('Отмена', array('name'=>'comment_cancel', 'class'=>'default-button', 'style'=>'width: 100px;')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->