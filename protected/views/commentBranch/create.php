<?php
$this->breadcrumbs=array(
	'Comment Branches'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CommentBranch', 'url'=>array('index')),
	array('label'=>'Manage CommentBranch', 'url'=>array('admin')),
);
?>

<h1>Create CommentBranch</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>