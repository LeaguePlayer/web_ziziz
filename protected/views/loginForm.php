<form method="post" action="" name="auth">
    <input type="text" name="login" id="login" placeholder="Ваш логин" />
    <input type="text" name="pass" id="pass" placeholder="Ваш пароль" />
    <input type="submit" name="submit" id="in" value="Вход" />
    <a id="registr" href="#registr">Регистрация</a>
    <div id="rememberDiv" class="checkboxOff">
   	    <label><input type="checkbox" id="remember" name="remember" onclick="logincheckboxCheck();" class="checkboxOff" value="1"/>
        <span class="text_remember">Запомнить меня</span><label>
    </div>
    <a id="recall" href="#recal">Забыли пароль?</a>
</form>
<?php /*
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<h1>Login</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
		<p class="hint">
			Hint: You may login with <tt>demo/demo</tt> or <tt>admin/admin</tt>.
		</p>
	</div>

	<div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Login'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
*/