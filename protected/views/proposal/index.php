<?php
$this->breadcrumbs=array(
	'Proposals',
);

$this->menu=array(
	array('label'=>'Create Proposal', 'url'=>array('create')),
	array('label'=>'Manage Proposal', 'url'=>array('admin')),
);
?>

<h1>Proposals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
