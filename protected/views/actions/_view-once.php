

<div class="time" style="margin-bottom: 10px; float: right;"><?=Functions::getCalendarDay($model->actual_date, true)?></div>

<div class="clear"></div>

<div id="bg_news">

    <div class="actions-photo">
        <?
            $body_img = CHtml::image('/uploads/actions/' . $model->img, '', array('class'=>'new l_m'));
            $self_link = '/uploads/actions/' . $model->img;
            echo CHtml::link($body_img, $self_link, array('class'=>'fancybox','rel'=>'one_game'));
        ?>
    </div>
    
    <div class="news-desc">
        <?=$model->full_desc?>
    </div>

</div>