<h1><?=$message_title?></h1>

<p style="margin-bottom: 0;" class="default-message"><?=$message?></p>

<?php if(!Yii::app()->request->isAjaxRequest): ?>
<?php if (isset($returnUrl)): ?>
    <a class="default-button" href="<?php echo $returnUrl?>">Принято</a>
<?php else: ?>
    <a href="<?php echo Yii::app()->homeUrl?>">На главную</a>
<?php endif; ?>
<?php endif ?>