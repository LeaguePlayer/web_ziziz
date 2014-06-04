<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'mod_id'); ?>
		<?php echo $form->textField($model,'mod_id', array('class'=>'reset')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mod_carcass'); ?>
		<?php echo $form->textField($model,'mod_carcass'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mod_fuel'); ?>
		<?php echo $form->textField($model,'mod_fuel'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mod_control'); ?>
		<?php echo $form->textField($model,'mod_control'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mod_box'); ?>
		<?php echo $form->textField($model,'mod_box'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mod_drive'); ?>
		<?php echo $form->textField($model,'mod_drive'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mod_vol'); ?>
		<?php echo $form->textField($model,'mod_vol'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mod_year'); ?>
		<?php echo $form->textField($model,'mod_year'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->