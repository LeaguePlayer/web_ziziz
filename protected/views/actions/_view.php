
<div class="news-view">
    <div class="news-photo">
        <?php
        if (file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads/actions/mini_'.$data->img))
            echo CHtml::image('/uploads/actions/mini_'.$data->img);
        else
            echo CHtml::image('/images/news_img.jpg', 'no-photo', array(
                'width' => 70,
                'height' => 70,
            ));
        ?>
    </div>
    <div class="info">
        <div class="news-title"><?php echo CHtml::link(Functions::extractIntro($data->title, 220), array('/actions/view', 'id'=>$data->id)); ?></div>
        <div class="time"><?=Functions::getCalendarDay($data->actual_date, true)?></div>
        <div class="news_desc"><?=(strlen($data->short_desc) < 300) ? Functions::extractIntro(strip_tags($data->full_desc), 300) : Functions::extractIntro($data->short_desc, 300) ?></div>
    </div>

</div>