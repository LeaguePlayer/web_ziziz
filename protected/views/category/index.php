<?php
$this->breadcrumbs=array(
	'Категории',
);

$this->menu=array(
	array('label'=>'Создать категорию', 'url'=>array('create')),
	//array('label'=>'Управление категориями', 'url'=>array('admin')),
);
?>

<h1>Категории</h1>

<style>
    #cats td, #cats th{
        border-bottom: 1px dashed #aaa;
        border-collapse: collapse;
        padding: 10px 5px;
    }
</style>

<table id="cats" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <th>Категория</th>
        <th>Классификатор</th>
    </tr>
    <?
    //$data = $dataProvider->getData();
    /*foreach ($data as $k => $row)
        {
            if($row->parent)
                echo $row->cat_name.' / '.$row->parent->cat_name.'<br/>';
            else
                echo '<b>'.$row->cat_name.'</b><br/>';
        }*/
        $this->recTreeCats();
    ?>
            
    <?php foreach($data as $category): ?>
	    <tr>
	        <td>
				<?php echo CHtml::link(CHtml::encode($category->cat_name), array('view', 'id'=>$category->cat_id)); ?>
			</td>
	        <td>
		        <?php $arr = array(); ?>
		        <?php foreach($category->classifiers(array('joinType'=>'INNER JOIN')) as $classifier): ?>
		            <?php $arr[] = $classifier->classif_id; ?>
		            <div>
		                <?php echo CHtml::encode($classifier->classif_name); ?>
		                <a href="#del" onclick="delete_cc(<?php echo $category->cat_id;?>, <?php echo $classifier->classif_id;?>)">Удалить</a>
		            </div>
		        <?php endforeach; ?>
		        <?php
		            $criteria = new CDbCriteria;
		            $criteria->addNotInCondition('t.classif_id', $arr, 'OR');
            		$cc = CatClassif::model();
		            $cats = Classifier::model()->findAll($criteria);
            	?>		                                    
	            <?php if (!empty($cats)): ?>
	                <?php echo CHtml::activeDropDownList($cc, 'cc_classif_id', CHtml::listData($cats, 'classif_id', 'classif_name')); ?>
		            <?php echo CHtml::activeHiddenField($cc, 'cc_cat_id',array('value'=>$category->cat_id)); ?>
	                <div>
	                    <a href="#add" onclick="js:add(this)">Добавить</a>
	                </div>
	            <?php endif; ?>
	        </td>
	    </tr>
    <?php endforeach; ?>
    
</table>
<script type="text/javascript">
    function add(obj){
        var cat = jQuery(obj).parent().prev().val();
        var classif = jQuery(obj).parent().prev().prev().val();
        var CatClassif = {cc_classif_id : classif, cc_cat_id: cat};
        jQuery.ajax({
          type: "POST",
          url: "<?=$this->createUrl('catClassif/create')?>",
          data: ({ajax : 1, CatClassif: CatClassif}),
          success: function(data){
                //alert(data);
                window.location.reload(true);
          }
        });
        //alert(cat+' '+classif);
    }
    function delete_cc(cat, classif) {
        if(typeof(cat) === 'number' && typeof(classif) === 'number') {
            //alert(typeof(cat));
            //alert("<?php echo $this->createUrl('catClassif/delete',array('id'=>0)); ?>");
            //exit();
            jQuery.ajax({
              type: "POST",
              url: "<?php echo $this->createUrl('catClassif/delete',array('id'=>0)); ?>",
              data: ({ajax: 1, catid: cat, classifid: classif}),
              success: function(data){
                    //alert(data);
                    window.location.reload(true);
              }
            });
        }
    }
</script>
<?php /* $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$categoryataProvider,
	'itemView'=>'_view',
)); */?>
