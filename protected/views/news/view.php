<?php
if($model->meta_title) $this->pageTitle = $model->meta_title;
else $this->pageTitle = $model->title;

$this->breadcrumbs=array(
	'Новости'=>array('index'),
	$model->title,
);

?>

<div class="typography">
<h1><?php echo $model->title; ?></h1>

<?php $this->renderPartial('_view-once',array(
	'model'=>$model,
)); ?>
</div>

<?php if (Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('root')): ?>
    <a href="<?=$this->createUrl('update', array('id'=>$model->id))?>" class="default-button">Редактировать</a>
    <a style="width: 68px;" href="<?=$this->createUrl('delete', array('id'=>$model->id))?>" class="default-button">Удалить</a>
    <a href="<?=$this->createUrl('create')?>" class="default-button">Добавить новую</a>
<?php endif; ?>