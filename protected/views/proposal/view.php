<?php
$this->breadcrumbs=array(
	'Proposals'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Proposal', 'url'=>array('index')),
	array('label'=>'Create Proposal', 'url'=>array('create')),
	array('label'=>'Update Proposal', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Proposal', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Proposal', 'url'=>array('admin')),
);
?>

<h1>Заявка № <?php echo $model->id; ?> - (<?=Lookup::item(Lookup::PROPOSAL_TYPE, $model->type)?>) успешно принята </h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'type',
		'user_id',
		'description',
		'user_phone',
	),
)); 
echo CHtml::link('На главную', $this->createUrl('site/index'));
?>
