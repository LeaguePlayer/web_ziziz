<?php
$this->breadcrumbs=array(
	'Autos'=>array('index'),
	$model->auto_id,
);

$this->menu=array(
	array('label'=>'List Auto', 'url'=>array('index')),
	array('label'=>'Create Auto', 'url'=>array('create')),
	array('label'=>'Update Auto', 'url'=>array('update', 'id'=>$model->auto_id)),
	array('label'=>'Delete Auto', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->auto_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Auto', 'url'=>array('admin')),
);
?>

<h1>View Auto #<?php echo $model->auto_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'auto_id',
		'auto_title',
		'auto_user',
		'auto_run',
		'auto_year',
		'auto_desc',
		'auto_public_date',
		'auto_actual_date',
		'auto_status',
		'auto_price',
		'auto_model_id',
	),
)); 
echo $model->automodel->modelbrend->b_name;?>
<?if(!empty($model->gall)){?>
    <div id="gallery">
        <?
        foreach($model->gall->original as $ph){
            echo "<a href='$ph->ph_url'>".CHtml::image(CHtml::encode(str_replace('original_','thumbs/mini_',$ph->ph_url)),'').'</a>';
        }        
        ?>
    </div>
<?}?>
