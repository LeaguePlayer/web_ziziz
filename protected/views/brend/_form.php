<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'brend-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'b_name'); ?>
		<?php echo $form->textField($model,'b_name',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'b_name'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->