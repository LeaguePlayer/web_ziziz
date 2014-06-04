<?php
$this->breadcrumbs=array(
	'Slider Photos'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List SliderPhoto', 'url'=>array('index')),
	array('label'=>'Create SliderPhoto', 'url'=>array('create')),
	array('label'=>'Update SliderPhoto', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SliderPhoto', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SliderPhoto', 'url'=>array('admin')),
);
?>

<h1>View SliderPhoto #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'status',
		'ann_id',
	),
)); ?>
