<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, отмеченные <span class="required">*</span> обязательн для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>
    <?php
        $arrCats = CHtml::listData($model->findAll(), 'cat_id', 'cat_name');
        $arrCats[0] = 'Нет';
        ksort($arrCats);
        //print_r($arrCats);
    ?>
	<div class="row">
		<?php echo $form->labelEx($model,'cat_name'); ?>
		<?php echo $form->textField($model,'cat_name',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'cat_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cat_parent'); ?>
        <?php echo $form->dropDownList($model,'cat_parent',$arrCats);?>
		<?php //echo $form->textField($model,'cat_parent'); ?>
		<?php echo $form->error($model,'cat_parent'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->