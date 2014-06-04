<?php
$this->breadcrumbs=array(
	'Comments Autos',
);

$this->menu=array(
	array('label'=>'Create CommentsAuto', 'url'=>array('create')),
	array('label'=>'Manage CommentsAuto', 'url'=>array('admin')),
);
?>

<h1>Comments Autos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
