<?php
    $this->pageTitle = "ZIZIZ | Редактирование профиля";
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	'enableAjaxValidation'=>false,
)); ?>
    <?php $info = $this->getInfoArray();?>
	<p class="note">Поля, отмеченные <span class="required">*</span> обязательны для заполнения.</p>

	<div class="row">
		<?php echo $form->labelEx($model,'user_city_id'); ?>
        
        <div class="drop_list unexpand" style="width: 330px;">
            <div class="drop_button"></div>
            <?php $listdata = CHtml::listData(Citys::model()->findAll(array('order'=>'city_name')), 'city_id', 'city_name'); ?>
            <?php
                $city_key = $model->user_city_id;
            ?>
            <span class="selected_value"><?=$listdata[$city_key]?></span>
            <?php echo $form->dropDownList($model,'user_city_id', $listdata, array(
                'options'=>array(
                    $city_key => array('selected'=>'selected'),
                ),
            )); ?>
            <div class="select_options">
            	<?php
            	foreach($listdata as $key => $item)
            	{
                    $selected = ($key==$city_key) ? ' selected' : '';
            		echo CHtml::openTag('div', array('class'=>'select_option'.$selected, 'value'=>$key));
            		echo $item;
            		echo CHtml::closeTag('div');
            	}
            	?>
            </div>
        </div>
        
		<?php echo $form->error($model,'user_city_id'); ?>
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
                'mask' => '7(999)999-99-99',
                'htmlOptions'=>array('style'=>'width: 320px;')
                )
            );?>
		<?php echo $form->error($model,'user_phone'); ?>
	</div>
    
    <?php if ($model->user_type == Users::USERTYPE_JUR_PERSON): ?>
    
    <fieldset>
        <legend>Карточка юр. лица</legend>
        <div class="row">
    		<?php echo $form->labelEx($company,'company_type'); ?>
            
            <div class="drop_list unexpand" style="width: 317px;">
                <div class="drop_button"></div>
                <?php $listdata = Lookup::model()->items(Lookup::COMPANY_TYPE); ?>
                <span class="selected_value"><?=$listdata[$company->company_type]?></span>
                <?php echo $form->dropDownList($company,'company_type',$listdata); ?>
                <div class="select_options">
                	<?php
                	foreach($listdata as $key => $item)
                	{
                        $selected = ($key==$company->company_type) ? ' selected' : '';
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
    		<?php echo $form->textField($company,'company_name',array('size'=>60,'maxlength'=>200, 'style'=>'width: 308px;')); ?>
    		<?php echo $form->error($company,'company_name'); ?>
    	</div>
        
        <div class="row">
    		<?php echo $form->labelEx($company,'company_address'); ?>
    		<?php echo $form->textField($company,'company_address',array('size'=>60,'maxlength'=>200, 'style'=>'width: 308px;')); ?>
    		<?php echo $form->error($company,'company_address'); ?>
    	</div>
        
        <div class="row">
            <div id="checkboxDiv" class="checkbox<?=$company->show_on_map ? 'On' : 'Off'?>" style="width: 20px;"><label>
                <?php echo $form->checkBox($company, 'show_on_map'); ?>
            </label></div>
            <?php echo $form->labelEx($company,'show_on_map'); ?>
    		<?php echo $form->error($company,'show_on_map'); ?>
    	</div>
        
     </fieldset>
    <?php endif; ?>
    
	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить', array('class'=>'default-button')); ?>  или <a href="<?=Yii::app()->user->profileUrl;?>">Отмена</a>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->