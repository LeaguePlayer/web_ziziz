<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('announcements-grid', {
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
        $('#announcements-grid').replaceWith(response);
        $('.loader').hide();
    });
    return false;
}
EOD;
?>

<div class="loader"></div>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'announcements-grid',
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
            'value'=>'CHtml::image(CHtml::encode(str_replace(\'original_\',\'thumbs/mini_\',$data->gall->original[0]->ph_url)))',
            'header'=>'Фото',
        ),
		array(
            'type'=>'raw',
            'value'=>'CHtml::link($data->ann_name, Yii::app()->createUrl("announcements/view", array("id"=>$data->ann_id, "gorod"=>$data->user->city->translit)))',
            'header'=>'Заголовок',
        ),
		array(
            'type'=>'raw',
            'value'=>'Lookup::model()->item(Lookup::ANNOUNCEMENTS_STATUS, $data->ann_status)',
            'header'=>'Статус',
        ),
        array(
            'type'=>'raw',
            'value'=>'CHtml::link($data->user->user_login, Yii::app()->createUrl("users/view", array("id"=>$data->user->user_id)))',
            'header'=>'Пользователь',
        ),
        array(
            'type'=>'raw',
            'value'=>'Functions::when_it_was($data->ann_public_date)',
            'header'=>'Дата публикации',
        ),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{status}{blocked}',
            'buttons'=>array
            (
                'status' => array
                (
                    'label'=>'Подтвердить',
                    //'imageUrl'=>Yii::app()->request->baseUrl.'/images/dollar.png',
                    'url'=>'Yii::app()->createUrl("site/moderation", array("operation"=>"public_ann", "id"=>$data->ann_id))',
                    'visible'=>'$data->ann_status==1 || $data->ann_status==3',
                    'click'=>$js_operation,
                ),
                'blocked' => array
                (
                    'label'=>'Заблокировать',
                    //'imageUrl'=>Yii::app()->request->baseUrl.'/images/dollar.png',
                    'url'=>'Yii::app()->createUrl("site/moderation", array("operation"=>"block_ann", "id"=>$data->ann_id))',
                    'visible'=>'$data->ann_status==2',
                    'click'=>$js_operation,
                ),
            ),

		),
	),
)); ?>
