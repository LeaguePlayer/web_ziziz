<h1><?=$message_title?></h1>

<p class="default-message"><?=$message?></p>
<?php if (isset($returnUrl)): ?>
    <a class="default-button" href="<?php echo $returnUrl?>">Принято</a>
<?php else: ?>
    <a href="<?php echo Yii::app()->homeUrl?>">На главную</a>
<?php endif; ?>