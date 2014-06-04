<div class="news-photo">
    <?
        $body_img = CHtml::image(Yii::app()->params['news_folder'] . $model->img, '', array('class'=>'new l_m', 'width'=>150, 'height'=>100));
        $self_link = Yii::app()->params['news_folder'] . $model->img;
        echo CHtml::link($body_img, $self_link, array('class'=>'fancybox','rel'=>'one_game'));
    ?>
</div>

<div class="time"><?=Functions::getCalendarDay($model->last_update, true)?></div>

<div class="news-desc">
    <?=$model->full_desc?>
</div>

<script>
    $(document).ready(function(){
        
    });
</script>