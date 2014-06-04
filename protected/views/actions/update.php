<?php
$this->pageTitle = "ZIZIZ | Редактирование акции - ".$model->title;
$this->breadcrumbs=array(
	'Акции'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Редактирование',
);

?>

<h1>Редактирование акции - <?php echo $model->title; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>