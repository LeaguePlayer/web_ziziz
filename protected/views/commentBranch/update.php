<?php
$this->breadcrumbs=array(
	'Comment Branches'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CommentBranch', 'url'=>array('index')),
	array('label'=>'Create CommentBranch', 'url'=>array('create')),
	array('label'=>'View CommentBranch', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CommentBranch', 'url'=>array('admin')),
);
?>

<h1>Update CommentBranch <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>