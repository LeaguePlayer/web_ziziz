<?php //if ($model->user_type==Users::USERTYPE_JUR_PERSON): ?>

<?php
    $counter = 0;
    foreach ($model->actions as $act)
    {
        if ($act->status == Actions::STATUS_PUBLISHED)
        {
            $counter++;
            break;
        }
    }
    // далее идет тяжеленное условие проверки нужно ли показывать заблокированные, либо удаленные, либо модерируемые акции
?>

<?php if ( ((Yii::app()->user->id == $model->user_id OR Yii::app()->user->checkAccess('moderator')) AND count($model->actions)!=0) OR 
    (Yii::app()->user->id != $model->user_id AND $counter > 0) ): ?>

<?php $this->beginWidget('CActiveForm', array('method'=>'POST')) ;?>
    
	<div class="text_row_title">Акции
        <?php if ($model->user_id == Yii::app()->user->id): ?>
            <div id="actions_pannel">
        		<div class="button act">
        	        <?php echo CHtml::submitButton('Удалить', array(
                        'class' => 'actions default-button disabled',
        	            'name' => 'Users[delete_actions]',
        	            'disabled' => 'disabled',
                        'style' => 'margin-top: -3px;'
        	        )) ?>
        		</div>
            </div>
        <?php endif; ?>
    </div>
    
    <table class="announcements">
    	<thead>
            <tr>
                <td class="photo" rel="1"><div>Фото</div></td>
                <td class="title" rel="2"><div>Заголовок</div></td>
                <td class="desc" rel="3"><div>Описание</div></td>
                <td class="status" rel="8"><div>Статус</div></td>
                <?php if ($model->user_id == Yii::app()->user->id): ?>
                <td class="check_all" rel="9">
	               <div>
                        
                            <span class="checkboxOff"><label>
                    		    <?php 
                                if ($model->user_id == Yii::app()->user->id)
                                    echo CHtml::checkBox('', false, array(
                                        'id'=>'checkbox',
                                        'class' => 'actions',
                                        'rel' => 'all',
                                        'style' => 'margin-top: 14px;'
                                    ));
                                ?>
        					</label></span>
                        
                    </div>
				</td>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
        
            <?php foreach($model->actions as $item): ?>
            
            <?php if ( !Yii::app()->user->checkAccess('moderator') AND Yii::app()->user->id != $model->user_id AND $item->status != Actions::STATUS_PUBLISHED ) continue; ?>
                        
            <tr id="action-<?=$item->id?>" class="<?=($item->status==Actions::STATUS_PUBLISHED) ? 'published' : ''?>">
                <td rel="1">
                    <div class="image">
                    <?= CHtml::image('/uploads/actions/mini_'.$item->img, '', array(
                        'width' => 100,
                        'height' => 80,
                    )) ?>
                    </div>
                </td>
                
                <td rel="2">
                    <?= CHtml::link(Functions::extractIntro($item->title, 50) , $this->createUrl('actions/view', array('id'=>$item->id))) ?>
                </td>
                
                <td rel="3">
                    <?= Functions::extractIntro($item->short_desc, 250) ?>
                </td>
                
                <td rel="8" class="status">
                <div style="position: relative;">
                    <?php
                        if ($item->status == Actions::STATUS_BLOCKED)
                            $out = 'Заблокировано';
                        else if ($item->status == Actions::STATUS_MODERATED)
                            $out = 'На рассмотрении у модератора';
                        else if ($item->status == Actions::STATUS_REMOVED)
                        {
                            $out = 'Удалено'
                                .CHtml::submitButton('Восстановить', array('name'=>'Users[public_actions]['. $item->id .']', 'class'=>'default-button', 'style'=>'display: block;'));
                        }
                        else
                        {
                            if (Functions::diffDate(time(), $item->actual_date) < 0)
                                $out = 'Время акции истекло.';
                            else
                                $out = "<strong>Актуально до ".Functions::getCalendarDay($item->actual_date, true)."</strong>";
                        }
                    ?>
                    <?= $out ?>
                </div>
                    
                </td>
                
                <?php if ($model->user_id == Yii::app()->user->id): ?>
                <td rel="9" class="check">
                    
                    	<div class="checkboxOff"><label>
    						<?php 
                            echo CHtml::checkBox('Users[check_actions]['. $item->id .']', false, array(
    	                        'id'=>'checkbox',
    	                        'class' => 'actions',
    	                        'rel' => $item->id,
    	                    ));
                            ?>
    				    </label></div>
                        <a href="<?=$this->createUrl('actions/update', array('id'=>$item->id))?>" class="profile_link" style="float: left; margin-top: 6px;"></a>
                </td>
                <?php endif; ?>
                
            </tr>
            
            <?php endforeach; ?>
            
        </tbody>
    </table>
   
<?php $this->endWidget(); ?>
<?php endif; ?>
<?php //endif; ?>




<?php
    $counter = 0;
    foreach ($model->auto as $auto)
    {
        if ($auto->auto_status == Auto::STATUS_PUBLISHED)
        {
            $counter++;
            break;
        }
    }
?>


<?php if ( ((Yii::app()->user->id == $model->user_id OR Yii::app()->user->checkAccess('moderator')) AND count($model->auto)!=0) OR 
    (Yii::app()->user->id != $model->user_id AND $counter > 0) ): ?>


<?php $this->beginWidget('CActiveForm', array('method'=>'POST')) ;?>
    
	<div class="text_row_title">Объявления (авто)
        <?php if ($model->user_id == Yii::app()->user->id): ?>
            <div id="actions_pannel">
            	<div class="button">
                    <div class="hor_loader"></div>
        			<?php echo CHtml::submitButton('Продлить', array(
                        'name' => 'Users[extend_auto]',
                        'rel' => Announcements::DATE_INTERVAL_ONE_WEEK,
                        'disabled' => 'disabled',
                        'class'=>'auto default-button disabled',
                        'style' => 'margin-top: -3px;'
                    )) ?>
                    <ul class="the_menu">
        			<li><a href="#" rel="<?=Announcements::DATE_INTERVAL_ONE_WEEK?>"><?php echo Lookup::model()->item(Lookup::DATE_INTERVAL, Announcements::DATE_INTERVAL_ONE_WEEK) ?></a></li>
        			<li><a href="#" rel="<?=Announcements::DATE_INTERVAL_TWO_WEEKS?>"><?php echo Lookup::model()->item(Lookup::DATE_INTERVAL, Announcements::DATE_INTERVAL_TWO_WEEKS) ?></a></li></a></li>
        			<li><a href="#" rel="<?=Announcements::DATE_INTERVAL_ONE_MONTH?>"><?php echo Lookup::model()->item(Lookup::DATE_INTERVAL, Announcements::DATE_INTERVAL_ONE_MONTH) ?></a></li></a></li>
        			</ul>
        		</div>
        		<div class="button">
        	        <?php echo CHtml::submitButton('Удалить', array(
        	            'name' => 'Users[delete_auto]',
        	            'disabled' => 'disabled',
                        'class'=>'auto default-button disabled',
                        'style' => 'margin-top: -3px;'
        	        )) ?>
        		</div>
            </div>
        <?php endif; ?>
    </div>      
    
	
    	
    
    <table class="announcements">
    	<thead>
            <tr>
                <td class="photo" rel="1"><div>Фото</div></td>
                <td class="title" rel="2"><div>Модель</div></td>
                <td class="cost" rel="5"><div>Стоимость</div></td>
                <td class="year" rel="6"><div>Год выпуска</div></td>
                <td class="run" rel="7"><div>Пробег</div></td>
                <td class="status" rel="8"><div>Статус</div></td>
                <?php if ($model->user_id == Yii::app()->user->id): ?>
                <td class="check_all" rel="9">
	               <div>
                        <span class="checkboxOff"><label>
                		    <?php 
                            if ($model->user_id == Yii::app()->user->id)
                                echo CHtml::checkBox('', false, array(
                                    'id'=>'checkbox',
                                    'class' => 'auto',
                                    'rel' => 'all',
                                    'style' => 'margin-top: 14px;'
                                ));
                            ?>
    					</label></span>
                    </div>
				</td>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($model->auto as $item): ?>
            
            <?php if ( !Yii::app()->user->checkAccess('moderator') AND Yii::app()->user->id != $model->user_id AND $item->auto_status != Auto::STATUS_PUBLISHED ) continue; ?>
            
            <tr class="<?=($item->auto_status==Auto::STATUS_PUBLISHED) ? 'published' : ''?>">
                <td rel="1">
                    <div class="image">
                    <?= CHtml::image(CHtml::encode(str_replace('original_','thumbs/mini_',$item->gall->original[0]->ph_url)), '', array(
                        'width' => 100,
                        'height' => 80,
                    )) ?>
                    </div>
                </td>
                <td rel="2">
                    <?= CHtml::link($item->automodel->modelbrend->b_name.', '.$item->automodel->m_name, $this->createUrl('auto/view', array('id'=>$item->auto_id, 'gorod'=>$model->city->translit))) ?>
                </td>
                <td rel="5">
                    <span class="text_price"><?= Functions::priceFormat($item->auto_price) ?></span><div class="cost_rub"></div>
                </td>
                <td rel="6">
                    <?= $item->auto_year ?>
                </td>
                <td rel="7">
                    <?= $item->auto_run ?>
                </td>
                <td rel="8" class="status">
                    <?php
                        if ($item->auto_status == Auto::STATUS_BLOCKED)
                            $out = 'Заблокировано';
                        else if ($item->auto_status == Auto::STATUS_MODERATED)
                            $out = 'На рассмотрении у модератора';
                        else if ($item->auto_status == Auto::STATUS_REMOVED)
                        {
                            $out = 'Удалено'
                                .CHtml::submitButton('Восстановить', array('name'=>'Users[public_auto]['. $item->auto_id .']', 'class'=>'default-button', 'style'=>'display: block;'));
                        }
                        else
                        {
                            $left_time = Functions::get_left_time($item->auto_actual_date, null);
                            if ($left_time===null)
                                $out = 'Заблокировано';
                            else
                                $out = "<strong>Актуально до ".Functions::getCalendarDay($item->auto_actual_date, true)."</strong>";
                        }
                    ?>
                    <?= $out ?>
                </td>
                <?php if ($model->user_id == Yii::app()->user->id): ?>
                <td rel="9" class="check auto">
                    
                    	<div class="checkboxOff"><label>
    						<?php 
                            echo CHtml::checkBox('Users[check_auto]['. $item->auto_id .']', false, array(
    	                        'id'=>'checkbox',
    	                        'class' => 'auto',
    	                        'rel' => $item->auto_id,
    	                    ));
                            ?>
    				    </label></div>
                        <a href="<?=$this->createUrl('auto/update', array('id'=>$item->auto_id))?>" class="profile_link" style="float: left; margin-top: 6px;"></a>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php $this->endWidget(); ?>
<?php endif; ?>




<?php
    $counter = 0;
    foreach ($model->announcements as $ann)
    {
        if ($ann->ann_status == Announcements::STATUS_PUBLISHED)
        {
            $counter++;
            break;
        }
    }
?>

<?php if ( ((Yii::app()->user->id == $model->user_id OR Yii::app()->user->checkAccess('moderator')) AND count($model->announcements)!=0) OR
    (Yii::app()->user->id != $model->user_id AND $counter > 0) ): ?>

<?php $this->beginWidget('CActiveForm') ;?>
    <div class="text_row_title">Объявления (запчасти)
        <?php if ($model->user_id == Yii::app()->user->id): ?>
            <div id="actions_pannel">
            	<div class="button">
        			<?php echo CHtml::submitButton('Продлить', array(
                        'name' => 'Users[extend_ann]',
                        'rel' => Announcements::DATE_INTERVAL_ONE_WEEK,
                        'disabled' => 'disabled',
                        'class'=>'ann default-button disabled',
                        'style' => 'margin-top: -3px;'
                    )) ?>
                    <ul class="the_menu">
        			<li><a href="#" rel="<?=Announcements::DATE_INTERVAL_ONE_WEEK?>"><?php echo Lookup::model()->item(Lookup::DATE_INTERVAL, Announcements::DATE_INTERVAL_ONE_WEEK) ?></a></li>
        			<li><a href="#" rel="<?=Announcements::DATE_INTERVAL_TWO_WEEKS?>"><?php echo Lookup::model()->item(Lookup::DATE_INTERVAL, Announcements::DATE_INTERVAL_TWO_WEEKS) ?></a></li></a></li>
        			<li><a href="#" rel="<?=Announcements::DATE_INTERVAL_ONE_MONTH?>"><?php echo Lookup::model()->item(Lookup::DATE_INTERVAL, Announcements::DATE_INTERVAL_ONE_MONTH) ?></a></li></a></li>
        			</ul>
        		</div>
        		<div class="button ann">
        	        <?php echo CHtml::submitButton('Удалить', array(
        	            'name' => 'Users[delete_ann]',
        	            'disabled' => 'disabled',
                        'class'=>'ann default-button disabled',
                        'style' => 'margin-top: -3px;'
        	        )) ?>
        		</div>
            </div>
        <?php endif; ?>
    </div>
    
    
    <div class="ann_products">
    
        <div class="products_head">
            <div class="cell-photo">
                Фото
            </div>
            <div class="cell-title">
                Заголовок
            </div>
            <div class="cell-category">
                Категория
            </div>
            <div class="cell-cost">
                Цена
            </div>
            <div class="cell-status">
                Статус
            </div>
            <div class="cell-check_all">
                <?php if ($model->user_id == Yii::app()->user->id): ?>
                    <div class="checkboxOff">
               			<label style="line-height: 0;">
            	        <?php echo CHtml::checkBox('check_all', false, array(
            	            'id'=>'checkbox',
                            'class' => 'ann',
                            'rel' => 'all',
            	        )); ?>
                    	</label>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="products_body">
        <?php foreach($model->announcements as $announce): ?>
        
            <?php if ( !Yii::app()->user->checkAccess('moderator') AND Yii::app()->user->id != $model->user_id AND $announce->ann_status != Announcements::STATUS_PUBLISHED ) continue; ?>
        
            <div class="products">
                <div class="cell-photo">
                    <div class="image">
                        <?php if (is_file($_SERVER['DOCUMENT_ROOT'].str_replace('original_','thumbs/mini_',$announce->gall->original[0]->ph_url)))
                            echo CHtml::image(CHtml::encode(str_replace('original_','thumbs/mini_',$announce->gall->original[0]->ph_url)), '', array(
                                'width' => 140,
                                'height' => 83,
                            ));
                        else
                            echo CHtml::image(Yii::app()->baseUrl.'/images/product_nofoto.jpg', '', array(
                                'width' => 140,
                                'height' => 83,
                            ));
                        ?>
                    </div>
                </div>
                    
                <div class="cell-title">
                    <?php echo CHtml::link(CHtml::encode($announce->ann_name), $this->createUrl('announcements/view', array('id' => $announce->ann_id, 'gorod'=>$model->city->translit))); ?>
                </div>
                
                <div class="cell-category">
                    <?php echo CHtml::encode($announce->cat->cat_name) ?>
                </div>
                
                <div class="cell-cost">
                    <span><?php echo CHtml::encode(Functions::priceFormat($announce->ann_price)); ?></span><div class="cost_rub"></div>
                </div>
                
                <div class="cell-status">
                    <div>
                    <?php
                        if ($announce->ann_status == Announcements::STATUS_BLOCKED)
                            $out = 'Заблокировано';
                        else if ($announce->ann_status == Announcements::STATUS_MODERATED)
                            $out = 'На рассмотрении у модератора';
                        else if ($announce->ann_status == Announcements::STATUS_REMOVED)
                        {
                            $out = 'Удалено'
                                .CHtml::submitButton('Восстановить', array('name'=>'Users[public_ann]['. $announce->ann_id .']', 'class'=>'default-button', 'style'=>'display: block;'));
                        }
                        else
                        {
                            $left_time = Functions::get_left_time($announce->ann_actual_date, null);
                            if ($left_time===null)
                                $out = 'Просрочено';
                            
                            else
                                $out = "<strong>Актуально до ".Functions::getCalendarDay($announce->ann_actual_date, true).'</strong>';
                        }
                    ?>
                    <?= $out ?>
                    </div>
                </div>
                
                <div class="cell-check">
                    <?php if ($model->user_id == Yii::app()->user->id): ?>
                        <div class="checkboxOff">
                   			<label>
                    	        <?php echo CHtml::checkBox('Users[check_ann]['. $announce->ann_id .']', false, array(
                    	            'id'=>'checkbox',
                                    'class' => 'ann',
                    	        )); ?>
                        	</label>
                        </div>
                        <a href="<?=$this->createUrl('announcements/update', array('id'=>$announce->ann_id))?>" class="profile_link" style="float: left; margin-top: 6px;"></a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
    
 <?php $this->endWidget(); ?>
 <?php endif; ?>
 
 
 <?=CHtml::activeHiddenField($model, 'user_id') ?>