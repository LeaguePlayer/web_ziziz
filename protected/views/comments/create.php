<?php $this->pageTitle = "ZIZIZ | Вопросы и ответы"; ?>

<?php echo $this->renderPartial('_form', array(
    'model'=>$model,
    'branch'=>$branch
)); ?>
