<?php
$this->breadcrumbs=array(
	'Автообъявления'=>array('index'),
	$model->auto_id=>array('view','id'=>$model->auto_id),
	'Редактирование',
);

//$this->menu=array(
//	array('label'=>'Список', 'url'=>array('index')),
//	array('label'=>'Создать', 'url'=>array('create')),
//	array('label'=>'Просмотр', 'url'=>array('view', 'id'=>$model->auto_id)),
//	//array('label'=>'Manage Auto', 'url'=>array('admin')),
//);
?>

<h1>Обновление <?php echo $model->auto_id; ?></h1>

<?php echo $this->renderPartial('_form', array(
    'model'=>$model,
    'brend'=>$brend,
    'automodel'=>$automodel,
    'modification'=>$modification,
    'users'=>$users,
    'brends'=>$brends
)); ?>