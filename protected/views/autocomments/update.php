<?php
$this->breadcrumbs=array(
	'Autocomments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Autocomments', 'url'=>array('index')),
	array('label'=>'Create Autocomments', 'url'=>array('create')),
	array('label'=>'View Autocomments', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Autocomments', 'url'=>array('admin')),
);
?>

<h1>Update Autocomments <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>