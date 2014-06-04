<?php
$this->breadcrumbs=array(
	'Список классификаторов'=>array('index'),
	$model->classif_name=>array('view','id'=>$model->classif_id),
	'Update',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	//array('label'=>'View Classifier', 'url'=>array('view', 'id'=>$model->classif_id)),
	//array('label'=>'Manage Classifier', 'url'=>array('admin')),
);
?>

<h1>Обновить - <?php echo $model->classif_name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>