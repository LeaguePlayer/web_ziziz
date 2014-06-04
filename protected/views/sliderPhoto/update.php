<?php
$this->breadcrumbs=array(
	'Slider Photos'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SliderPhoto', 'url'=>array('index')),
	array('label'=>'Create SliderPhoto', 'url'=>array('create')),
	array('label'=>'View SliderPhoto', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SliderPhoto', 'url'=>array('admin')),
);
?>

<h1>Update SliderPhoto <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>