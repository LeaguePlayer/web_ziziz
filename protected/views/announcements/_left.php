
<?php echo  CHtml::hiddenField('brenmodel', $brendmodel); ?>

<div class="left-menu">

    <div class="text_title_left top">

        Для автомобиля:

    </div>

    <div style="padding: 0 0 10px 14px; margin: 0; background-color: #e8e8ec;">
        <div id="brends_search" class="bar-item" style="overflow: hidden;">
            <label style="display: block;">Марка</label>
            <?php //Yii::app()->request->baseUrl.$this->createUrl('/auto/renderModelByBrendId')
            $this->widget('ext.combobox.EJuiComboBox', array(
                'name' => 'AutoSearch[brend]',
                'value' => $brend,
                // data to populate the select. Must be an array.
                'data' =>  CHtml::listData(Brend::model()->findAll(), 'b_id', 'b_name'),
                'assoc' => true,
                //'cssFile' => false,
                // options passed to plugin
                'options' => array(
                    'onSelect' => "
                        jQuery.ajax({
                            type: 'GET',
                            url: '/auto/renderModelByBrendId/',
                            data: {
                                brend_id: $('#AutoSearch_brend').val(),
                            },
                            success: function(data){
                                jQuery('#models_search').html(data);
                            }
                        });

                        jQuery.ajax({
                            type: 'POST',
                            url: '/announcements/index/',
                            data: {
                                    brend_id: $('#AutoSearch_brend').val(),
                            },
                            success: function(data){
                                $('#listview-container').html(data);
                            }
                        });
                                ",
                    //'onChange' => '',
                    'allowText' => true,
                ),
                // Options passed to the text input
                'htmlOptions' => array('size' => 10),
            )); ?>

        </div>

        <div id="models_search" class="bar-item"></div>
    </div>

    <div class="text_title_left">Разделы:</div>
    
        <ul id="sections">
        	<ul>
    			<li>
    				<div class="item unactiv" rel="all">
    		        	<?php echo CHtml::link('Все объявления', $this->createUrl('announcements/index', array('cat_id'=>'all')), array(
    		                'rel' => 'all',
    		            )); ?>
    		            <?php
							$count = Announcements::model()->with(array(
								'user'=>array(
									'select'=>'user_city_id',
								)
							))->count(
								'ann_status='.Announcements::STATUS_PUBLISHED
								.' AND user.user_city_id='.$city_id
							);
						?>
    					<span class="count"><?php echo $count; ?></span>
    				</div>
    			</li>
    		</ul>
       		<?php if ($categories): ?>
                <?php foreach ($categories as $cat): ?>
                	<?php if ($cat->cat_parent != 0) continue; ?>
                	<ul>
    					<?php $this->renderPartial('_branch', array(
							'category'=>$cat,
							'root'=>true,
							'cur_category'=>$cur_category,
							'city_id'=>$city_id,
						)); ?>
                	</ul>
    			<?php endforeach; ?>
            <?php endif; ?>
        </ul>
        
        <?php echo CHtml::beginForm(); ?>
            <div class="text_title_left">Цена:</div>
            <div class="price-form">
                <?php echo CHtml::activeTextField($form, 'price_ot', array(
                        'class'=>'price_ot',
                    )); ?>
                    <span class="text-do">до</span>
                    <?php echo CHtml::activeTextField($form, 'price_do', array(
                        'class'=>'price_do',
                    )); ?>
            </div>
            
            <div class="left-button">
                <?php
                	echo CHtml::ajaxSubmitButton('Применить', $this->createUrl('index'),
                		array(
                			'type'=>'POST',
                			'update'=>'#listview-container',
                			//'beforeSend'=>"js:",
                		),
                		array(
                			'id'=>'apply',
                			'type'=>'submit',
                		)
                	);
                ?>
            </div>
        <?php echo CHtml::endForm(); ?>
</div>

<script>

    $(document).ready(function(){
        if ($('#AutoSearch_brend').val()!='')
        {
            jQuery.ajax({
                type: 'GET',
                url: '/auto/renderModelByBrendId/',
                data: {
                    brend_id: $('#AutoSearch_brend').val(),
                    model_id: $('#brenmodel').val()
                },
                success: function(data){
                    jQuery('#models_search').html(data);
                }
            });
        }
    });


	$('#apply').click(function(){
		$ann_list = $('#announc_list').html();
		$('#announc_list').html('<div class="loader"></div>');
	});
</script>
        