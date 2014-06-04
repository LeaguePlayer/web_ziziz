<?php $cs=Yii::app()->getClientScript(); ?>
<?php $cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/ann_form.js', CClientScript::POS_HEAD); ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'announcements-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array(
		'enctype' => 'multipart/form-data')
)); ?>
	<p class="note">Поля отмеченные <span class="required">*</span> обязательны для заполнения.</p>
    
    <?php echo $form->errorSummary($model) ?>
    
    <div class="left">
    <?php if(Yii::app()->user->isGuest): ?>
    <fieldset>
        <legend>Быстрая регистрация</legend>
        <div class="row">
    		<?php echo $form->labelEx($user, 'user_login'); ?>
    		<?php echo $form->textField($user, 'user_login',array('size'=>60,'maxlength'=>100, 'style'=>'width: 288px;')); ?>
    		<?php echo $form->error($user, 'user_login'); ?>
    	</div>
        
        <div class="row">
    		<?php echo $form->labelEx($user, 'user_email'); ?>
    		<?php echo $form->textField($user, 'user_email',array('size'=>60,'maxlength'=>100, 'style'=>'width: 288px;')); ?>
    		<?php echo $form->error($user, 'user_email'); ?>
    	</div>
    </fieldset>
            
    <?php endif; ?>
    
    
    
        <div class="row">
            <?php echo CHtml::activeHiddenField($model, 'model_id'); ?>
            <label>Марка</label>
            
            <div style="position: relative; overflow: hidden;">
            <?php                       
            $this->widget('ext.combobox.EJuiComboBox', array(
                'model' => (isset($model->automodel->modelbrend)) ? $model->automodel->modelbrend : Brend::model(),
                'attribute' => 'b_id',
                // data to populate the select. Must be an array.
                'data' =>  CHtml::listData(Brend::model()->findAll(), 'b_id', 'b_name'),
                'assoc' => true,
                //'cssFile' => false,
                // options passed to plugin
                'options' => array(
                    'onSelect' => "
                        var b_id = jQuery('#Brend_b_id').val();
                        if (b_id == jQuery('input#Brend_b_id').val())
                            var m_id = jQuery('input#Carmodel_m_id').val();
                        else
                            var m_id = 0;
                            
                        jQuery.ajax({
                            type: 'GET',
                            url: '/announcements/getModel',
                            data: {
                                brend_id: b_id,
                                model_id: m_id
                            },
                            success: function(data){
                                jQuery('.models').html(data);
                            }
                        });
                    ",
                    //'onChange' => '',
                    'allowText' => true,
                ),
                // Options passed to the text input
                'htmlOptions' => array('size' => 10),
            )); ?>
            </div>
                                                            
    	</div>
        
        
        <div class="row">
            <div class="models"></div>
        </div>
        
    
        <div class="row">
            <?php echo $form->labelEx($model,'ann_category'); ?>
		
            <div id="select_category" class="drop_list unexpand">
                <div class="drop_button"></div>
                
                <?
                    function treeListData(Category $category, &$listdata, $level)
                    {
                        $name = "";
                        for ($i = 0; $i < $level; ++$i) $name .= "--";
                        $name .= " {$category->cat_name}";
                        $listdata[$category->cat_id] = $name;
                        foreach ($category->childs as $node)
                        {
                            treeListData($node, $listdata, $level + 1);
                        }
                    }
                    
                    $listdata = array();
                    foreach ($category as $root_node)
                    {
                        treeListData($root_node, $listdata, 0);
                    }
                ?>
                
                <span class="selected_value"><?=$listdata[$model->ann_category]?></span>
                <?php echo $form->dropDownList($model, 'ann_category', $listdata, array(
                	'class'=>'cats',
                    'empty'=>'',
                ));?>
                <div class="select_options">
                	<?php
                	foreach($listdata as $key => $item)
                	{
                        $selected = ($key==$model->ann_category) ? ' selected' : '';
                        echo CHtml::openTag('div', array('class'=>'select_option'.$selected, 'value'=>$key));
                        echo $item;
                        echo CHtml::closeTag('div');
                	}
                	?>
                </div>
            </div>
            <?php echo $form->error($model, 'ann_category'); ?>
        </div>
	
        <div id="classifiers"></div> 
        
        
        <div class="row">
            <?php echo $form->labelEx($model,'ann_name'); ?>
            
            <div style="position: relative; overflow: hidden;">
            <?php                       
            $this->widget('ext.combobox.EJuiComboBox', array(
                'model' => $model,
                'attribute' => 'ann_name',
                // data to populate the select. Must be an array.
                'data' =>  Announcements::cordTypes(),
                'assoc' => false,
                //'cssFile' => false,
                // options passed to plugin
                'options' => array(
                    'onSelect' => "",
                    //'onChange' => '',
                    'allowText' => true,
                ),
                // Options passed to the text input
                'htmlOptions' => array('size' => 10),
            )); ?>
            </div>
            
            <?php echo $form->error($model,'ann_name'); ?>
                                                            
    	</div>
	
          
	
    	<div class="row">
    		<?php echo $form->labelEx($model,'ann_state'); ?>
    		
    		<div class="drop_list unexpand">
                <div class="drop_button"></div>
    			<?php $listdata = Lookup::items('ProductState'); ?>
    			<span class="selected_value"><?=$listdata[$model->ann_state]?></span>
    			<?php echo $form->dropDownList($model, 'ann_state', Lookup::items('ProductState'));?>
    			<div class="select_options">
    				<?php
    				foreach($listdata as $key => $item)
    				{
    				    $selected = ($key==$model->ann_state) ? ' selected' : '';
    					echo CHtml::openTag('div', array('class'=>'select_option'.$selected, 'value'=>$key));
    					echo $item;
    					echo CHtml::closeTag('div');
    				}
    				?>
    			</div>
    		</div>
            
    		<?php //echo $form->textField($model,'ann_state'); ?>
    		<?php echo $form->error($model,'ann_state'); ?>
    	</div>
    	
    	<div class="row">
    		<?php echo $form->labelEx($model,'ann_desc'); ?>
    		<?php echo $form->textArea($model,'ann_desc',array('rows'=>6, 'cols'=>50)); ?>
    		<?php echo $form->error($model,'ann_desc'); ?>
    	</div>
    	
        <div class="row">
    		<?php echo $form->labelEx($model,'ann_price'); ?>
    		<?php echo $form->textField($model,'ann_price', array(
                'style'=>'width: 140px;',
            )); ?> <span style="font-family: 'Trebuchet MS', sans-serif; font-size: 12px; font-weight: bold;"> руб.</span>
    		<?php echo $form->error($model,'ann_price'); ?>
    	</div>
        
    </div> <!-- end_left -->

    <div class="right">
    	<?php echo CHtml::label('Фотографии', false); ?>
        <div id="gallery">
        
            <?php $gallery = Gallery::model();?>
            <div>
                <?php echo $form->hiddenField($gallery,'gal_name', array('value'=>$model->isNewRecord ? md5(time().rand(1,100)) : $model->gall->gal_name)); ?>
            </div>
            
            
            <div class="gallery_head">
            
                <?php
                  $this->widget('application.components.CMultiFileUploadEx', array(
                     'name'=>'ph_url',
                     'model'=>Photo::model(),
                     'accept'=>'jpg|jpeg|gif|png',
                     'options'=>array(
                        //'onFileSelect'=>'function(e, v, m){ alert("onFileSelect - "+v) }',
                        'afterFileSelect'=>"function(e, v, m){
                            var file = e.files[0];
                            var input_id = $(e).attr('id');
                            var clearButton = $('#ph_url_wrap_list .MultiFile-label:last-child a.MultiFile-remove');
                            
                            var reader = new FileReader();
                            
                            reader.onload = function(event) {
                                $('#announcements-form .right .gallery_body').append(\"<div id='preview-\" + input_id + \"' class='preview'><div class='round_image'><img src=\" + event.target.result + \" /></div><a href='#'><img class='clear_preview'src='/images/clear_X.png' /></a><div class='preview_text'>\" + v + \"</div></div>\");
                                alignmentBlocks($('#announcements-form .right .gallery_body .preview'), 3);
                                var count = $('#announcements-form .right .gallery_head input[type=file]').length - 1;
                                $('#announcements-form .right .gallery_head .nothing_selected').text('выбрано файлов: ' + count);
                                $('#preview-' + input_id + ' a .clear_preview').click(function(){
                                    
                                    //fileInput.remove();
                                    clearButton.trigger('click');
                                    //$('#ph_url_wrap_list .MultiFile-label').eq(counter).remove();
                                    
                                    $(this).parents('#preview-'+ input_id).remove();
                                    var count = $('#announcements-form .right .gallery_head input[type=file]').length - 1;
                                    $('#announcements-form .right .gallery_head .nothing_selected').text('выбрано файлов: ' + count);
                                    return false;
                                });
                            };
                            
                            reader.onerror = function(event) {
                                console.error('Файл не может быть прочитан! код ' + event.target.error.code);
                            };
                            
                            reader.readAsDataURL(file);
                                                    
                        }",
                        //'onFileAppend'=>'function(e, v, m){ alert("onFileAppend - "+v) }',
                        //'afterFileAppend'=>'function(e, v, m){ alert("afterFileAppend - "+v) }',
                        'onFileRemove'=>"function(e, v, m){
                            var number = $(e).index();
                            $('#announcements-form .right .gallery_body .preview').eq(number).remove();
                        }",
                        'afterFileRemove'=>"function(e, v, m){
                            var count = $('#announcements-form .right .gallery_head input[type=file]').length - 1;
                            if (count == 0)
                                $('#announcements-form .right .gallery_head .nothing_selected').text('ничего не выбрано');
                            else
                                $('#announcements-form .right .gallery_head .nothing_selected').text('выбрано файлов: ' + count);
                        }",
                     ),
                  ));
                  ;
                ?>
                <span class="nothing_selected">ничего не выбрано</span>
                
            </div>
            <div class="gallery_body">
            <?php if(!empty($model->gall)): ?>
                <?php foreach($model->gall->original as $ph): ?>
                    <div class="preview">
                        <div class="round_image">
                            <?=CHtml::image(CHtml::encode(str_replace('original_','thumbs/mini_',$ph->ph_url)),'')?>
                        </div>
                        <a id="ajax_delphoto-<?=$ph->ph_id?>" href="#" rel="<?=$ph->ph_id?>"><img class="clear_preview" src="/images/clear_X.png" /></a>
                        <div class="preview_text"></div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>                                                            
                        
                
                                            
            </div>
        </div>
        
        <div class="row_buttons">
            <button class="ziziz_button"><span class="icon plus"></span><?php echo $model->isNewRecord ? 'Добавить объявление' : 'Сохранить изменения'; ?></button>
        </div>
        <div class="loader" style="display: none; float: left; margin-left: 10px; margin-top: 15px;"></div>
        <span class="load_process" style="display: none; float: left;float: left; font-size: 12px; margin-left: 10px; margin-top: 19px;">Идет загрузка объявления...</span>
    
    </div>
    
    <div class="bottom">
        
    </div>
    
<?php $this->endWidget(); ?>
</div><!-- form -->

<script type="text/javascript">
jQuery(document).ready(function() {
    var cat_id = jQuery("select#Announcements_ann_category").val() || 0;
    var model_id = <?= ($model->isNewRecord) ? 0 : $model->ann_id ?>;
    //console.log(cat_id);
    if (cat_id != 0) getClassif(cat_id, model_id);
    
    $("a[id|=ajax_delphoto]").click(function(){
        var preview = $(this).parent();
        $.ajax({
            url: '/announcements/delPhoto',
            type: 'POST',
            data: ({delphoto_id: $(this).attr('rel'), user_id: <?=(empty($model->ann_user_id)) ? 0: $model->ann_user_id?>}),
            success: function(data) {
                if (data==1) {
                    //console.log($(this).parent().attr('style'));
                    preview.fadeOut(500, function(){
                        $(this).remove();
                    });
                }
            }
        });
        return false;
    });
    
    $("input[type=submit]").click(function(){
        $(this).parent("div").hide();
        $(this).parent("div").next('.loader').show();
        $(this).parent("div").next('.loader').next('.load_process').show();
    });
    
    
    var b_id = jQuery("#Brend_b_id").val() || 0;
    var m_id = jQuery("#Announcements_model_id").val() || 0;
    
    if (b_id != 0) {
        jQuery.ajax({
            type: 'GET',
            url: '/announcements/getModel',
            data: {
                brend_id: b_id,
                model_id: m_id
            },
            success: function(data){
                jQuery('.models').html(data);
                jQuery('.models-list').change();
            }
        });
    }
    
});


function checkClassifiers() {
    $.ajax({
    	type: "Post",
    	url: '<?=$this->createUrl("announcements/getIncludedClassifiers");?>?announcement_id=<?=$model->ann_id;?>&type=update',
    	data: ({ajax : 1}),
    	success: function(res) {
    		//alert(res);
    		$('#classifiers').html(res);
    	}
    });
};

function getClassif(cat_id, model_id){
    $.ajax({
    	type: "GET",
    	url: '/announcements/getClassif',
    	data: ({ajax: 1, category_id: cat_id, ann_id: model_id}),
    	success: function(res) {
    		$('#classifiers').html(res);
    	}
    });
}

jQuery('#select_category .select_option').click(function(){
	if (!$(this).hasClass('selected')){
		var cat_id = jQuery(this).attr('value');
        var model_id = <?= ($model->isNewRecord) ? 0 : $model->ann_id ?> || 0;
	    if (cat_id != 0) getClassif(cat_id, model_id);
	}
});

$('#classifiers').delegate('.include_classif_checkbox', 'click', function() {
	var check = ($(this).attr('checked')=='checked') ? true : false;
    if (check){
        $(this).parent().parent().next().next().show(500).find('select[id|=classifList]').removeAttr('disabled');
        //console.log($(this).parent().parent().next().next().find('select[id|=classifList]').attr('disabled'));
    }
    else
    {
        $(this).parent().parent().next().next().hide(500).find('select[id|=classifList]').attr('disabled', 'disabled');
        //console.log($(this).parent().parent().next().next().find('select[id|=classifList]').attr('disabled'));
    }
        
});

</script>