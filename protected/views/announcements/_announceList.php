
    <?php
    	if($cur_category->classifiersCount > 0)
	        echo $this->renderPartial('_classifierBar', array(
	            'cur_category' => $cur_category,
	            'check_classif' => $check_classif,
	        ));
    ?>
    
    <div class="line_shadow"></div>
    <div class="btn_panel">
		<a class="button_add_announce normal" href="<?=$this->createUrl('announcements/create') ?>" style="margin-bottom: 10px;"></a>
	    <?php if(!$session_cleared): ?>
			<div class="button_clear_search"></div>
		<?php endif; ?>
	</div>
	
<?php
	$this->widget('zii.widgets.CListView', array(
	    'id'=>'announc_list',
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view',
	    'template'=> "{items}{pager}",
		'emptyText'=>'Ничего не найдено!',
	    'pager'=>array(
			'class'=>'CLinkPager',
	        'cssFile'=>false,
	        'header'=>'',
	        'nextPageLabel'=>'',
	        'prevPageLabel'=>'',
            'firstPageLabel'=>'',
            'lastPageLabel'=>'',
	    ),
	));
?>