<?php
$this->breadcrumbs=array(
	'Users',
);

$this->menu=array(
	array('label'=>'Создать пользователя', 'url'=>array('create')),
	//array('label'=>'Manage Users', 'url'=>array('admin')),
);
?>

<h1>Пользователи</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
