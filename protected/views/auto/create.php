<?php
$this->pageTitle = "ZIZIZ | Автообъявления - Новое объявление";

$this->breadcrumbs=array(
	'Автообъявления'=>array('index'),
	'Новое объявление',
);

//$this->menu=array(
//	array('label'=>'Список', 'url'=>array('index')),
//	//array('label'=>'Manage Auto', 'url'=>array('admin')),
//);
?>

<h1>Авто объявление</h1>

<?php echo $this->renderPartial('_form', array(
    'model'=>$model,
    'brend'=>$brend,
    'automodel'=>$automodel,
    'modification'=>$modification,
    'user'=>$user,
    'brends'=>$brends
)); ?>

