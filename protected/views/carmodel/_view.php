<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('m_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->m_id), array('view', 'id'=>$data->m_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('m_name')); ?>:</b>
	<?php echo CHtml::encode($data->m_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('m_brend_id')); ?>:</b>
	<?php echo CHtml::encode($data->m_brend_id); ?>
	<br />


</div>