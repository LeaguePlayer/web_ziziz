<h1>Восстановление пароля</h1></h1>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'recall-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>

<p>Введите Ваш e-mail</p>
<?php echo CHtml::textField('email', '', array('id'=>'email')); ?>
<a href="<?php echo Yii::app()->createUrl('recall/send'); ?>">Отправить</a>
<?php echo CHtml::submitButton('Отправить',array('submit'=>'recall/send')); ?>
<a href="<?php echo Yii::app()->homeUrl?>">На главную</a>

<?php $this->endWidget(); ?>