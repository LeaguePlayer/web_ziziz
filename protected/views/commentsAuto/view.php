<?php
$this->breadcrumbs=array(
	'Comments Autos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CommentsAuto', 'url'=>array('index')),
	array('label'=>'Create CommentsAuto', 'url'=>array('create')),
	array('label'=>'Update CommentsAuto', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CommentsAuto', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CommentsAuto', 'url'=>array('admin')),
);
?>

<h1>View CommentsAuto #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'from_user_id',
		'date_public',
		'text',
		'branch_id',
	),
)); ?>
