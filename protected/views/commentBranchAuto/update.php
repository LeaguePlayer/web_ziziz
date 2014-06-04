<?php
$this->breadcrumbs=array(
	'Comment Branch Autos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CommentBranchAuto', 'url'=>array('index')),
	array('label'=>'Create CommentBranchAuto', 'url'=>array('create')),
	array('label'=>'View CommentBranchAuto', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CommentBranchAuto', 'url'=>array('admin')),
);
?>

<h1>Update CommentBranchAuto <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>