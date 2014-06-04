<?php
    Yii::app()->getClientScript()->registerCssFile('/css/ziziz/moderation.css');
?>

<div id="moderation_view" style="margin-top: 80px;">

<?php
$this->widget('zii.widgets.jui.CJuiAccordion', array(
    'panels'=>array(
        'Объявления запчасти'=>$this->renderPartial('_admin_ann',array('dataProvider'=>$dataProvider1),true),
        'Объявления авто'=>$this->renderPartial('_admin_auto',array('dataProvider'=>$dataProvider2),true),
        'Акции'=>$this->renderPartial('_admin_act',array('dataProvider'=>$dataProvider3),true),
    ),
     //additional javascript options for the accordion plugin
    'options'=>array(
        'animated'=>'bounceslide',
        'heightStyle'=>"content",
        'collapsible'=>true
    ),
));

?>

</div>