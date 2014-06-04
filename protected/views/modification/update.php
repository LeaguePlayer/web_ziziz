<?php
$this->breadcrumbs=array(
	'Modifications'=>array('index'),
	$model->mod_id=>array('view','id'=>$model->mod_id),
	'Update',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Добавить', 'url'=>array('create')),
	array('label'=>'Просмотр', 'url'=>array('view', 'id'=>$model->mod_id)),
	array('label'=>'Управление модификациями', 'url'=>array('admin')),
);
?>

<h1>Редактирование модификации <?php echo $model->mod_name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>