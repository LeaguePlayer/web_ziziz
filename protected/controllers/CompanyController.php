<?php

class CompanyController extends Controller
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
				'actions'=>array('index','view', 'GetCompanies'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Company;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Company']))
		{
			$model->attributes=$_POST['Company'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->company_id));
		}

		$this->render('create',array(
			'model'=>$model,
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

		if(isset($_POST['Company']))
		{
			$model->attributes=$_POST['Company'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->company_id));
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
		$dataProvider=new CActiveDataProvider('Company');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Company('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Company']))
			$model->attributes=$_GET['Company'];

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
		$model=Company::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='company-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    public function getCoordsFromYMap($geocode, $results = 1, $fullresponse = false)
    {
        $params = array(
        		'geocode' => $geocode, 	// текст запроса
        		'format'  => 'json',    // формат ответа
        		'results' => $results,  // количество выводимых результатов
    			'lang'    => 'ru',
                //'ll'      => '1.111, 1.111',            // задаёт долготу и широту центра области поиска(в градусах)
                //'spn'     => '0.555, 0.555',            // область поиска (в градусах)
                //'rspn'    => '0',           // ограничить ли поиск объектов областью, заданной с помощью параметров ll и spn
		);
        $response = json_decode(file_get_contents('http://geocode-maps.yandex.ru/1.x/?'.http_build_query($params, '', '&')));
        $counts = $response->response->GeoObjectCollection->metaDataProperty->GeocoderResponseMetaData->found;
        //echo "<pre>";
        //print_r($response);
		if ($counts > 0)
        {
            if ($fullresponse) return $response;
            $pos = $response->response->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos;
            preg_match_all("/\d+\.\d+/", $pos, $coords);
            return $coords[0];
        }
        return null;
    }
    
    public function actionGetCompanies($type = null)
    {
        $session = Yii::app()->session;
        $session->open();
        $city_id = $session['cur_city_id'];
        $city_name = $session['cur_city'];
        $session->close();
        
        $companies = Company::model()->with(array(
            'user' => array(
                'select'=>'user_city_id',
            ),
        ))->findAll( 'user.user_city_id=:city_id AND t.show_on_map=1', array(':city_id'=>$city_id) );
        
        
        $counter = 0;
        if (count($companies)>0)
        {
            foreach ($companies as $company)
            {
                if (empty($company->company_ymap_pos1) || empty($company->company_ymap_pos2))
                {
                	$coords = $this->getCoordsFromYMap($city_name.', '.$company->company_address);
                	if ($coords===null) continue;
                    $ret[$counter]['coords'] = $coords;
                    $company->company_ymap_pos1 = $ret[$counter]['coords'][0];
                    $company->company_ymap_pos2 = $ret[$counter]['coords'][1];
                    $company->save();
                }
                else
                {
                    $ret[$counter]['coords'][0] = $company->company_ymap_pos1;
                    $ret[$counter]['coords'][1] = $company->company_ymap_pos2;
                }
                $ret[$counter]['id'] = $company->company_id;
                $ret[$counter]['name'] = $company->company_name;
                $ret[$counter]['address'] = $company->company_address;
                $ret[$counter]['type'] = $company->company_type;
                $ret[$counter]['description'] = $company->description;
                $counter++;
            }
            echo json_encode($ret);
        }
        else
            echo null;
    }
}
