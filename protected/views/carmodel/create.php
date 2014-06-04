<?php
$this->breadcrumbs=array(
	'Carmodels'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Carmodel', 'url'=>array('index')),
	array('label'=>'Manage Carmodel', 'url'=>array('admin')),
);
?>

<h1>Create Carmodel</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>