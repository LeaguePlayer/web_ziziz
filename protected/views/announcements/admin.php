<?php
$this->breadcrumbs=array(
	'Announcements'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Announcements', 'url'=>array('index')),
	array('label'=>'Create Announcements', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('announcements-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Announcements</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'announcements-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'ann_id',
		'ann_category',
		'ann_name',
		'ann_status',
		'ann_user_id',
		'ann_actual_date',
		/*
		'ann_gallery_id',
		'ann_state',
		'ann_public_date',
		'ann_desc',
		'ann_classif',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
