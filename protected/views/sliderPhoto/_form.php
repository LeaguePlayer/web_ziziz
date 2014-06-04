<?php $this->beginWidget('CActiveForm', array(
    'htmlOptions' => array(
		'enctype' => 'multipart/form-data')
));?>
    <div id="actions_pannel">
        
        <?php 
          $this->widget('CMultiFileUpload', array(
             'name'=>'url',
             'accept'=>'jpg|jpeg|gif|png',
             'options'=>array(
             ),
          ));
        ?>
        
    </div>
    
    <div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить', array(
            'name' => 'SliderPhoto[save]',
        )); ?>
	</div>
    
    <?php foreach($model as $photo): ?>
        <div class="products" style="position: relative;">
            <?php
            echo CHtml::link(CHtml::image(str_replace('original_','thumbs/mini_',$photo->url), '', array(
                    'width' => 75,
                    'height' => 75,
                )), $photo->url, array(
                    'class' => 'fancybox fleft',
            ));
            ?>
            
            <div class='close' title='Удалить!' rel='<?=$photo->id ?>'> </div>
        </div>
    <?php endforeach; ?>
<?php $this->endWidget(); ?>

<script>
    $(document).ready(function(){        
        
        $('.close').click(function() {
            var ph_id = $(this).attr('rel');
            var del = $(this).parent();
            $.ajax({
                url: '<?php echo $this->createUrl('sliderPhoto/manage') ?>',
                type: "POST",
                data: {id_photo:ph_id},
                success: function(data) {
                    del.fadeOut(400, function(){
                        del.remove();
                    });
                }
            });
        });
        
    });
</script>