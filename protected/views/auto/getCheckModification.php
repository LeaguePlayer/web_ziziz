<?php
    $info = Modification::getInfoArray();
?>

<table id="modifications" cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo CHtml::label('Кузов', false); ?></th>
        <th><?php echo CHtml::label('Топливо', false); ?></th>
        <th><?php echo CHtml::label('Руль', false); ?></th>
    </tr>
    
    <tr>
        <td>
            <div class="drop_list unexpand">
                <div class="drop_button"></div>
            	<?php $listdata = $info['kuzov']; ?>
                <?php
                    $seleketed_key = (empty($model->mod_carcass)) ? 0 : $model->mod_carcass;
                ?>
            	<span class="selected_value"><?=$listdata[$seleketed_key]?></span>
            	<?php echo CHtml::activeDropDownList($model,'mod_carcass',$listdata, array(
                    'name'=>'Auto[auto_carcass]',
                    'class'=>'checkable',
                ));?>
            	<div class="select_options">
            		<?php
            		foreach($listdata as $key => $item)
            		{
            		    $selected = ($key==$seleketed_key) ? ' selected' : '';
            			echo CHtml::openTag('div', array('class'=>'select_option'.$selected, 'value'=>$key));
            			echo $item;
            			echo CHtml::closeTag('div');
            		}
            		?>
            	</div>
            </div>
        </td>
        
        <td>
            <div class="drop_list unexpand">
                <div class="drop_button"></div>
            	<?php $listdata = $info['fuel']; ?>
                <?php
                    $seleketed_key = (empty($model->mod_fuel)) ? 0 : $model->mod_fuel;
                ?>
            	<span class="selected_value"><?=$listdata[$seleketed_key]?></span>
            	<?php echo CHtml::activeDropDownList($model,'mod_fuel',$info['fuel'], array(
                    'name'=>'Auto[auto_fuel]',
                    'class'=>'checkable',
                ));?>
            	<div class="select_options">
            		<?php
            		foreach($listdata as $key => $item)
            		{
            		    $selected = ($key==$seleketed_key) ? ' selected' : '';
            			echo CHtml::openTag('div', array('class'=>'select_option'.$selected, 'value'=>$key));
            			echo $item;
            			echo CHtml::closeTag('div');
            		}
            		?>
            	</div>
            </div>
        </td>
        
        <td>
            <div class="drop_list unexpand">
                <div class="drop_button"></div>
            	<?php $listdata = $info['control']; ?>
                <?php
                    $seleketed_key = (empty($model->mod_control)) ? 0 : $model->mod_control;
                ?>
            	<span class="selected_value"><?=$listdata[$seleketed_key]?></span>
            	<?php echo CHtml::activeDropDownList($model,'mod_control',$info['control'], array(
                    'name'=>'Auto[auto_control]',
                    'class'=>'checkable',
                ));?>
            	<div class="select_options">
            		<?php
            		foreach($listdata as $key => $item)
            		{
            		    $selected = ($key==$seleketed_key) ? ' selected' : '';
            			echo CHtml::openTag('div', array('class'=>'select_option'.$selected, 'value'=>$key));
            			echo $item;
            			echo CHtml::closeTag('div');
            		}
            		?>
            	</div>
            </div>
        </td>
    </tr>
    
    <tr>
        <th><?php echo CHtml::label('КПП', false); ?></th>
        <th><?php echo CHtml::label('Привод', false); ?></th>
    </tr>
    
    <tr>
        <td>
            <div class="drop_list unexpand">
                <div class="drop_button"></div>
            	<?php $listdata = $info['kpp']; ?>
                <?php
                    $seleketed_key = (empty($model->mod_box)) ? 0 : $model->mod_box;
                ?>
            	<span class="selected_value"><?=$listdata[$seleketed_key]?></span>
            	<?php echo CHtml::activeDropDownList($model,'mod_box',$info['kpp'], array(
                    'name'=>'Auto[auto_box]',
                    'class'=>'checkable',
                ));?>
            	<div class="select_options">
            		<?php
            		foreach($listdata as $key => $item)
            		{
            		    $selected = ($key==$seleketed_key) ? ' selected' : '';
            			echo CHtml::openTag('div', array('class'=>'select_option'.$selected, 'value'=>$key));
            			echo $item;
            			echo CHtml::closeTag('div');
            		}
            		?>
            	</div>
            </div>
        </td>
        
        <td>
            <div class="drop_list unexpand">
                <div class="drop_button"></div>
            	<?php $listdata = $info['drive']; ?>
                <?php
                    $seleketed_key = (empty($model->mod_drive)) ? 0 : $model->mod_drive;
                ?>
            	<span class="selected_value"><?=$listdata[$seleketed_key]?></span>
            	<?php echo CHtml::activeDropDownList($model,'mod_drive',$info['drive'], array(
                    'name'=>'Auto[auto_drive]',
                    'class'=>'checkable',
                ));?>
            	<div class="select_options">
            		<?php
            		foreach($listdata as $key => $item)
            		{
            		    $selected = ($key==$seleketed_key) ? ' selected' : '';
            			echo CHtml::openTag('div', array('class'=>'select_option'.$selected, 'value'=>$key));
            			echo $item;
            			echo CHtml::closeTag('div');
            		}
            		?>
            	</div>
            </div>
        </td>
    </tr>
    
    <tr>
        <th><?php echo CHtml::label('Объем', false); ?></th>
        <th><label class="required">Год выпуска<span class="required"> *</span></label></th>
    </tr>
    
    <tr>
        <td><?php echo CHtml::activeTextField($model,'mod_vol', array(
            'size'=>4,
            'name'=>'Auto[auto_vol]',
        )); ?>
        </td>
        
        <td><?php echo CHtml::activeTextField($model,'mod_year', array(
            'size'=>4,
            'name'=>'Auto[auto_year]',
        )); ?>
        
        </td>
    </tr>
</table>