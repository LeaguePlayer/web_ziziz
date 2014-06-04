<?php

$this->pageTitle = 'ZIZIZ | Новости';


$this->breadcrumbs=array(
	'Новости',
);

//$this->menu=array(
//	array('label'=>'Создать новость', 'url'=>array('create')),
//);
?>

<h2 style="margin-bottom: 0;">Новости</h2>

<?php if (Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('root')): ?>
    <a style="" href="<?=$this->createUrl('news/create') ?>" class="default-button">Добавить новость</a>
<?php endif; ?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
    'summaryText'=>'Найдено {count} новостей',
        'emptyText'=>'Новости по заданным параметрам не найдены.',
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
