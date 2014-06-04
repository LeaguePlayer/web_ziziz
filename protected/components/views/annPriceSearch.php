	<div class="text_title_left">Цена:</div>
	
	<?php $url = $this->getController()->createUrl('announcements/index'); ?>
	<?php echo CHtml::beginForm($url); ?>
	
		<?php echo CHtml::activeTextField($form, 'price_ot'); ?>
	    <span style="color:#8f8f8f;font-size:11px;">до</span>
	    <?php echo CHtml::activeTextField($form, 'price_do'); ?>
	    
	    <?php
			echo CHtml::ajaxSubmitButton('Применить', $url,
				array(
	   				'type'=>'POST',
	   				'update'=>'#catalog',
	   			),
				array(
					'id'=>'apply',
					'type'=>'submit',
				)
			);
		?>
	
	<?php echo CHtml::endForm(); ?>
