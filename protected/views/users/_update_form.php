<?php/*
// $model - Users
*/?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'action' => array('users/registration', 'step'=>2, 'finish'=>($model->user_type == 1) ? true : false),
	'id'=>'users-form',
	'enableAjaxValidation'=>false,
)); ?>
    <?php $info = $this->getInfoArray();?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
    
    <?php echo $form->textField($model,'user_type',array('hidden'=>true)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_city_id'); ?>
		<?php echo $form->dropDownList($model,'user_city_id',CHtml::listData(Citys::model()->findAll(array('order'=>'city_name')), 'city_id', 'city_name')); ?>
		<?php echo $form->error($model,'user_city_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_fio'); ?>
		<?php echo $form->textField($model,'user_fio',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'user_fio'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_phone'); ?>
        <?php $this->widget('CMaskedTextField', array(
                'model'=> $model,
                'attribute' => 'user_phone',
                'mask' => '7(999)999-99-99')
            );?>
		<?php //echo $form->textField($model,'user_phone',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'user_phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_email'); ?>
		<?php echo $form->textField($model,'user_email',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'user_email'); ?>
	</div>

    <?php if (Yii::app()->user->checkAccess('root')): ?>
    <div class="row">
		<?php echo $form->labelEx($model,'user_role'); ?>
		<?php echo $form->dropDownList($model,'user_role',$info['role']);?>
		<?php echo $form->error($model,'user_role'); ?>
	</div>
    <?php endif; ?>
        
    <div>
        <?php echo $form->labelEx($model,'user_login'); ?>
		<?php echo $form->textField($model,'user_login',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'user_login'); ?>
    </div>
    <div>
        <?php echo $form->labelEx($model,'user_pass'); ?>
		<?php echo $form->passwordField($model,'user_pass',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'user_pass'); ?>
    </div>
    
    <div>
        <?php echo $form->labelEx($model,'compare_pass'); ?>
		<?php echo $form->passwordField($model,'compare_pass',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'compare_pass'); ?>
    </div>
    
	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить', array('class'=>'default-button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->