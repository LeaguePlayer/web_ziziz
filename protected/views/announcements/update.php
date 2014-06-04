<?php
$this->breadcrumbs=array(
	'Объявления'=>array('index'),
	$model->ann_name=>array('view','id'=>$model->ann_id),
	'Редактирование объявления',
);

//$this->menu=array(
//	array('label'=>'Список', 'url'=>array('index')),
//	array('label'=>'Создать', 'url'=>array('create')),
//	array('label'=>'Просмотреть', 'url'=>array('view', 'id'=>$model->ann_id)),
//	//array('label'=>'Manage Announcements', 'url'=>array('admin')),
//);
?>

<h1>Обновление</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'category'=>$category)); ?>