<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('actions-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<?php
$js_operation =<<< EOD
function() {
    $('.loader').show();
    var url = $(this).attr('href');
    $.get(url, function(response) {
        $('#actions-grid').replaceWith(response);
        $('.loader').hide();
    });
    return false;
}
EOD;
?>

<div class="loader"></div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'actions-grid',
	'dataProvider'=>$dataProvider,
	'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
        'nextPageLabel'=>'',
        'prevPageLabel'=>'',
        'firstPageLabel'=>'',
        'lastPageLabel'=>'',
    ),
	'columns'=>array(
        array(
            'type'=>'raw',
            'value'=>'CHtml::image(CHtml::encode("/uploads/actions/mini_".$data->img))',
            'header'=>'Фото',
        ),
		array(
            'type'=>'raw',
            'value'=>'CHtml::link(Functions::extractIntro($data->title, 100), Yii::app()->createUrl("actions/view", array("id"=>$data->id)))',
            'header'=>'Заголовок',
        ),
		array(
            'type'=>'raw',
            'value'=>'Lookup::model()->item(Lookup::ANNOUNCEMENTS_STATUS, $data->status)',
            'header'=>'Статус',
        ),
        array(
            'type'=>'raw',
            'value'=>'CHtml::link($data->user->user_login, Yii::app()->createUrl("users/view", array("id"=>$data->user_id)))',
            'header'=>'Пользователь',
        ),
        array(
            'type'=>'raw',
            'value'=>'Functions::getCalendarDay($data->last_update, true)',
            'header'=>'Дата изменения',
        ),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{status}{blocked}',
            'buttons'=>array
            (
                'status' => array
                (
                    'label'=>'Опубликовать',
                    //'imageUrl'=>Yii::app()->request->baseUrl.'/images/dollar.png',
                    'url'=>'Yii::app()->createUrl("site/moderation", array("operation"=>"public_act", "id"=>$data->id))',
                    'visible'=>'$data->status==1 || $data->status==3',
                    'click'=>$js_operation,
                ),
                'blocked' => array
                (
                    'label'=>'Заблокировать',
                    //'imageUrl'=>Yii::app()->request->baseUrl.'/images/dollar.png',
                    'url'=>'Yii::app()->createUrl("site/moderation", array("operation"=>"block_act", "id"=>$data->id))',
                    'visible'=>'$data->status==2',
                    'click'=>$js_operation,
                ),
            ),

		),
	),
)); ?>
