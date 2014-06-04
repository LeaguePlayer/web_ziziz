<?php
$this->breadcrumbs=array(
	'Brends',
);

$this->menu=array(
	array('label'=>'Создать марку', 'url'=>array('create')),
	//array('label'=>'Manage Brend', 'url'=>array('admin')),
);
?>

<h1>Марки</h1>

<style>
    #classif td, #classif th{
        border-bottom: 1px dashed #aaa;
        border-collapse: collapse;
        padding: 10px 5px;
    }
</style>

<table id="classif">
    <tr>
        <th>Марка</th>
        <th>Модель</th>
    </tr>
    <?php
    foreach($data as $d){?>
    <tr>
        <td><?php echo CHtml::link(CHtml::encode($d->b_name), array('view', 'id'=>$d->b_id)); ?></td>
        <td>
            <?=CHtml::activeHiddenField(new Carmodel, 'm_brend_id', array('value'=>$d->b_id, 'class'=>'brend-id'))?>
            <?php
            foreach($d->models as $m){
                echo "<div class='edit'>".CHtml::activeTextField(new Carmodel, 'm_name',array('value'=>CHtml::encode($m->m_name), 'onblur'=>"update(this,{$m->m_id})", 'onfocus'=>'setStr(this)'))." (<a href='#delete' onclick='delete_m({$m->m_id})'>Удалить</a>)</div>";
            }?>
            <div style="padding: 3px 0;">
                <?=CHtml::activeTextField(new Carmodel, 'm_name')?> <a href="#add" onclick="add(this)">Добавить</a>
                
            </div>
        </td>
    </tr>
    <?php }?>
</table>
<script type="text/javascript">
    var str = '';
    function setStr(obj){
        str = jQuery(obj).val();
        //console.log(str);
    }
    function update(obj, id){
        if(jQuery(obj).val() != '' && typeof(id) === 'number' && str != jQuery(obj).val()){
            var model_id = jQuery(obj).parents('td').find('.brend-id').val();
            var val = jQuery(obj).val();
            var CV = {m_brend_id : model_id, m_name: val};
            
            jQuery.ajax({
              type: "POST",
              url: "<?=$this->createUrl('carmodel/update')?>&id="+id,
              data: ({ajax : 1, Carmodel: CV}),
              success: function(data){
                    window.location.reload(true);
              }
            });
        }
    }
    function add(obj){
        var model_id = jQuery(obj).parents('td').find('.brend-id').val();
        var val = jQuery(obj).prev().val();
        var CV = {m_brend_id : model_id, m_name: val};
        
        jQuery.ajax({
          type: "POST",
          url: "<?=$this->createUrl('carmodel/create')?>",
          data: ({ajax : 1, Carmodel: CV}),
          success: function(data){
                console.log(data);
                window.location.reload(true);
          }
        });
        //alert(cat+' '+classif);
    }
    function delete_m(id){
        if(typeof(id) === 'number'){
            //alert(typeof(id));
            jQuery.ajax({
              type: "POST",
              url: "<?=$this->createUrl('carmodel/delete')?>&id="+id,
              data: {ajax: 1},
              success: function(data){
                    //console.log(data);
                    window.location.reload(true);
              }
            });
        }
    }
</script>
