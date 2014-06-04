<h1>Регистрация - Шаг 1</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'action' => array('users/registration', 'backform'=>1),
	'id'=>'users-form',
	'enableAjaxValidation'=>false,
)); ?>
    <?php $info = $this->getInfoArray();?>
    
    <div class="row">
		<?php echo $form->labelEx($model,'user_type'); ?>
        
        <div class="drop_list unexpand">
            <div class="drop_button"></div>
            <?php $listdata = $info['type']; ?>
            <span class="selected_value"><?=$listdata[1]?></span>
            <?php echo $form->dropDownList($model,'user_type',$info['type']); ?>
            <div class="select_options">
            	<?php
            	foreach($listdata as $key => $item)
            	{
                    $selected = ($key==1) ? ' selected' : '';
            		echo CHtml::openTag('div', array('class'=>'select_option'.$selected, 'value'=>$key));
            		echo $item;
            		echo CHtml::closeTag('div');
            	}
            	?>
            </div>
        </div>
		
		<?php echo $form->error($model,'user_type'); ?>
	</div>
    
	<div class="row buttons">
		<?php echo CHtml::submitButton('Далее', array('class'=>'default-button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->