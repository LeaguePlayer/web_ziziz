<?php
$this->pageTitle = "ZIZIZ | Создание новости.";

$this->breadcrumbs=array(
	'Новости'=>array('index'),
	'Создать',
);

//$this->menu=array(
//	array('label'=>'Список новостей', 'url'=>array('index')),
//	array('label'=>'Управление новостями', 'url'=>array('admin')),
//);
?>

<h1>Создать новость</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>