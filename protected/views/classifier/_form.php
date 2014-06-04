<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'classifier-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="Поля, отмеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'classif_name'); ?>
		<?php echo $form->textField($model,'classif_name',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'classif_name'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->