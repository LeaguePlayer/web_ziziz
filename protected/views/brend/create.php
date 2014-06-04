<?php
$this->breadcrumbs=array(
	'Brends'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Brend', 'url'=>array('index')),
	array('label'=>'Manage Brend', 'url'=>array('admin')),
);
?>

<h1>Create Brend</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>