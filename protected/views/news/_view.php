
<div class="news-view">
    <div class="news-photo">
        <?php
        if (file_exists($_SERVER['DOCUMENT_ROOT'].Yii::app()->params['news_folder'].'mini_'.$data->img))
            echo CHtml::image(Yii::app()->params['news_folder'].'mini_'.$data->img);
        else
            echo CHtml::image('/images/news_img.jpg', 'no-photo', array(
                'width' => 70,
                'height' => 70,
            ));
        ?>
    </div>
    <div class="info">
        <div class="news-title"><?php echo CHtml::link(Functions::extractIntro($data->title, 220), array('/news/view', 'id'=>$data->id)); ?></div>
        <div class="time"><?=Functions::getCalendarDay($data->last_update, true)?></div>
        <div class="news_desc"><?=(strlen($data->short_desc) < 400) ? Functions::extractIntro(strip_tags($data->full_desc), 400) : Functions::extractIntro($data->short_desc, 400) ?></div>
    </div>
    
    <?php if (Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('root')): ?>
    <form method="POST" action="<?=$this->createUrl('news/delete', array('id'=>$data->id))?>"><button class="message-delete"></button></form>
    <?php endif; ?>

</div>