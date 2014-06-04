<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->company_id), array('view', 'id'=>$data->company_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_name')); ?>:</b>
	<?php echo CHtml::encode($data->company_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_address')); ?>:</b>
	<?php echo CHtml::encode($data->company_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_ymap_pos1')); ?>:</b>
	<?php echo CHtml::encode($data->company_ymap_pos1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_ymap_pos2')); ?>:</b>
	<?php echo CHtml::encode($data->company_ymap_pos2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->company_user_id); ?>
	<br />


</div>