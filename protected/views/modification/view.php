<?php
$this->breadcrumbs=array(
	'Модификации'=>array('index'),
	$model->mod_name,
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Добавление', 'url'=>array('create')),
	array('label'=>'Редактирование', 'url'=>array('update', 'id'=>$model->mod_id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->mod_id),'confirm'=>'В уверены?')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<h1>Модификация <?php echo $model->mod_name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'mod_id',
		'mod_carcass',
		'mod_fuel',
		'mod_control',
		'mod_box',
		'mod_drive',
		'mod_vol',
		'mod_run',
		'mod_year',
	),
)); ?>
