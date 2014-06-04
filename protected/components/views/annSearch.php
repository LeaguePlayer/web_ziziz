
<?php //$url = $this->getController()->createUrl('announcements/index'); ?>
<?php echo CHtml::beginForm($url); ?>

	<?php echo CHtml::activeTextField($form, 'string', array(
        'placeholder'=>'Поиск...',
    )); ?>
    <div id="serachButtonDiv">
		<?php
			echo CHtml::ajaxSubmitButton('Поиск', $url,
				array(
	   				'type'=>'POST',
	   				'update'=>$update,
	   			),
				array(
					'id'=>'search_button',
					'type'=>'submit',
				)
			);
		?>
    </div>

<?php echo CHtml::endForm(); ?>

<script>
	$('#serachButtonDiv').click(function(){
		$ann_list = $('#announc_list').html();
		$('#announc_list').html('<div class="loader"></div>');
		
	});
</script>