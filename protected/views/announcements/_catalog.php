
    <div class="bottom">
        <div class="left">
            <?php $this->renderPartial('_left', array(
				'categories'=>$categories,
				'form'=>$form,
				'cur_category'=>$cur_category,
				'city_id'=>$city_id,
                'brend'=>$brend,
                'brendmodel'=>$brendmodel
			)); ?>


        </div>
	    <div class="right">
	        <div id="search">
	            <?php $this->widget('AnnSearch', array(
                    'params' => array(
                        'url' => $this->createUrl('announcements/index'),
                        'update'=>'#listview-container',
                        'mod-form'=>false,
                    ),
                )); ?>
                <div class="clear-search"></div>
	        </div>
	        
	        <div id="listview-container">
	        	<?php echo $this->renderPartial('_announceList', array(
                    'dataProvider'=>$dataProvider,
                    'session_cleared' => $session_cleared,
                    'cur_category' => $cur_category,
                    'check_classif' => $check_classif,
                ), true, false); ?>
	        </div>
	        
	    </div>
    </div>