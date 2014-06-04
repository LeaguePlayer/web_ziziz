<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'company_name'); ?>
		<?php echo $form->textField($model,'company_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'company_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'company_address'); ?>
		<?php echo $form->textField($model,'company_address',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'company_address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'company_ymap_pos1'); ?>
		<?php echo $form->textField($model,'company_ymap_pos1'); ?>
		<?php echo $form->error($model,'company_ymap_pos1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'company_ymap_pos2'); ?>
		<?php echo $form->textField($model,'company_ymap_pos2'); ?>
		<?php echo $form->error($model,'company_ymap_pos2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'company_user_id'); ?>
		<?php echo $form->textField($model,'company_user_id'); ?>
		<?php echo $form->error($model,'company_user_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->