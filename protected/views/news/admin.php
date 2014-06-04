<?php
$this->breadcrumbs=array(
	'Новости'=>array('index'),
	'Управление новостями',
);

$this->menu=array(
	array('label'=>'Список новостей', 'url'=>array('index')),
	array('label'=>'Создать новость', 'url'=>array('create')),
);
?>

<h1>Управление новостями</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'news-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'summaryText'=>'Найдено {count} новостей',
        'emptyText'=>'Новости по заданным параметрам не найдены.',    
	'columns'=>array(
		'id',
		'title',
        /*        
		'short_desc',
		'full_desc',
		'img',
		'date_public',
		
		'meta_title',
		'meta_keys',
		'meta_desc',
        */        
		'last_update',
		
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
