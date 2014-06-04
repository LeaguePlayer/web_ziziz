<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'actions-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

	<p class="note">Поля, отмеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

    <div class="row">
		<?php echo $form->labelEx($model,'actual_date'); ?>
		<?$this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'name'=>'Actions[actual_date]',
        'value'=>($model->isNewRecord ? date('Y-m-d') : date('Y-m-d',strtotime($model->actual_date))),
        'options'=>array(
            'showAnim'=>'fold',
            'firstDay'=>1,
            'dateFormat'=>'yy-mm-dd',
        ),
        
        ));?>
		<?php echo $form->error($model,'actual_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>128,'maxlength'=>255,'style'=>'width: 660px;')); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'short_desc'); ?>
		<?php echo $form->textArea($model,'short_desc', array('style'=>'width: 660px;'))  ?>
		<?php echo $form->error($model,'short_desc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'full_desc'); ?>
		<?php $this->widget('application.extensions.tinymce_elfinder.tinymce.ETinyMce', array(
            'name'=>'Actions[full_desc]',
            'value'=>$model->full_desc,
            'editorTemplate'=>'simple',
            'options' => array(
                'theme' => 'advanced',
                'width'=>'660px',
                'height'=>'450px',
                'plugins' =>'autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template',
                'language'=>"ru",
                //'theme_advanced_buttons1' => "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
            	//'theme_advanced_buttons2' =>"cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
            	//'theme_advanced_buttons3' => "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
            	//'theme_advanced_buttons4' =>"insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
                'theme_advanced_toolbar_location' => "top",
            	'theme_advanced_toolbar_align'=>"left",
            	'theme_advanced_statusbar_location' =>"bottom",
            	'theme_advanced_resizing' =>true,
            ),
        
        )); ?>
		<?php echo $form->error($model,'full_desc'); ?>
	</div>
	
    
	<div class="row">
        <?if($model->img){?>
            <div class="row">
                <?echo CHtml::image('/uploads/actions/mini_'.$model->img, $model->img);?>
        	</div>
        <?}?>
        <?php
            if ($model->isNewRecord)
                echo $form->labelEx($model, 'img');
            else
                echo CHtml::label('Сменить изображение', false);
        ?>
        <?php echo CHtml::activeFileField($model, 'img'); ?>
		<?php echo $form->error($model,'img'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('class'=>'default-button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->