<?php
$this->breadcrumbs=array(
	'Categories',
);

$this->menu=array(
	array('label'=>'Create Category', 'url'=>array('create')),
	array('label'=>'Manage Category', 'url'=>array('admin')),
);
?>

<h1>Categories</h1>

<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <th>Категория</th>
        <th>Классификатор</th>
    </tr>
    <?
    $data = $dataProvider->getData();
    foreach($data as $d){
    ?>
    <tr>
        <td><?php echo CHtml::encode($d->cat_name); ?></td>
        <td>
        <?php
            foreach($d->classifies as $cl){
                echo $cl->classif_name;
            }
        ?>
        </td>
    </tr>
    <?}?>
</table>
<?php/* $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); *?>
