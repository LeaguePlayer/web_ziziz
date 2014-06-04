<?php $this->pageTitle=Yii::app()->name. " | Восстановление пароля"; ?>

<h1>Восстановление пароля</h1>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
    	'id'=>'recall-form',
    	'enableAjaxValidation'=>false,
    )); ?>
        
        <p class="note">Поля, отмеченные <span class="required">*</span> обязательны для заполнения.</p>
        
        <div class="row">
            <?php echo $form->error($model,'email'); ?>
        	<?php echo $form->labelEx($model,'email'); ?>
        	<?php echo $form->textField($model, 'email',array('maxlength'=>200, 'size'=>50)); ?>
        </div>
        
        <div class="row buttons">
    		<?php echo CHtml::submitButton('Отправить', array(
                'class'=>'default-button',
            )); ?>
    	</div>
    
    <?php $this->endWidget(); ?>

</div><!-- form -->