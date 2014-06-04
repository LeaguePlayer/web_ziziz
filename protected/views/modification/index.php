<?php
$this->breadcrumbs=array(
	'Модификации',
);

$this->menu=array(
	array('label'=>'Добавить', 'url'=>array('create')),
	array('label'=>'Управление модификациями', 'url'=>array('admin')),
);
?>

<h1>Модификации</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
