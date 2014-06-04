<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'modification-form',
	'enableAjaxValidation'=>false,
)); ?>
    <?
        $info = $this->getInfoArray();
        //print_r($info);
    ?>
	<p class="note">Поля, отмеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>
    <div class="row">
        <?php echo $form->labelEx($brends,'b_name'); ?>
        <?php 
        echo CHtml::activeDropDownList($brends,'b_id', CHtml::ListData(Brend::model()->findAll(array('order'=>'b_name')),'b_id','b_name'),
            array(
                'ajax' => array(
                    'type'=>'POST', //request type
                    'url'=>$this->createUrl('modification/getModels'), //url to call.
                    //Style: CController::createUrl('currentController/methodToCall')
                    'update'=>'.model', //selector to update
                    //'data'=>'js:javascript statement' 
                    //leave out the data key to pass all form values through
                )
            )
        ); 
        ?>
    </div>
    
    <div class="row">
        
        
    </div>
    <?//-----------------------------------------------------------------------------------------?>
    <div>
        <a href="#add" onclick="addMod();">[+]</a>
    </div>
    <br />
    <table id="modifications" width="100%" cellpadding="0" cellspacing="0" style="border: 1px dashed #aaa;">
        <tr>
            <th><?php echo $form->label($model,'mod_name'); ?></th>
            <th><?php echo $form->labelEx($model,'mod_carcass'); ?></th>
            <th><?php echo $form->labelEx($model,'mod_fuel'); ?></th>
            <th><?php echo $form->labelEx($model,'mod_control'); ?></th>
            <th><?php echo $form->labelEx($model,'mod_box'); ?></th>
            <th><?php echo $form->labelEx($model,'mod_drive'); ?></th>
            <th><?php echo $form->labelEx($model,'mod_vol'); ?></th>
            <th><?php echo $form->labelEx($model,'mod_year'); ?></th>
            <th><?php echo $form->labelEx($model,'mod_model_id'); ?></th>
        </tr>
        <tr class="item-mod">
            <td><?php echo $form->textField($model,'[0]mod_name'); ?></td>
            <td><?php echo $form->dropDownList($model,'[0]mod_carcass',$info['kuzov']);?></td>
            <td><?php echo $form->dropDownList($model,'[0]mod_fuel',$info['fuel']);?></td>
            <td><?php echo $form->dropDownList($model,'[0]mod_control',$info['control']);?></td>
            <td><?php echo $form->dropDownList($model,'[0]mod_box',$info['kpp']);?></td>
            <td><?php echo $form->dropDownList($model,'[0]mod_drive',$info['drive']);?></td>
            <td><?php echo $form->textField($model,'[0]mod_vol', array('size'=>4, 'class'=>'reset')); ?></td>
            <td><?php echo $form->textField($model,'[0]mod_year', array('size'=>4, 'class'=>'reset')); ?></td>
            <td><?php echo $form->dropDownList($model, '[0]mod_model_id',array(),array('class'=>'model'));?></td>
        </tr>
    </table>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
    var index = 1;
    function addMod(){
        var mod = jQuery('.item-mod:first').clone();
        mod.find('input, select').each(function(){
            var name = jQuery(this).attr('name');
            jQuery(this).attr('name',name.replace('0',index));
        });
        index++;
        console.log(mod);
        jQuery('#modifications').append(mod);
    }
</script>