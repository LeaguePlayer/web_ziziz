<?php
$this->breadcrumbs=array(
	'Категории'=>array('index'),
	$model->cat_name=>array('view','id'=>$model->cat_id),
	'Релактирование',
);

$this->menu=array(
	array('label'=>'Спиок', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Просмотреть', 'url'=>array('view', 'id'=>$model->cat_id)),
	//array('label'=>'Manage Category', 'url'=>array('admin')),
);
?>

<h1>Обновление <?php echo $model->cat_name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>