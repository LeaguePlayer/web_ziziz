<?php
/**
 * CMultiFileUpload class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CMultiFileUpload generates a file input that can allow uploading multiple files at a time.
 *
 * This is based on the {@link http://www.fyneworks.com/jquery/multiple-file-upload/ jQuery Multi File Upload plugin}.
 * The uploaded file information can be accessed via $_FILES[widget-name], which gives an array of the uploaded
 * files. Note, you have to set the enclosing form's 'enctype' attribute to be 'multipart/form-data'.
 *
 * Example:
 * <pre>
 * <?php
 *   $this->widget('CMultiFileUpload', array(
 *      'model'=>$model,
 *      'attribute'=>'files',
 *      'accept'=>'jpg|gif',
 *      'options'=>array(
 *         'onFileSelect'=>'function(e, v, m){ alert("onFileSelect - "+v) }',
 *         'afterFileSelect'=>'function(e, v, m){ alert("afterFileSelect - "+v) }',
 *         'onFileAppend'=>'function(e, v, m){ alert("onFileAppend - "+v) }',
 *         'afterFileAppend'=>'function(e, v, m){ alert("afterFileAppend - "+v) }',
 *         'onFileRemove'=>'function(e, v, m){ alert("onFileRemove - "+v) }',
 *         'afterFileRemove'=>'function(e, v, m){ alert("afterFileRemove - "+v) }',
 *      ),
 *   ));
 * ?>
 * </pre>
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Id: CMultiFileUpload.php 3515 2011-12-28 12:29:24Z mdomba $
 * @package system.web.widgets
 * @since 1.0
 */
class CMultiFileUploadEx extends CMultiFileUpload
{   
    /**
	 * Runs the widget.
	 * This method registers all needed client scripts and renders
	 * the multiple file uploader.
	 */
	public function run()
	{
		list($name,$id)=$this->resolveNameID();
		if(substr($name,-2)!=='[]')
			$name.='[]';
		if(isset($this->htmlOptions['id']))
			$id=$this->htmlOptions['id'];
		else
			$this->htmlOptions['id']=$id;
        //$this->htmlOptions['hidden']='hidden';
        //if (!isset($this->htmlOptions['multiple']) || $this->htmlOptions['multiple']=='false')
        //    $this->htmlOptions['multiple'] = 'true';
		$this->registerClientScript();
		echo CHtml::fileField($name,'',$this->htmlOptions);
	}
    
    /**
	 * Registers the needed CSS and JavaScript.
	 */
	public function registerClientScript()
	{
		$id=$this->htmlOptions['id'];

		$options=$this->getClientOptions();
		$options=$options===array()? '' : CJavaScript::encode($options);
		$cs=Yii::app()->getClientScript();
		$cs->registerCoreScript('multifile');
		$cs->registerScript('Yii.CMultiFileUpload#'.$id,"jQuery(\"#{$id}\").MultiFile({$options});");
        $cs->registerScript('addScinFileInput',"jQuery(\"#{$id}\").after(\"<div class='select_file'></div>\")");
        
	}
}
