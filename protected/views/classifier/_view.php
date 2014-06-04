<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('classif_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->classif_id), array('view', 'id'=>$data->classif_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('classif_name')); ?>:</b>
	<?php echo CHtml::encode($data->classif_name); ?>
	<br />


</div>