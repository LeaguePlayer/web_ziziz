<?php
$this->breadcrumbs=array(
	'Carmodels'=>array('index'),
	$model->m_id=>array('view','id'=>$model->m_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Carmodel', 'url'=>array('index')),
	array('label'=>'Create Carmodel', 'url'=>array('create')),
	array('label'=>'View Carmodel', 'url'=>array('view', 'id'=>$model->m_id)),
	array('label'=>'Manage Carmodel', 'url'=>array('admin')),
);
?>

<h1>Update Carmodel <?php echo $model->m_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>