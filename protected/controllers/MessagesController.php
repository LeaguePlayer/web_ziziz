<?php

class MessagesController extends Controller
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
				'roles'=>array('user'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'roles'=>array('user'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'roles'=>array('user'),
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
        $model = $this->loadModel($id);
        if ($model->recipient->user_id !== Yii::app()->user->id)
            throw new CHttpException(404, "Вы можете просматривать только свои сообщения");
        
        if (!$model->viewed)
        {
            $model->viewed = 1;
            $model->save();
        }
            
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($type = null)
	{
        $session = Yii::app()->session;
        $session->open();
        // сохранение предыдущей страницы в первое обращение к контроллеру
        if (!isset($session['url_referrer'])) $session->add('url_referrer', Yii::app()->request->urlReferrer);
        
		if (isset($_POST['message_cancel']))
        {
            $url = $session['url_referrer'];
            $session->remove('url_referrer');
            $session->close();
            $this->redirect($url);
        }
            
        
        $model=new Messages;
        if ($type=='complain')
            $model->setScenario('to_admin');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Messages']))
		{
			$model->attributes=$_POST['Messages'];
            $user = Users::model()->findByPk(Yii::app()->user->id);
            if ($user===null)
                throw new CHttpException(404, "Не найден пользователь");
            
            if ($type=='complain')
            {
                $model->from = $user->user_id;
                $to = 0;
                $model->subject = "От пользователя ".$user->user_login." поступила жалоба";
            }
            if ($model->to == 0 || $user->email_notice == true)
                Functions::sendMail($model->subject, $model->text, $model->to, $user->user_email);
			if($model->save())
            {
                if (isset($session['url_referrer']))
                {
                    $url = $session['url_referrer'];
                    $session->remove('url_referrer');
                    $session->close();
                    $this->redirect($url);
                }
                else
                    $this->redirect(array('site/index'));
            }
		}
        
        $session->close();
        if (Yii::app()->request->isAjaxRequest)
        {
            $this->renderPartial('_form', array('model'=>$model));
            Yii::app()->end();
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

		if(isset($_POST['Messages']))
		{
			$model->attributes=$_POST['Messages'];
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
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index', '#'=>'messages_anker'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        if (isset($_POST['del_message']))
        {
            $model = Messages::model()->findByPk($_POST['del_message']);
            if ($model->recipient->user_id !== Yii::app()->user->id)
                throw new CHttpException(404, "Недостаточно прав для удаления сообщения");
            else
            {
                $model->delete();
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo true;
                    Yii::app()->end();
                }
            }
        }

        if (isset($_POST['mark_message']))
        {
            $model = Messages::model()->findByPk($_POST['mark_message']);
            if ($model->recipient->user_id !== Yii::app()->user->id)
                throw new CHttpException(404, "Недостаточно прав для удаления сообщения");
            else
            {
                $model->viewed = 1;
                $model->save(false);
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo $this->renderPartial('_view', array('data'=>$model));
                    Yii::app()->end();
                }
            }
        }
       
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.to='.Yii::app()->user->id);
        $criteria->with = array(
            'sender'=>array(
                'select'=>'user_login',
            ),
            'recipient'=>array(
                'select'=>'user_login',
            ),
        );
        $criteria->order = 'send_date DESC';
		$dataProvider=new CActiveDataProvider('Messages', array(
            'criteria'=>$criteria,
            'pagination'=>array(
            	'pageSize'=>20,
           	),
        ));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Messages('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Messages']))
			$model->attributes=$_GET['Messages'];

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
		$model=Messages::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='messages-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
