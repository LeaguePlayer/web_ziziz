<?php
$this->breadcrumbs=array(
	'Comment Branches',
);

$this->menu=array(
	array('label'=>'Create CommentBranch', 'url'=>array('create')),
	array('label'=>'Manage CommentBranch', 'url'=>array('admin')),
);
?>

<h1>Comment Branches</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
