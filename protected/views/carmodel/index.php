<?php
$this->breadcrumbs=array(
	'Carmodels',
);

$this->menu=array(
	array('label'=>'Create Carmodel', 'url'=>array('create')),
	array('label'=>'Manage Carmodel', 'url'=>array('admin')),
);
?>

<h1>Carmodels</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
