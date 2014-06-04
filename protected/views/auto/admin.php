<?php
$this->breadcrumbs=array(
	'Autos'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Auto', 'url'=>array('index')),
	array('label'=>'Create Auto', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('auto-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Autos</h1>

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
	'id'=>'auto-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'auto_id',
		'auto_title',
		'auto_user',
		'auto_fuel',
		'auto_box',
		/*
		'auto_drive',
		'auto_vol',
		'auto_run',
		'auto_year',
		'auto_desc',
		'auto_public_date',
		'auto_actual_date',
		'auto_status',
		'auto_price',
		'auto_model_id',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
