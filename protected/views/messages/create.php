
<?php $this->pageTitle = "ZIZIZ | Отправка сообщения"; ?>

<?php
$this->breadcrumbs=array(
	'Создание сообщения',
);

//$this->menu=array(
//	array('label'=>'List Messages', 'url'=>array('index')),
//	array('label'=>'Manage Messages', 'url'=>array('admin')),
//);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>