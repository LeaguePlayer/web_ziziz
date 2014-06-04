<?php
$this->breadcrumbs=array(
	'Список классификаторов',
);

$this->menu=array(
	array('label'=>'Создать классификатор', 'url'=>array('create')),
	//array('label'=>'Manage Classifier', 'url'=>array('admin')),
);
?>
<style>
    #classif td, #classif th{
        border-bottom: 1px dashed #aaa;
        border-collapse: collapse;
        padding: 10px 5px;
    }
</style>

<h1>Классификаторы</h1>

<table id="classif">
    <tr>
        <th>Классификатор</th>
        <th>Значения</th>
    </tr>
    <?php
    foreach($data as $d)
    {?>
    <tr>
        <td><?php echo CHtml::link(CHtml::encode($d->classif_name), array('view', 'id'=>$d->classif_id)); ?></td>
        <td>
            <?=CHtml::activeHiddenField(ClassifValue::model(), 'cv_classif_id', array('value'=>$d->classif_id, 'class'=>'classif-id'))?>
        
            
            <?php foreach($d->values as $val): ?>
                <div class="edit">
                <?php echo CHtml::activeTextField(ClassifValue::model(), 'cv_value',array(
                    'value'=>CHtml::encode($val->cv_value),
                    'onblur'=>"update(this,{$val->cv_id})",
                    'onfocus'=>'setStr(this)'));
                ?>    
                <a href='#delete' onclick='delete_cv(<?=$val->cv_id?>)'>Удалить</a>
                </div>
            <?php endforeach; ?>
            <div style="padding: 3px 0;">
                <? echo CHtml::activeTextField(new ClassifValue, 'cv_value')?>
                <a href="#add" onclick="add(this)">Добавить</a>               
            </div>
        </td>
    </tr>
    <?php }?>
</table>
<script type="text/javascript">
    var str = '';
    function setStr(obj)
    {
        str = jQuery(obj).val();
        //console.log(str);
    }
    function update(obj, id){
        if(jQuery(obj).val() != '' && typeof(id) === 'number' && str != jQuery(obj).val()){
            var classif_id = jQuery(obj).parents('td').find('.classif-id').val();
            var val = jQuery(obj).val();
            var CV = {cv_classif_id : classif_id, cv_value: val};
            
            jQuery.ajax({
              type: "POST",
              url: "<?=$this->createUrl('classifValue/update')?>/"+id,
              data: ({ajax : 1, ClassifValue: CV}),
              success: function(data){
                    //console.log(data);
                    //window.location.reload(true);
              }
            });
        }
    }
    function add(obj)
    {
        var id = jQuery(obj).parents('td').find('.classif-id').val();
        var val = jQuery(obj).prev().val();
        var CV = {cv_classif_id : id, cv_value: val};
        jQuery.ajax({
          type: "POST",
          url: "<?=$this->createUrl('classifValue/create')?>",
          data: ({ajax : 1, ClassifValue: CV}),
          success: function(data){
                console.log(data);
                window.location.reload(true);
          }
        });
        //alert(cat+' '+classif);
    }
    function delete_cv(id)
    {
        if(typeof(id) === 'number'){
            //alert(typeof(id));
            jQuery.ajax({
              type: "POST",
              url: "<?=$this->createUrl('classifValue/delete')?>/"+id,
              data: {ajax: 1},
              success: function(data){
                    //console.log(data);
                    window.location.reload(true);
              }
            });
        }
    }
</script>