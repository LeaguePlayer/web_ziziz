<div class="block-adds">

</div>
<div class="classifiers">
<style>
    .item-val{
        margin-left: 15px;
    }
</style>
<?php
    foreach($classifiers as $cl){
        echo "<div><strong>$cl->classif_name</strong></div>";
        foreach($cl->values as $val){
            echo "<div class='item-val'>".CHtml::encode($val->cv_value)." (<a class='add_val' href='#add' onclick='add($val->cv_id)'>Добавить</a>)".CHtml::activeHiddenField(AnnClassif::model(),'[]ac_classifval_id',array('value'=>$val->cv_id, 'disabled'=>'disabled'))."</div>";
        }
    } 
?>
</div>
<script type="text/javascript">
    jQuery('.add_val').toggle(
        function(){
            jQuery(this).text('Удалить').next().removeAttr('disabled');
            
        },
        function(){
            jQuery(this).text('Добавить').next().attr('disabled','disabled');
        }
    );
</script>