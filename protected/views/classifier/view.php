<?php
$this->breadcrumbs=array(
	'Классификаторы'=>array('index'),
	$model->classif_name,
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Обновить', 'url'=>array('update', 'id'=>$model->classif_id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->classif_id),'confirm'=>'Вы уверены?')),
	//array('label'=>'Manage Classifier', 'url'=>array('admin')),
);
?>

<h1>Классификатор - <?php echo $model->classif_name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'classif_id',
		'classif_name',
	),
)); ?>
