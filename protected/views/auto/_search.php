<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'auto_id'); ?>
		<?php echo $form->textField($model,'auto_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'auto_title'); ?>
		<?php echo $form->textField($model,'auto_title',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'auto_user'); ?>
		<?php echo $form->textField($model,'auto_user'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'auto_fuel'); ?>
		<?php echo $form->textField($model,'auto_fuel'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'auto_box'); ?>
		<?php echo $form->textField($model,'auto_box'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'auto_drive'); ?>
		<?php echo $form->textField($model,'auto_drive'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'auto_vol'); ?>
		<?php echo $form->textField($model,'auto_vol',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'auto_run'); ?>
		<?php echo $form->textField($model,'auto_run'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'auto_year'); ?>
		<?php echo $form->textField($model,'auto_year'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'auto_desc'); ?>
		<?php echo $form->textArea($model,'auto_desc',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'auto_public_date'); ?>
		<?php echo $form->textField($model,'auto_public_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'auto_actual_date'); ?>
		<?php echo $form->textField($model,'auto_actual_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'auto_status'); ?>
		<?php echo $form->textField($model,'auto_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'auto_price'); ?>
		<?php echo $form->textField($model,'auto_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'auto_model_id'); ?>
		<?php echo $form->textField($model,'auto_model_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->