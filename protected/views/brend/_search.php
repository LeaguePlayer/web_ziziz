<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'b_id'); ?>
		<?php echo $form->textField($model,'b_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'b_name'); ?>
		<?php echo $form->textField($model,'b_name',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->