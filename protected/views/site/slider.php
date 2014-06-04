<?php $this->beginWidget('CActiveForm') ;?>
    <span class="text_row_title">Слайдер</span>
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
            'name' => 'save',
        )); ?>
	</div>
    
    <?php foreach($model as $photo): ?>
        <div class="products" style="height: 30px;">
                <?php
                echo CHtml::link(CHtml::image(str_replace('original_','thumbs/mini_',$photo->ph_url), '', array(
                        'width' => 75,
                        'height' => 50,
                    )), $photo->ph_url, array(
                        'class' => 'fancybox fleft',
                    ));
                ?>
            
            <div class="product_title">
                <?php echo CHtml::encode($photo->gallery->anns[0]->ann_name); ?>
            </div>
            
        </div>
    <?php endforeach; ?>
<?php $this->endWidget(); ?>