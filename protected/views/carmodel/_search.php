<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'m_id'); ?>
		<?php echo $form->textField($model,'m_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'m_name'); ?>
		<?php echo $form->textField($model,'m_name',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'m_brend_id'); ?>
		<?php echo $form->textField($model,'m_brend_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->