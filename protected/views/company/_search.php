<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'company_id'); ?>
		<?php echo $form->textField($model,'company_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'company_name'); ?>
		<?php echo $form->textField($model,'company_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'company_address'); ?>
		<?php echo $form->textField($model,'company_address',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'company_ymap_pos1'); ?>
		<?php echo $form->textField($model,'company_ymap_pos1'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'company_ymap_pos2'); ?>
		<?php echo $form->textField($model,'company_ymap_pos2'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'company_user_id'); ?>
		<?php echo $form->textField($model,'company_user_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->