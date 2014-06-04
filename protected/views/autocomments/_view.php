<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('from_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->from_user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_public')); ?>:</b>
	<?php echo CHtml::encode($data->date_public); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('viewed')); ?>:</b>
	<?php echo CHtml::encode($data->viewed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('text')); ?>:</b>
	<?php echo CHtml::encode($data->text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ann_id')); ?>:</b>
	<?php echo CHtml::encode($data->ann_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />


</div>