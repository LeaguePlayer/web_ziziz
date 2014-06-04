<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ann_id'); ?>
		<?php echo $form->textField($model,'ann_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ann_category'); ?>
		<?php echo $form->textField($model,'ann_category'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ann_name'); ?>
		<?php echo $form->textField($model,'ann_name',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ann_status'); ?>
		<?php echo $form->textField($model,'ann_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ann_user_id'); ?>
		<?php echo $form->textField($model,'ann_user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ann_actual_date'); ?>
		<?php echo $form->textField($model,'ann_actual_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ann_gallery_id'); ?>
		<?php echo $form->textField($model,'ann_gallery_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ann_state'); ?>
		<?php echo $form->textField($model,'ann_state'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ann_public_date'); ?>
		<?php echo $form->textField($model,'ann_public_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ann_desc'); ?>
		<?php echo $form->textArea($model,'ann_desc',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->