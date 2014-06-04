<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'carmodel-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'m_name'); ?>
		<?php echo $form->textField($model,'m_name',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'m_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'m_brend_id'); ?>
		<?php echo $form->textField($model,'m_brend_id'); ?>
		<?php echo $form->error($model,'m_brend_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->