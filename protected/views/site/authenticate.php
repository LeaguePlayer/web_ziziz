
<h1 id="authenticate-form">Авторизация на сайте</h1>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'method'=>'POST',
)); ?>
    
    <?php echo $form->hiddenField($model, 'url'); ?>
    
    <?php //echo $form->errorSummary($model) ?>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model, 'username',array('id'=>'login', 'placeholder'=>'Ваш логин', 'style'=>'width: 260px;')); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('id'=>'pass', 'placeholder'=>'Ваш пароль', 'style'=>'width: 260px; margin-top: 0;')); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
    
    <div class="row" style="overflow: hidden;">
        <div id="checkboxDiv" class="checkbox<?=$model->rememberMe ? 'On' : 'Off'?>" style="width: 20px;">
   	        <label>
		      <?php echo $form->checkBox($model,'rememberMe'); ?>
            </label>
        </div>
        <?php echo $form->labelEx($model,'rememberMe'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Вход', array('class'=>'default-button', 'style'=>'width: 70px;')); ?>
        или <a href="<?=$urlReferrer?>">Отмена</a>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
