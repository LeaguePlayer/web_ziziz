<?php
$this->breadcrumbs=array(
	'Категории'=>array('index'),
	'Добавление категории',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	//array('label'=>'Manage Category', 'url'=>array('admin')),
);
?>

<h1>Созлать категорию</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>