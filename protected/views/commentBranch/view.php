<?php
$this->breadcrumbs=array(
	'Comment Branches'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CommentBranch', 'url'=>array('index')),
	array('label'=>'Create CommentBranch', 'url'=>array('create')),
	array('label'=>'Update CommentBranch', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CommentBranch', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CommentBranch', 'url'=>array('admin')),
);
?>

<h1>View CommentBranch #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'ann_id',
	),
)); ?>
