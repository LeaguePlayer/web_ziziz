<?php
$this->breadcrumbs=array(
	'Модификации'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Управление модификациями', 'url'=>array('admin')),
);
?>

<h1>Создание модификации</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'brends'=>$brends)); ?>