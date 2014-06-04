
<h1><?=($model->user_type==Users::USERTYPE_PHYS_PERSON) ? 'Регистрация - Шаг 2' : 'Регистрация юридического лица - Шаг 2'?></h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'action' => array('users/registration', 'backform'=>2),
	'id'=>'users-form',
	'enableAjaxValidation'=>false,
)); ?>
    <?php $info = $this->getInfoArray();?>
	<p class="note">Поля отмеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>
    
    <?php echo $form->textField($model,'user_type',array('style'=>'display: none;')); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_cityname'); ?>
        
        <?php
            foreach(Citys::model()->findAll(array('order'=>'city_name')) as $city)
                $listdata[] = $city->city_name;
        ?>
        
		<?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                  'model'=>$model,
                  'attribute'=>'user_cityname',
                  'source'=>$listdata,
                  // additional javascript options for the autocomplete plugin
                  'options'=>array(
                      'minLength'=>'2',
                  ),
                  'htmlOptions'=>array(
                      'style'=>'height:25px; width: 320px;'
                  ),
          ));?>
          
          
          
  <script>

    $('#Users_user_cityname').keyup(function(){
        if($(this).val()=='г.' || $(this).val()=='г ' || $(this).val()=='город')
            $(this).val('');
    });

</script>


		<?php echo $form->error($model,'user_cityname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_fio'); ?>
		<?php echo $form->textField($model,'user_fio',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'user_fio'); ?>
	</div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'user_login'); ?>
		<?php echo $form->textField($model,'user_login',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'user_login'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_email'); ?>
		<?php echo $form->textField($model,'user_email',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'user_email'); ?>
	</div>
        
    <div class="row" style="overflow: hidden; margin-bottom: 10px;">
        <div id="checkboxDiv" class="checkbox<?=$model->email_notice ? 'On' : 'Off'?>" style="width: 20px;"><label>
            <?php echo $form->checkBox($model, 'email_notice'); ?>
        </label></div>
        <?php echo $form->labelEx($model,'email_notice'); ?>
		<?php echo $form->error($model,'email_notice'); ?>
	</div>

    <?php if (Yii::app()->user->checkAccess('root')): ?>
    <div class="row">
		<?php echo $form->labelEx($model,'user_role'); ?>
		<?php echo $form->dropDownList($model,'user_role',$info['role']);?>
		<?php echo $form->error($model,'user_role'); ?>
	</div>
    <?php endif; ?>

    <div class="row">
        <?php echo $form->labelEx($model,'user_pass'); ?>
		<?php echo $form->passwordField($model,'user_pass',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'user_pass'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'compare_pass'); ?>
		<?php echo $form->passwordField($model,'compare_pass',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'compare_pass'); ?>
    </div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'user_phone'); ?>
        <?php $this->widget('CMaskedTextField', array(
                'model'=> $model,
                'attribute' => 'user_phone',
                'mask' => '7(999)999-99-99')
        );?>
		<?php echo $form->error($model,'user_phone'); ?>
	</div>
    
	<div class="row buttons">
		<?php echo CHtml::submitButton(($model->user_type == 1) ? 'Сохранить' : 'Далее', array('class'=>'default-button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->