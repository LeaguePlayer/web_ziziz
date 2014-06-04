<?php
$this->pageTitle = "ZIZIZ - Добавление объявления";

$this->breadcrumbs=array(
	'Объявления'=>array('index'),
	'Новое объявление',
);

//$this->menu=array(
//	array('label'=>'Список', 'url'=>array('index')),
//	//array('label'=>'Manage Announcements', 'url'=>array('admin')),
//);
?>

<h1>Создать объявление</h1>

<?php echo $this->renderPartial('_form', array(
    'model'=>$model,
    'category'=>$category,
    'user'=>$user
)); ?>