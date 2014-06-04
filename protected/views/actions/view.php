<?php
$this->pageTitle = "ZIZIZ | " . $model->title;

$this->breadcrumbs=array(
	'Акции'=>array('index'),
	$model->title,
);
?>

<?php if (Yii::app()->user->id == $model->user_id): ?>
<div style="float: right;">
    <a href="<?=$this->createUrl('update', array('id'=>$model->id))?>" class="default-button">Редактировать</a>
    <a style="width: 68px;" href="<?=$this->createUrl('delete', array('id'=>$model->id))?>" class="default-button">Удалить</a>
    <a href="<?=$this->createUrl('create')?>" class="default-button">Добавить новую</a>
</div>
<div class="clear"></div>
<?php endif; ?>

<div class="typography">
<h1><?php echo $model->title; ?></h1>

<?php $this->renderPartial('_view-once',array(
	'model'=>$model,
)); ?>
</div>
