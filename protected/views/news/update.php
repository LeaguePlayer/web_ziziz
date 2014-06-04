<?php
$this->pageTitle = "ZIZIZ | Редактирование новости - ".$model->title;

$this->breadcrumbs=array(
	'Новости'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Редактирование',
);

//$this->menu=array(
//	array('label'=>'Список новостей', 'url'=>array('index')),
//	array('label'=>'Создать новость', 'url'=>array('create')),
//	array('label'=>'Просмотр новости', 'url'=>array('view', 'id'=>$model->id)),
//	array('label'=>'Управление новостями', 'url'=>array('admin')),
//);
?>

<h1>Редактирование "<?php echo $model->title; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>