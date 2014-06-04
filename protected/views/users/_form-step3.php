

<h1>Регистрация - Шаг 3</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'action' => array('users/registration', 'backform'=>3),
	'id'=>'users-form',
	'enableAjaxValidation'=>false,
)); ?>
	<p class="note">Поля отмеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php ;//echo $form->errorSummary($model); ?>
    
    <?php echo $form->textField($model,'user_type',array('style'=>'display: none;')); ?>
    <?php echo $form->textField($model,'user_city_id',array('style'=>'display: none;')); ?>
    <?php echo $form->textField($model,'user_fio',array('style'=>'display: none;')); ?>
    <?php echo $form->textField($model,'user_phone',array('style'=>'display: none;')); ?>
    <?php echo $form->textField($model,'user_email',array('style'=>'display: none;')); ?>
    <?php echo $form->textField($model,'email_notice',array('style'=>'display: none;')); ?>
    <?php echo $form->textField($model,'user_role',array('style'=>'display: none;')); ?>
    <?php echo $form->textField($model,'user_login',array('style'=>'display: none;')); ?>
    <?php echo $form->textField($model,'user_pass',array('style'=>'display: none;')); ?>
    <?php echo $form->textField($model,'compare_pass',array('style'=>'display: none;')); ?>
    
    <h3><?=Citys::model()->findByPk($model->user_city_id)->city_name?></h3>
    
    <div class="row">
		<?php echo $form->labelEx($company,'company_type'); ?>
        
        <div class="drop_list unexpand" style="width: 330px;">
            <div class="drop_button"></div>
            <?php
                //$listdata = Lookup::model()->items(Lookup::COMPANY_TYPE);
                $listdata = CHtml::listData(Company::types(), 'name', 'label');
                $selected_value = $company->company_type;
            ?>
            <span class="selected_value"><?=$listdata[$selected_value]?></span>
            <?php echo $form->dropDownList($company,'company_type', $listdata, array(
                'options'=>array(
                    $selected_value => array('selected'=>'selected'),
                ),
            )); ?>
            <div class="select_options">
            	<?php
            	foreach($listdata as $key => $item)
            	{
                    $selected = ($key==$selected_value) ? ' selected' : '';
            		echo CHtml::openTag('div', array('class'=>'select_option'.$selected, 'value'=>$key));
            		echo $item;
            		echo CHtml::closeTag('div');
            	}
            	?>
            </div>
        </div>
        
		<?php echo $form->error($company,'company_type'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($company,'company_name'); ?>
		<?php echo $form->textField($company,'company_name',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($company,'company_name'); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($company,'company_address', array('style'=>'display: inline;')); ?><p class="note" style="display: inline;"> (название улицы и номер здания)</p>
		<?php echo $form->textField($company,'company_address',array('size'=>60,'maxlength'=>200, 'style'=>'display: block;')); ?>
		<?php echo $form->error($company,'company_address'); ?>
	</div>
    
    <div class="row">
        <div id="checkboxDiv" class="checkbox<?=$company->show_on_map ? 'On' : 'Off'?>" style="width: 20px;"><label>
            <?php echo $form->checkBox($company, 'show_on_map'); ?>
        </label></div>
        <?php echo $form->labelEx($company,'show_on_map'); ?>
		<?php echo $form->error($company,'show_on_map'); ?>
	</div>
    
	<div class="row buttons">
        <?php echo CHtml::submitButton('Назад', array('name'=>'Users[back]', 'class'=>'default-button')); ?>
		<?php echo CHtml::submitButton('Сохранить', array('class'=>'default-button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->