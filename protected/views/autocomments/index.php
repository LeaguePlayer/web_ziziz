<?php
$this->breadcrumbs=array(
	'Autocomments',
);

$this->menu=array(
	array('label'=>'Create Autocomments', 'url'=>array('create')),
	array('label'=>'Manage Autocomments', 'url'=>array('admin')),
);
?>

<h1>Autocomments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
