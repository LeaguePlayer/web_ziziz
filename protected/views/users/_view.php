<div class="view">

	<?/*<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->user_id), array('view', 'id'=>$data->user_id)); ?>
	<br />
    */?>
	<b><?php echo CHtml::encode($data->getAttributeLabel('user_fio')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->user_fio), array('view', 'id'=>$data->user_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_phone')); ?>:</b>
	<?php echo CHtml::encode($data->user_phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_email')); ?>:</b>
	<?php echo CHtml::encode($data->user_email); ?>
	<br />


</div>