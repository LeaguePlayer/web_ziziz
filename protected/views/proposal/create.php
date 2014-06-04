<?php
$this->pageTitle = "ZIZIZ | Оформление заявки";

$this->breadcrumbs=array(
	'Оформление заявки',
);

//$this->menu=array(
//	array('label'=>'List Proposal', 'url'=>array('index')),
//	array('label'=>'Manage Proposal', 'url'=>array('admin')),
//);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'user'=>$user)); ?>