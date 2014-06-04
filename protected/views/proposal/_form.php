<h1>Заполните форму</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'proposal-form',
	'enableAjaxValidation'=>false,
)); ?>
    
    <div class="row">
		<?php echo $form->labelEx($model,'user_phone'); ?>
		<?php $this->widget('CMaskedTextField', array(
                'model'=> $model,
                'attribute' => 'user_phone',
                'mask' => '7(999)999-99-99')
        );?>
		<?php echo $form->error($model,'user_phone'); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'user_email'); ?>
		<?php echo $form->textField($model,'user_email',array('size'=>20,'maxlength'=>256, 'style'=>'width: 300px;')); ?>
		<?php echo $form->error($model,'user_email'); ?>
	</div>
    
    
    <style>
        #btn.ui-button {
            background: #E4E4E4;
            background: -moz-linear-gradient(center top , #FBFBFB, #E4E4E4);
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#FBFBFB), color-stop(100%,#E4E4E4));
            background: -webkit-linear-gradient(top, #FBFBFB, #E4E4E4);
            background: -o-linear-gradient(top, #FBFBFB, #E4E4E4);
            background: -ms-linear-gradient(top, #FBFBFB, #E4E4E4);
            background: linear-gradient(top, #FBFBFB, #E4E4E4);
            border: medium none;
            height: 22px;
            left: 267px;
            position: absolute;
            top: 5px;
            float: left;
        }
        #btn.ui-button.ui-state-default .ui-icon {
            background: url("../../images/select-unexpand.png") no-repeat scroll right center transparent;
            height: 4px;
            margin-left: -2px;
            margin-top: -1px;
            width: 20px;
                    
                    
        }
        #Proposal_brend_id_combobox {
            width: 300px;
        }
        
        .select_options{
            width: 300px !important;
        }
    </style>
    
    <div class="row">
		<?php echo $form->labelEx($model,'brend_id'); ?>
		<div style="position: relative;">
            <?php                       
            $this->widget('ext.combobox.EJuiComboBox', array(
                'model' => $model,
                'attribute' => 'brend_id',
                // data to populate the select. Must be an array.
                'data' =>  CHtml::listData(Brend::model()->findAll(), 'b_id', 'b_name'),
                'assoc' => false,
                //'cssFile' => false,
                // options passed to plugin
                'options' => array(
                ),
                // Options passed to the text input
                'htmlOptions' => array('size' => 10),
            )); ?>
        </div>        
		<?php echo $form->error($model,'brend_id'); ?>
	</div>
    
    
    <div class="row">
		<?php echo $form->labelEx($model,'year'); ?>
		<?php echo $form->textField($model,'year',array('size'=>20,'maxlength'=>50, 'style'=>'width: 300px;')); ?>
		<?php echo $form->error($model,'year'); ?>
	</div>
        
    
    <div class="row">
		<?php echo $form->labelEx($model,'VIN'); ?>
		<?php echo $form->textField($model,'VIN',array('size'=>20,'maxlength'=>50, 'style'=>'width: 300px;')); ?>
		<?php echo $form->error($model,'VIN'); ?>
	</div>
    
    
    
    <div class="row">
		<?php echo $form->labelEx($model,'carcass_number'); ?>
		<?php echo $form->textField($model,'carcass_number',array('size'=>20,'maxlength'=>50, 'style'=>'width: 300px;')); ?>
		<?php echo $form->error($model,'carcass_number'); ?>
	</div>
    
    
    
    
    <div class="row">
		<?php echo $form->labelEx($model,'carcass_type'); ?>
        <div class="drop_list unexpand" style="height: 26px; width: 310px;">
            <div class="drop_button"></div>
            <?php 
                $listdata = array(
                    'Седан'=>'Седан',
                    'Хэтчбэк'=>'Хэтчбэк',
                    'Универсал'=>'Универсал',
                    'Кроссовер'=>'Кроссовер',
                    'Кабриолет'=>'Кабриолет',
                    'Пикап'=>'Пикап'
                );
                reset($listdata);
                $selected_value = ( isset($model->carcass_type) ) ? $model->carcass_type : key($listdata);
            ?>
            <span class="selected_value"><?=$selected_value?></span>
            <?php echo $form->dropDownList($model,'carcass_type', $listdata, array(
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
		<?php echo $form->error($model,'carcass_type'); ?>
	</div>
    
    
    <?php if ($model->type == Proposal::TYPE_SEARCH_SERVICES): ?>
    
        <div class="row">
    		<?php echo $form->labelEx($model,'box'); ?>
            <div class="drop_list unexpand" style="height: 26px; width: 310px;">
                <div class="drop_button"></div>
                <?php
                    $listdata = array(
                        'Механика'=>'Механика',
                        'Автомат'=>'Автомат',
                    );
                    reset($listdata);
                    $selected_value = ( isset($model->box) ) ? $listdata[$model->box] : key($listdata);
                ?>
                <span class="selected_value"><?=$selected_value?></span>
                <?php echo $form->dropDownList($model,'box', $listdata, array(
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
    		<?php echo $form->error($model,'box'); ?>
    	</div>
        
        
        <div class="row">
    		<?php echo $form->labelEx($model,'fuel'); ?>
            <div class="drop_list unexpand" style="height: 26px; width: 310px;">
                <div class="drop_button"></div>
                <?php
                    $listdata = array(
                        'Бензин'=>'Бензин',
                        'Дизель'=>'Дизель',
                        'Гибрид'=>'Гибрид',
                    );
                    reset($listdata);
                    $selected_value = ( isset($model->fuel) ) ? $listdata[$model->fuel] : key($listdata);
                ?>
                <span class="selected_value"><?=$selected_value?></span>
                <?php echo $form->dropDownList($model,'fuel', $listdata, array(
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
    		<?php echo $form->error($model,'fuel'); ?>
    	</div>
    
    <?endif;?>
    
    
    
    
    
    <?php if ($model->type == Proposal::TYPE_SEARCH_SERVICES): ?>
        <div class="row">
    		<label class="required">Вид услуги<span class="required">*</span><span class="note"> (Выберите из списка тип услуги)</span></label>
            
            <div class="drop_list unexpand" style="height: 26px; width: 310px;">
                <div class="drop_button"></div>
                <?php
                    $listdata = Lookup::model()->items(Lookup::COMPANY_TYPE);
                    reset($listdata);
                    $selected_value = key($listdata);
                ?>
                <span class="selected_value"><?=current($listdata)?></span>
                <?php echo $form->dropDownList($model,'targetcompany_type', $listdata, array(
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
    		<?php echo $form->error($model,'targetcompany_type'); ?>
    	</div>
    <?php endif; ?>
    
	<div class="row">
		<?php if ($model->type == Proposal::TYPE_SEARCH_SPAREPART): ?>
            <label class="required">Какую запчасть вы ищите<span class="required">*</span></label>
        <?php else: ?>
            <label class="required">Заявка<span class="required">*</span><span class="note"> (Опишите услугу, которую вы ищите)</span></label>
        <?php endif; ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50, 'style'=>'width: 300px;')); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Отправить', array('class'=>'default-button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->