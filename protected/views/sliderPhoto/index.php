<?php
$this->breadcrumbs=array(
	'Slider Photos',
);

$this->menu=array(
	array('label'=>'Create SliderPhoto', 'url'=>array('create')),
	array('label'=>'Manage SliderPhoto', 'url'=>array('admin')),
);
?>

<h1>Slider Photos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
