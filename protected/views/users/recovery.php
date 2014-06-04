<?php $this->pageTitle = "ZIZIZ | Восстановление пароля" ?>

<h1>Восстановление пароля</h1>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>$this->createUrl('users/recovery'),
    	'id'=>'recovery-form',
    	'enableAjaxValidation'=>false,
    )); ?>
    
    	<?php if ($form->error($model, 'key')): ?>
			<?php echo $form->error($model, 'key'); ?>
            <a href="<?php echo Yii::app()->homeUrl?>" style="margin-top: 10px; display: block;">На главную</a>
		<?php else: ?>
        
            <p class="note">Поля, отмеченные <span class="required">*</span> обязательны для заполнения.</p>
        
            <input name="RecoveryForm[email]" type="text" value="<?=$model->email?>" style="display:none;" />
            <input name="RecoveryForm[key]" type="text" value="<?=$model->key?>" style="display:none;" />
		
	        <div class="row">
	        	<?php echo $form->labelEx($model,'pass'); ?>
	        	<?php echo $form->passwordField($model, 'pass', array('size'=>50)); ?>
                <?php echo $form->error($model,'pass'); ?>                
	        </div>
	        
	        <div class="row">
	        	<?php echo $form->labelEx($model,'compare_pass'); ?>
	        	<?php echo $form->passwordField($model, 'compare_pass', array('size'=>50)); ?>
                <?php echo $form->error($model,'compare_pass'); ?>                
	        </div>
	        
	        <div class="row buttons">
	    		<?php echo CHtml::submitButton('Принять', array(
                    'class'=>'default-button',
                )); ?> <span class="default-text">или</span> <a href="<?php echo Yii::app()->homeUrl?>">Отмена</a>
	    	</div>
	    	
		<?php endif; ?>
    <?php $this->endWidget(); ?>

</div><!-- form -->