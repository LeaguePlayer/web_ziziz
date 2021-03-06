<?php

class SliderPhotoController extends Controller
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
				'actions'=>array('manage','update',),
				'roles'=>array('moderator'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
	public function actionManage()
	{
	   
        if (Yii::app()->user->checkAccess('admin'))
            throw new CHttpException(404, 'У вас не достаточно прав.');
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SliderPhoto']))
		{
			$dir = '/uploads/slider/';
            $dirmini = '/uploads/slider/thumbs/';
            $photos = CUploadedFile::getInstancesByName('url');
            foreach($photos as $k => $ph)
			{
                $sourcePath = pathinfo($ph->getName());
                $filename = 'original_'.md5($sourcePath['basename'].time().date('y-m-d')).'.'.$sourcePath['extension'];
                
                if(!is_dir($_SERVER['DOCUMENT_ROOT'].$dir))
				{
                    mkdir($_SERVER['DOCUMENT_ROOT'].$dir);
                }
                if(!is_dir($_SERVER['DOCUMENT_ROOT'].$dirmini))
				{
                    mkdir($_SERVER['DOCUMENT_ROOT'].$dirmini);
                }

                //Ресайзим
                Yii::import("ext.EPhpThumb.EPhpThumb");
 
                $thumb = new EPhpThumb();
                $thumb->init();
                
                $file = $_SERVER['DOCUMENT_ROOT'].$dir.$filename;
                //сохраняем изображение
                $ph->saveAs($file);
                //$filebig = 'big_'.$filename;
                   				
                $slide = new SliderPhoto;
                $slide->url = $dir.$filename;
                $slide->status = 1;
                $slide->ann_id = 8;

				$slide->save();
                
                $filemini = str_replace('original_','mini_',$filename);
                $thumb->create($file)->adaptiveResize(75,75)->save($_SERVER['DOCUMENT_ROOT'].$dirmini.$filemini);
                $thumb->create($file)->adaptiveResize(907,275)->save($_SERVER['DOCUMENT_ROOT'].$dir.$filename);
            }
		}
        
        if (Yii::app()->request->isAjaxRequest)
        {
            if (isset($_POST['id_photo']) && is_numeric($_POST['id_photo']))
            {
                $del = SliderPhoto::model()->findByPk($_POST['id_photo']);
                if($del===null) Yii::app()->end();
                $mini = str_replace('original_','thumbs/mini_',$del->url);
                $big = str_replace('original_','thumbs/big_',$del->url);
                if (file_exists($_SERVER['DOCUMENT_ROOT'].$del->url))
                    unlink($_SERVER['DOCUMENT_ROOT'].$del->url); //Удаляем оригинал
                if (file_exists($_SERVER['DOCUMENT_ROOT'].$mini))
                    unlink($_SERVER['DOCUMENT_ROOT'].$mini); //Удаляем маленькую
                //if (file_exists($_SERVER['DOCUMENT_ROOT'].$big))
                //    unlink($_SERVER['DOCUMENT_ROOT'].$big); //Удаляем большую
                $del->delete(); //Чистим базу
            }
            Yii::app()->end();
        }

        $model = SliderPhoto::model()->findAll();
		$this->render('manage',array(
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

		if(isset($_POST['SliderPhoto']))
		{
			$model->attributes=$_POST['SliderPhoto'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$dataProvider=new CActiveDataProvider('SliderPhoto');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new SliderPhoto('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SliderPhoto']))
			$model->attributes=$_GET['SliderPhoto'];

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
		$model=SliderPhoto::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'Страница не найдена.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='slider-photo-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
