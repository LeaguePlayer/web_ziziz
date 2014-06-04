<?php
$this->breadcrumbs=array(
	'Carmodels'=>array('index'),
	$model->m_id,
);

$this->menu=array(
	array('label'=>'List Carmodel', 'url'=>array('index')),
	array('label'=>'Create Carmodel', 'url'=>array('create')),
	array('label'=>'Update Carmodel', 'url'=>array('update', 'id'=>$model->m_id)),
	array('label'=>'Delete Carmodel', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->m_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Carmodel', 'url'=>array('admin')),
);
?>

<h1>View Carmodel #<?php echo $model->m_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'm_id',
		'm_name',
		'm_brend_id',
	),
)); ?>
