<?php
$this->pageTitle = "ZIZIZ | Добавление акции.";

$this->breadcrumbs=array(
	'Акции'=>array('index'),
	'Добавление акции',
);

//$this->menu=array(
//	array('label'=>'List Actions', 'url'=>array('index')),
//	array('label'=>'Manage Actions', 'url'=>array('admin')),
//);
?>

<h2>Добавление акции</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>