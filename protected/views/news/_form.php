<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'news-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

	<p class="note"><span class="required">*</span> Обязательные для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>
    
    
    <div class="row">
		<?php echo $form->labelEx($model,'date_public'); ?>
		<?$this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'name'=>'News[date_public]',
        'value'=>($model->isNewRecord ? date('d.m.Y') : date('d.m.Y',strtotime($model->date_public))),
        'options'=>array(
            'showAnim'=>'fold',
            'firstDay'=>1,
            'dateFormat'=>'dd.mm.yy',
        ),
        
        ));?>
		<?php echo $form->error($model,'date_public'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>128,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'short_desc'); ?>
		<?php echo $form->textArea($model,'short_desc', array('class'=>'short_desc'))  ?>
		<?php echo $form->error($model,'short_desc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'full_desc'); ?>
		<?php $this->widget('application.extensions.tinymce_elfinder.tinymce.ETinyMce', array(
            'name'=>'News[full_desc]',
            'value'=>$model->full_desc,
            'options' => array(
                'theme' => 'advanced',
                'width'=>'660px',
                'height'=>'450px',
                'plugins' =>'
                    autolink,
                    lists,
                    spellchecker,
                    pagebreak,
                    style,
                    layer,
                    table,
                    save,
                    advhr,
                    advimage,
                    advlink,
                    emotions,
                    iespell,
                    inlinepopups,
                    insertdatetime,
                    preview,
                    media,
                    searchreplace,
                    print,
                    contextmenu,
                    paste,
                    directionality,
                    fullscreen,
                    noneditable,
                    visualchars,
                    nonbreaking,
                    xhtmlxtras,
                    template',
                'language'=>"ru",
                'theme_advanced_buttons1' => "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
            	'theme_advanced_buttons2' =>"cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
            	'theme_advanced_buttons3' => "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
            	'theme_advanced_buttons4' =>"insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
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
                <?echo CHtml::image('/uploads/news/mini_'.$model->img, $model->img);?>
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
    
    <fieldset class="meta">
    <legend>Для продвижения сайта в поисковых системах</legend>

	<div class="row">
		<?php echo $form->labelEx($model,'meta_title'); ?>
		<?php echo $form->textField($model,'meta_title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'meta_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'meta_keys'); ?>
		<?php echo $form->textArea($model,'meta_keys',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'meta_keys'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'meta_desc'); ?>
		<?php echo $form->textArea($model,'meta_desc',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'meta_desc'); ?>
	</div>
    
    </fieldset>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('class'=>'default-button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->