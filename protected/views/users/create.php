<?php
$this->breadcrumbs=array(
	'Регистрация нового пользователя',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	//array('label'=>'Manage Users', 'url'=>array('admin')),
);
?>

<h1>Создать пользователя</h1>

<?php echo $this->renderPartial('_preform', array('model'=>$model)); ?>