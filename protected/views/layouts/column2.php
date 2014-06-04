<?php $this->beginContent('//layouts/main'); ?>
	<?php echo $content; ?>
	<!-- content -->
	
	<div id="sidebar">
	<?php $this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'',
		));
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'operations'),
		));
		$this->endWidget(); ?>
	</div><!-- sidebar -->
	<div style="clear: both;"></div>
<?php $this->endContent(); ?>