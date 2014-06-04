<?php
$this->breadcrumbs=array(
	'Brends'=>array('index'),
	$model->b_id,
);

$this->menu=array(
	array('label'=>'List Brend', 'url'=>array('index')),
	array('label'=>'Create Brend', 'url'=>array('create')),
	array('label'=>'Update Brend', 'url'=>array('update', 'id'=>$model->b_id)),
	array('label'=>'Delete Brend', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->b_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Brend', 'url'=>array('admin')),
);
?>

<h1>View Brend #<?php echo $model->b_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'b_id',
		'b_name',
	),
)); ?>
