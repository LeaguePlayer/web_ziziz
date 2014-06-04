<?php
$this->breadcrumbs=array(
	'Список классификаторов'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	//array('label'=>'Manage Classifier', 'url'=>array('admin')),
);
?>

<h1>Создание классификатора</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>