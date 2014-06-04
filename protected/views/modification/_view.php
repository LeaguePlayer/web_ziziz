<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('mod_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->mod_id), array('view', 'id'=>$data->mod_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mod_carcass')); ?>:</b>
	<?php echo CHtml::encode($data->mod_carcass); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mod_fuel')); ?>:</b>
	<?php echo CHtml::encode($data->mod_fuel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mod_control')); ?>:</b>
	<?php echo CHtml::encode($data->mod_control); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mod_box')); ?>:</b>
	<?php echo CHtml::encode($data->mod_box); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mod_drive')); ?>:</b>
	<?php echo CHtml::encode($data->mod_drive); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mod_vol')); ?>:</b>
	<?php echo CHtml::encode($data->mod_vol); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('mod_run')); ?>:</b>
	<?php echo CHtml::encode($data->mod_run); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mod_year')); ?>:</b>
	<?php echo CHtml::encode($data->mod_year); ?>
	<br />

	*/ ?>

</div>