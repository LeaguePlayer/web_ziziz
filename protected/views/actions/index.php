<?php

$this->pageTitle = 'ZIZIZ | Акции';


$this->breadcrumbs=array(
	'Акции',
);

//$this->menu=array(
//	array('label'=>'Создать новость', 'url'=>array('create')),
//);
?>

<h2>Акции</h2>

<a class="default-button" href="<?=$this->createUrl('actions/create') ?>" class="add_news">Добавить акцию</a>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
    'summaryText'=>'Найдено {count} акций',
        'emptyText'=>'Не найдено акции.',
	'itemView'=>'_view',
    'pager'=>array(
        'firstPageLabel'=>'',
        'header'=>'',
        'prevPageLabel'=>'',
        'nextPageLabel'=>'',
        'lastPageLabel'=>'',
        'cssFile'=>false
    )
)); ?>
