<?php $cs=Yii::app()->getClientScript(); ?>
<?php $cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/ann_form.js', CClientScript::POS_HEAD); ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'auto-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

	<p class="note">Поля, отмеченные <span class="required">*</span> обязательны для заполнения.</p>

    <div class="left">
        
        <?php echo $form->errorSummary($model); ?>
        
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
            <label class="required">Марка<span class="required"> *</span></label>

            <div style="position: relative;">
            <?php
            $this->widget('ext.combobox.EJuiComboBox', array(
                'model' => $brend,
                'attribute' => 'b_id',
                // data to populate the select. Must be an array.
                'data' =>  CHtml::listData($brends, 'b_id', 'b_name'),
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
                            url: '/auto/getModel',
                            data: {
                                brend_id: b_id,
                                model_id: m_id
                            },
                            success: function(data){
                                jQuery('.models').html(data);
                                jQuery('.models-list').change();
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

            <div class="clear"></div>
                                                            
    	</div>
        
        <div class="row">
            <div class="models"></div>
            <?php echo $form->error($model,'auto_model_id'); ?>
        </div>
        <div class="row">
            <div class="modifications"></div>
            <?php echo $form->error($model,'auto_year'); ?>
        </div>
        
        <div class="row">
    		<?php echo $form->labelEx($model,'auto_desc'); ?>
    		<?php echo $form->textArea($model,'auto_desc',array('rows'=>6, 'cols'=>50)); ?>
    		<?php echo $form->error($model,'auto_desc'); ?>
    	</div>
        
        <div class="row">
    		<?php echo $form->labelEx($model,'auto_run'); ?>
    		<?php echo $form->textField($model,'auto_run', array('style'=>'width: 100px;')); ?><span class="default-text"> км</span>
    		<?php echo $form->error($model,'auto_run'); ?>
    	</div>
        
        <div class="row">
    		<?php echo $form->labelEx($model,'auto_price'); ?>
    		<?php echo $form->textField($model,'auto_price', array('style'=>'width: 100px;')); ?><span class="default-text"> руб</span>
    		<?php echo $form->error($model,'auto_price'); ?>
    	</div>        
            
    </div> <!-- end_left -->
    
    <div class="right">
    	<?php echo CHtml::label('Фотографии', false); ?>
        
        <div id="gallery">
        
            <?php $gallery = Gallery::model();?>
            
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
                                $('#auto-form .right .gallery_body').append(\"<div id='preview-\" + input_id + \"' class='preview'><div class='round_image'><img src=\" + event.target.result + \" /></div><a href='#'><img class='clear_preview'src='/images/clear_X.png' /></a><div class='preview_text'>\" + v + \"</div></div>\");
                                alignmentBlocks($('#auto-form .right .gallery_body .preview'), 3);
                                var count = $('#auto-form .right .gallery_head input[type=file]').length - 1;
                                $('#auto-form .right .gallery_head .nothing_selected').text('выбрано файлов: ' + count);
                                $('#preview-' + input_id + ' a .clear_preview').click(function(){
                                    //$('#' + input_id).remove();
                                    clearButton.trigger('click');
                                    
                                    $(this).parents('#preview-'+ input_id).fadeOut(500, function(){
                                        $(this).remove();
                                    });
                                    var count = $('#auto-form .right .gallery_head input[type=file]').length - 1;
                                    $('#auto-form .right .gallery_head .nothing_selected').text('выбрано файлов: ' + count);
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
//                            var number = $(e).index();
//                            $('#announcements-form .right .gallery_body .preview').eq(number).fadeOut(500, function(){
//                                $(this).remove();
//                            })
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
        
        <?php
            echo CHtml::activeHiddenField($model, 'auto_id');
            echo CHtml::activeHiddenField($brend, 'b_id');
            echo CHtml::activeHiddenField($automodel, 'm_id');
            echo CHtml::activeHiddenField($modification, 'mod_id');
        ?>
        
        <div class="row_buttons">
            <button class="ziziz_button"><span class="icon plus"></span><?php echo $model->isNewRecord ? 'Добавить объявление' : 'Сохранить изменения'; ?></button>
        </div>

        <div class="loader" style="display: none; float: left; margin-left: 10px; margin-top: 15px;"></div>
        <span class="load_process" style="display: none; float: left;float: left; font-size: 12px; margin-left: 10px; margin-top: 19px;">Идет загрузка объявления...</span>
        
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">

    jQuery(document).ready(function(){
        var b_id = jQuery("#Brend_b_id").val() || 0;
        if (b_id == jQuery("input#Brend_b_id").val())
            var m_id = jQuery("input#Carmodel_m_id").val();
        else
            var m_id = 0;
        
        if (b_id != 0)
            jQuery.ajax({
                type: 'GET',
                url: '/auto/getModel',
                data: {
                    brend_id: b_id,
                    model_id: m_id
                },
                success: function(data){
                    jQuery('.models').html(data);
                    jQuery('.models-list').change();
                }
            });
        
        $("a[id|=ajax_delphoto]").click(function(){
            var preview = $(this).parent();
            $.ajax({
                url: '/auto/delPhoto',
                type: 'POST',
                data: {delphoto_id: $(this).attr('rel'), user_id: <?=(empty($model->auto_user)) ? 0: $model->auto_user?>},
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
    });
    
    jQuery('.models').delegate('.models-list', 'change', function(){
        var m_id = jQuery(this).val();
        if (m_id == jQuery("input#Carmodel_m_id").val())
            var mod_id = jQuery("input#Modification_mod_id").val();
        else
            var mod_id = 0;
        
        jQuery.ajax({
            type: "GET",
            url: "<?=$this->createUrl('auto/getModification')?>",
            data: {
                model_id : m_id,
                modification_id: mod_id,
                auto_carcas: <?=empty($model->auto_carcass) ? 0 : $model->auto_carcass?>,
                auto_fuel: <?=empty($model->auto_fuel) ? 0 : $model->auto_fuel?>,
                auto_control: <?=empty($model->auto_control) ? 0 : $model->auto_control?>,
                auto_box: <?=empty($model->auto_box) ? 0 : $model->auto_box?>,
                auto_drive: <?=empty($model->auto_drive) ? 0 : $model->auto_drive?>,
                auto_vol: <?=empty($model->auto_vol) ? 0 : $model->auto_vol?>,
                auto_year: <?=empty($model->auto_year) ? 0 : $model->auto_year?>,
            },
            success: function(data){
                jQuery('.modifications').html(data);
            }
        });
    });
    
    jQuery('.modifications').delegate('.modification-list', 'change', function(){
        var mod_id = jQuery(this).val();
        jQuery.ajax({
            type: "GET",
            url: "<?=$this->createUrl('auto/getCheckModification')?>",
            data: {
                modification_id: mod_id,
            },
            success: function(data){
                jQuery('.modification-form').html(data);
                
            }
        });
    });
    
    jQuery('.modifications').delegate('.checkable', 'change ', function(){
        $('.modification-list :first').attr('selected', 'selected');
        $('.modification-list').prev().text($('.modification-list').find('option:selected').text());
        $('.modification-list').next().children(':first, .selected').toggleClass('selected');
    });
    
    jQuery('.modifications').delegate('input', 'keyup ', function(){
        $('.modification-list :first').attr('selected', 'selected');
        $('.modification-list').prev().text($('.modification-list').find('option:selected').text());
        $('.modification-list').next().children(':first, .selected').toggleClass('selected');
    });
    
    
    
</script>