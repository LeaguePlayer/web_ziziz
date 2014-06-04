<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'classif_id'); ?>
		<?php echo $form->textField($model,'classif_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'classif_name'); ?>
		<?php echo $form->textField($model,'classif_name',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->