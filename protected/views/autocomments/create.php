<?php
$this->breadcrumbs=array(
	'Autocomments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Autocomments', 'url'=>array('index')),
	array('label'=>'Manage Autocomments', 'url'=>array('admin')),
);
?>

<h1>Create Autocomments</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>