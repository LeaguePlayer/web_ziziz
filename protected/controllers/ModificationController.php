<?php

class ModificationController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'getModels'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
    
    public function actionGetModels(){
        if(Yii::app()->request->isAjaxRequest){
            if(!empty($_POST['Brend'])){
                $data=Carmodel::model()->findAll('m_brend_id=:b_id', array(':b_id'=>(int) $_POST['Brend']['b_id']));
                $data=CHtml::listData($data,'m_id','m_name');
                foreach($data as $value=>$name)
                {
                    echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                }
                
            }
        }
    }

    public function getInfoArray(){
        
        return  array(
            'kuzov' => array(
                0 => 'Не указано',
                1 => 'Седан', 
                2 => 'Хэтчбек',
                3 => 'Универсал'
            ),
            'control' => array(
                0 => 'Не указано',
                1 => 'Левый', 
                2 => 'Правый'
            ),
            'fuel' => array(
                0 => 'Не указано',
                1 => 'Бензин', 
                2 => 'Дизель'
            ),
            'kpp' => array(
                0 => 'Не указано',
                1 => 'Механика', 
                2 => 'Автомат'
            ),
            'drive' => array(
                0 => 'Не указано',
                1 => 'Передний', 
                2 => 'Задний',
                3 => '4WD'
            )
        );
    }
    
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Modification;
        $brends = new Brend;
        $mods = array();
        $flag = true;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        if(isset($_POST['Brend'])){
            
            $brends->attributes = $_POST['Brend'];
            //$brends->b_id = $_POST['Brend']['b_id'];
        }
        
		if(isset($_POST['Modification']))
		{
            foreach($_POST['Modification'] as $m){
                $temp = new Modification;
                $temp->attributes = $m;
                $flag = $flag && $temp->validate();
                if(!$flag) 
                    break;
                $mods[] = $temp;
            }
            if($flag){
                foreach($mods as $mod){
                    $mod->save(false);
                }
                $this->redirect(array('index'));
            }
		}
        //костыль на автоматическое обновление селекта
        Yii::app()->clientScript->registerScript('updateSelect','$(function(){$("#Brend_b_id").change();});');
        Yii::app()->getClientScript()->registerCoreScript('jquery');
        
		$this->render('create',array(
			'model'=>$model,
            'brends'=>$brends
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Modification']))
		{
			$model->attributes=$_POST['Modification'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->mod_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Modification');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Modification('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Modification']))
			$model->attributes=$_GET['Modification'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Modification::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='modification-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
