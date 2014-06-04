<h1>Изменение пароля</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	'enableAjaxValidation'=>false,
)); ?>
    
    <p class="note">Поля, отмеченные <span class="required">*</span> обязательны для заполнения.</p>

    <div class="row">
        <?php echo $form->labelEx($model,'user_pass'); ?>
    	<?php echo $form->passwordField($model,'user_pass',array('size'=>60,'maxlength'=>100)); ?>
    	<?php echo $form->error($model,'user_pass'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'new_pass'); ?>
    	<?php echo $form->passwordField($model,'new_pass',array('size'=>60,'maxlength'=>100)); ?>
    	<?php echo $form->error($model,'new_pass'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'compare_pass'); ?>
    	<?php echo $form->passwordField($model,'compare_pass',array('size'=>60,'maxlength'=>100)); ?>
    	<?php echo $form->error($model,'compare_pass'); ?>
    </div>
    
    <div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить', array('class'=>'default-button')); ?> или <a href="<?=Yii::app()->user->profileUrl;?>">Отмена</a>
	</div>
    
<?php $this->endWidget(); ?>

</div><!-- form -->