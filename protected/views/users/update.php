<?php
$this->breadcrumbs=array(
	'Личный кабинет - '.$model->user_login=>array('view','id'=>$model->user_id),
	'Редактирование профиля',
);

//$this->menu=array(
//	array('label'=>'Список', 'url'=>array('index')),
//	array('label'=>'Создать', 'url'=>array('create')),
//	array('label'=>'Просмотреть', 'url'=>array('view', 'id'=>$model->user_id)),
//	//array('label'=>'Manage Users', 'url'=>array('admin')),
//);
?>

<h1>Профиль <?php echo $model->user_fio; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'citys'=>$citys,'company'=>$company)); ?>