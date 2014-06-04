<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
    
    public function init()
    {
        parent::init();
        date_default_timezone_set("Asia/Dhaka");
        Yii::app()->getClientScript()->registerCoreScript('jquery');
        
    }
    
    protected function beforeAction($action)
    {
        if (($action->getController()->route == 'site/index'))
            Yii::app()->clientScript->registerScriptFile("http://api-maps.yandex.ru/2.0-stable/?cordorder=longlat&load=package.full&lang=ru-RU");
            
        $session = Yii::app()->session;
        $session->open();
        //$session->remove('cur_city');
        //$session->remove('cur_city_id');
        //print_r($session['cur_city']);print_r($session['cur_city_id']);die();

        if (empty($session['cur_city']) || empty($session['cur_city_id'])) {

            if ($action->getController()->route != 'site/index')
                Yii::app()->clientScript->registerScriptFile("http://api-maps.yandex.ru/2.0-stable/?load=package.map&lang=ru-RU");
                
            Yii::app()->clientScript->registerScriptFile("/js/citylocation.js");
        }
        
        //$session->close();
        return parent::beforeAction($action);
    }
}