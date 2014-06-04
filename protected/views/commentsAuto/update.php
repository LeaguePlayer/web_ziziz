<?php
$this->breadcrumbs=array(
	'Comments Autos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CommentsAuto', 'url'=>array('index')),
	array('label'=>'Create CommentsAuto', 'url'=>array('create')),
	array('label'=>'View CommentsAuto', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CommentsAuto', 'url'=>array('admin')),
);
?>

<h1>Update CommentsAuto <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>