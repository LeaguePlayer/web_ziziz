<?php
$this->breadcrumbs=array(
	'Comment Branch Autos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CommentBranchAuto', 'url'=>array('index')),
	array('label'=>'Create CommentBranchAuto', 'url'=>array('create')),
	array('label'=>'Update CommentBranchAuto', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CommentBranchAuto', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CommentBranchAuto', 'url'=>array('admin')),
);
?>

<h1>View CommentBranchAuto #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'auto_id',
	),
)); ?>
