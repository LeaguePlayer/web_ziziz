<h1>Отправка сообщения</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'messages-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, отмеченные <span class="required">*</span> обязательны для заполнения.</p>

    <?php if($model->getScenario() != 'to_admin' ): ?>
        <div class="row">
    		<?php echo $form->labelEx($model,'subject'); ?>
    		<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>256)); ?>
    		<?php echo $form->error($model,'subject'); ?>
    	</div>
    <?php endif; ?>

	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'text'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Отправить', array('class'=>'default-button', 'style'=>'width: 100px;')); ?>
        <?php if (!Yii::app()->request->isAjaxRequest) echo CHtml::submitButton('Отмена', array('name'=>'message_cancel', 'class'=>'default-button', 'style'=>'width: 100px;')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->