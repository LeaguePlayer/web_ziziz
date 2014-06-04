<?php
$this->breadcrumbs=array(
	'Категории'=>array('index'),
	$model->cat_id,
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Обновить', 'url'=>array('update', 'id'=>$model->cat_id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->cat_id),'confirm'=>'Вы уверен что хотите удалить эту категорию?')),
	//array('label'=>'Manage Category', 'url'=>array('admin')),
);
?>

<h1>Категория - <?php echo $model->cat_name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'cat_id',
		'cat_name',
		'parent.cat_name',
	),
)); ?>
