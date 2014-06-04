<?php
$this->breadcrumbs=array(
	'Comment Branch Autos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CommentBranchAuto', 'url'=>array('index')),
	array('label'=>'Manage CommentBranchAuto', 'url'=>array('admin')),
);
?>

<h1>Create CommentBranchAuto</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>