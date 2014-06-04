<div class="text_title_news_ads_actions">
    Акции<?php echo CHtml::link('посмотреть все', $this->createUrl('actions/index')); ?>
</div>

<?php foreach ($actions as $action): ?>
    <div class="action">
    	<a href="<?=$this->createUrl('actions/view', array('id'=>$action->id))?>"><?=$action->title?></a>
        <div class="text"><?=$action->short_desc?></div>
    </div>
<?php endforeach; ?>