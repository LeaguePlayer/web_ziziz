
<div class="text_title_news_ads_actions">
    Новости<?php echo (count($news) == 0) ? "" : CHtml::link('посмотреть все', $this->createUrl('news/index')); ?>
</div>

<?php if (count($news) == 0): ?>
    <div class="default-text">Нет свежих новостей</div>
<?php endif; ?>

<?php foreach ($news as $one_news)
{
    echo CHtml::openTag('div', array('class' => 'news'));
    
        if (file_exists($_SERVER['DOCUMENT_ROOT'].Yii::app()->params['news_folder'].'mini_'.$one_news->img))
            echo CHtml::image(Yii::app()->params['news_folder'].'mini_'.$one_news->img, 'news', array(
                'width' => 70,
                'height' => 70,
            ));
        else
            echo CHtml::image('/images/news_img.jpg', 'no-photo', array(
                'width' => 70,
                'height' => 70,
            ));
        
        
        echo CHtml::openTag('div', array('class' => 'news_content'));
            echo CHtml::link(Functions::extractIntro($one_news->title, 70), Yii::app()->createUrl('news/view', array('id' => $one_news->id)));
            
            echo CHtml::openTag('div', array('class' => 'date'));
                echo Functions::getCalendarDay($one_news->last_update, true);
            echo CHtml::closeTag('div');
            
            echo CHtml::openTag('div', array('class' => 'text'));
                echo (strlen($one_news->short_desc) < 200) ? Functions::extractIntro(strip_tags($one_news->full_desc), 200) : Functions::extractIntro($one_news->short_desc, 200);
                
            echo CHtml::closeTag('div');
        echo CHtml::closeTag('div');
    echo CHtml::closeTag('div');
}
?>