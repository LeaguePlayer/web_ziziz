<?php
$this->breadcrumbs=array(
	'Slider Photos'=>array('index'),
	'Create',
);

//$this->menu=array(
//	array('label'=>'List SliderPhoto', 'url'=>array('index')),
//	array('label'=>'Manage SliderPhoto', 'url'=>array('admin')),
//);
?>

<h1>Управление слайдером</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>