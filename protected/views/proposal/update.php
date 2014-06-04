<?php
$this->breadcrumbs=array(
	'Proposals'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Proposal', 'url'=>array('index')),
	array('label'=>'Create Proposal', 'url'=>array('create')),
	array('label'=>'View Proposal', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Proposal', 'url'=>array('admin')),
);
?>

<h1>Update Proposal <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>