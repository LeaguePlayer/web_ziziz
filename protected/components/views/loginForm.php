<?php $form=$this->beginWidget('CActiveForm', array(
    //'action' => 'site/login',
    'id'=>'login-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        //'validateOnSubmit'=>true,
	),
)); ?>
    <?php echo $form->textField($model, 'url', array(
		'hidden'=>true,
		'value'=>Yii::app()->request->url,
	)); ?>
	<?php echo $form->textField($model, 'username',array('id'=>'login', 'placeholder'=>'Ваш логин')); ?>
    <?php echo $form->passwordField($model,'password',array('id'=>'pass', 'placeholder'=>'Ваш пароль')); ?>
    <?php echo CHtml::submitButton('Вход',array('id'=>'in', /*'submit'=>'users/login'*/)); ?>
    <a id="registr" href="<?php echo Yii::app()->createUrl('users/registration')?>">Регистрация</a>
    <div id="checkboxDiv" class="checkboxOff">
   	    <label>
			<?php echo $form->checkBox($model,'rememberMe');
			?>
            <span class="text_remember">Запомнить меня</span>
        </label>
    </div>
    <a id="recall" href="<?php echo Yii::app()->createUrl('users/recall'); ?>">Забыли пароль?</a>
<?php $this->endWidget(); ?>