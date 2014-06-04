<?php
$this->breadcrumbs=array(
	'Brends'=>array('index'),
	$model->b_id=>array('view','id'=>$model->b_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Brend', 'url'=>array('index')),
	array('label'=>'Create Brend', 'url'=>array('create')),
	array('label'=>'View Brend', 'url'=>array('view', 'id'=>$model->b_id)),
	array('label'=>'Manage Brend', 'url'=>array('admin')),
);
?>

<h1>Update Brend <?php echo $model->b_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>