<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comments-form',
	'enableAjaxValidation'=>false,
)); ?>
	
		<?php echo $form->labelEx($model,'text'); ?>
		<?php echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'text'); ?>
	

	<div class="row_buttons">
		<?php echo CHtml::submitButton('Отправить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->