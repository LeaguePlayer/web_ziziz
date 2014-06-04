<?php
$this->breadcrumbs=array(
	'Comment Branch Autos',
);

$this->menu=array(
	array('label'=>'Create CommentBranchAuto', 'url'=>array('create')),
	array('label'=>'Manage CommentBranchAuto', 'url'=>array('admin')),
);
?>

<h1>Comment Branch Autos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
