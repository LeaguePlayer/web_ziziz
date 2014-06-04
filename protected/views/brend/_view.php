<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('b_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->b_id), array('view', 'id'=>$data->b_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('b_name')); ?>:</b>
	<?php echo CHtml::encode($data->b_name); ?>
	<br />


</div>