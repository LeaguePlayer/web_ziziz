<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'autocomments-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'from_user_id'); ?>
		<?php echo $form->textField($model,'from_user_id'); ?>
		<?php echo $form->error($model,'from_user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_public'); ?>
		<?php echo $form->textField($model,'date_public'); ?>
		<?php echo $form->error($model,'date_public'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'viewed'); ?>
		<?php echo $form->textField($model,'viewed'); ?>
		<?php echo $form->error($model,'viewed'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ann_id'); ?>
		<?php echo $form->textField($model,'ann_id'); ?>
		<?php echo $form->error($model,'ann_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model,'type'); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->