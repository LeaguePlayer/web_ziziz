

<?php
$this->pageTitle = 'ZIZIZ | Просмотр сообщений';

$this->breadcrumbs=array(
	'Личный кабинет'=>array('users/view', 'id'=>Yii::app()->user->id),
    'Мои cообщения'
);

//$this->menu=array(
//	array('label'=>'Create Messages', 'url'=>array('create')),
//	array('label'=>'Manage Messages', 'url'=>array('admin')),
//);
?>
<div id="messages_anker">
<h1>Мои сообщения</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
    'template'=> "{items}{pager}",
    'pager'=>array(
		'class'=>'CLinkPager',
        'cssFile'=>false,
        'header'=>'',
        'nextPageLabel'=>'',
        'prevPageLabel'=>'',
        'firstPageLabel'=>'',
        'lastPageLabel'=>'',
    ),
)); ?>
</div>

<script>
    $('.default-button').live('click', function(){
        var id = $(this).attr('rel');
        if ($(this).val()=='Прочитано') {
            $(this).parent().prev().prev('.hor_loader').show();
            $.ajax({
                url: 'messages/index',
                type: 'POST',
                data: {mark_message: id},
                success: function(data){
                    $('#message-'+id).replaceWith(data);
                }
            });
        }
        else {
            if (confirm("Вы уверены, что хотите удалить это сообщение?")) {
                $('#message-'+id).slideUp(300);
                $.ajax({
                    url: 'messages/index',
                    type: 'POST',
                    data: {del_message: id},
                    success: function(data){
                        $('#message-'+id).remove();
                    }
                });
            }
        }
        return false;
    });
</script>
