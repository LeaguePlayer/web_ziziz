<?php

class ProposalController extends Controller
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
				'actions'=>array('index','view','delete'),
				'roles'=>array('root'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create', 'send_ok'),
				'roles'=>array('guest'),
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
	public function actionCreate($type)
	{
        $user = Users::model()->findByPk(Yii::app()->user->id);
        
//        if ($type == Proposal::TYPE_SEARCH_SERVICES && $user->user_type != Users::USERTYPE_JUR_PERSON)
//        {
//            if (Yii::app()->request->isAjaxRequest)
//                $this->renderPartial('message', array('message_title'=>'Ошибка', 'message'=>'Только юридические лица могут пользоваться данной услугой'));
//            else
//                $this->render('message', array('message_title'=>'Ошибка', 'message'=>'Только юридические лица могут пользоваться данной услугой'));
//                
//            Yii::app()->end();
//        }
        
		$model=new Proposal;
        $model->type = $type;
        if ($user)
        {
            $model->user_id = $user->user_id;
            $model->user_phone = $user->user_phone;
            $model->user_email = $user->user_email;
        }
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        
		if(isset($_POST['Proposal']))
		{
			$model->attributes=$_POST['Proposal'];
			if($model->save())
            {
                $subject = 'Уведомление о заявке с сервиса ZIZIZ';
                if ($user)
                {
                    $userfio = (!empty($user->fio)) ? $user->fio : $user->user_login;
                }
                else
                {
                    $email_pieces = explode('@', $model->user_email);
                    $userfio = $email_pieces[0];
                }
                
                $session = Yii::app()->session;
                $session->open();
                $city_id = (!empty($session['cur_city_id'])) ? $session['cur_city_id'] : false;
        
                if (!$city_id)
                {
                    if ($user===null)
                        $city_id = Yii::app()->params['def_city_id'];
                    else
             			$city_id = (!empty($user->user_city_id)) ? $user->user_city_id : Yii::app()->params['def_city_id'];
                }
                $session->close();
                
                $jur_persons = Users::model()->with('company')->findAll('user_type=:u_type AND NOT(user_id=:u_id) AND user_city_id=:city_id', array(
                    ':u_type'=>Users::USERTYPE_JUR_PERSON,
                    ':u_id'=>Yii::app()->user->id,
                    ':city_id'=>$city_id,
                ));
                
                if ($type == Proposal::TYPE_SEARCH_SPAREPART)
                {
                    foreach ($jur_persons as $person)
                    {
                        $others = "Модель - {$model->brend->b_name};<br/>".
                            "Модель - {$model->brend->b_name};<br/>".
                            "VIN - {$model->VIN};<br/>".
                            "Тип кузова - {$model->carcass_type};<br/>".
                            "Номер кузова - {$model->carcass_number};<br/>";
                        $text = $this->textByProposalSparepart($person->user_fio, $model->description, $model->user_phone, $model->user_email, $others);
                        if ($person->email_notice==0 ||
                            ($person->email_notice==1 && Functions::sendMail($subject, $text, $person->user_email, Yii::app()->params['norepeat_email'])))
                        {
                            $message = new Messages;
                            $message->from = Yii::app()->user->id;
                            $message->to = $person->user_id;
                            $message->subject = $subject;
                            $message->text = $text;
                            $message->save();
                        }
                    }
                }
                else
                {
                    foreach ($jur_persons as $person)
                    {
                        $others = "Модель - {$model->brend->b_name};<br/>".
                            "Модель - {$model->brend->b_name};<br/>".
                            "VIN - {$model->VIN};<br/>".
                            "Тип кузова - {$model->carcass_type};<br/>".
                            "Номер кузова - {$model->carcass_number};<br/>".
                            "Коробка - {$model->box};<br/>".
                            "Тип топлива - {$model->fuel};";
                        
                        if ($person->company->company_type != $model->targetcompany_type) continue;
                        
                        $text = $this->textByProposalServices($person->user_fio, $model->description, $model->user_phone, $model->user_email, $others);
                        
                        if  ($person->email_notice==0 || 
                            ($person->email_notice==1 && Functions::sendMail($subject, $text, $person->user_email, Yii::app()->params['norepeat_email'])))
                        {
                            $message = new Messages;
                            $message->from = Yii::app()->user->id;
                            $message->to = $person->user_id;
                            $message->subject = $subject;
                            $message->text = $text;
                            $message->save();
                        };
                    }
                }
                $this->redirect(array('send_ok'));
			}
		}
        
        if (Yii::app()->request->isAjaxRequest)
        {
            $this->renderPartial('_form',array(
    			'model'=>$model,
                'user' => $user,
    		), false, true);
            Yii::app()->end();
        }
        
		$this->render('create',array(
			'model'=>$model,
            'user' => $user,
		));
	}
    
    public function actionSend_ok()
    {
        $this->render('send_ok');
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

		if(isset($_POST['Proposal']))
		{
			$model->attributes=$_POST['Proposal'];
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
		$dataProvider=new CActiveDataProvider('Proposal');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Proposal('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Proposal']))
			$model->attributes=$_GET['Proposal'];

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
		$model=Proposal::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='proposal-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    private function textByProposalSparepart($jurname, $description, $userphone, $useremail, $others = "")
    {
        return
"Здравствуйте, <strong>$jurname</strong>.<br />
Мы благодарим Вас, что Вы воспользовались нашим бесплатным сервисом \"ZIZIZ.ru\". Мы стараемся сделать сервис максимально полезным для Наших пользователей, наша основная цель, организовать удобную базу объявлений<br />
Пользователь сайта ZIZIZ.ru сделал запрос на поиск запчасти.
Он ищет запчасть:<br />". $description ."<br/>".
"Дополниельные характеристики: {$others}<br/>".
"Вы можете связаться с ним:<br />".
($useremail) ? "По электронной почте $useremail<br />" : "".
"По телефону $userphone<br />
Если у Вас возникнут какие-либо вопросы по нашему сервису, Вы можете задать их нашей " . CHtml::link('службе поддержки', 'mailto:'.Yii::app()->params['support_email']) . ". Это письмо было сгенерировано автоматически, и мы просим не отвечать на него!<br />
Искренне Ваш, " . CHtml::link('ZIZIZ.ru', $this->createUrl('site/index'));
    }
    
    private function textByProposalServices($jurname, $description, $userphone, $useremail, $others = "")
    {
        return
"Здравствуйте, <strong>$jurname</strong>.<br />
Мы благодарим Вас, что Вы воспользовались нашим бесплатным сервисом \"ZIZIZ.ru\". Мы стараемся сделать сервис максимально полезным для Наших пользователей, наша основная цель, организовать удобную базу объявлений<br />
Пользователь сайта ZIZIZ.ru сделал запрос на поиск услуги.
Он ищет услугу:<br />". $description ."<br/>".
"Дополниельные характеристики: {$others}<br/>".
"Вы можете связаться с ним:<br />".
($useremail) ? "По электронной почте $useremail<br />" : "".
"По телефону $userphone<br />
Если у Вас возникнут какие-либо вопросы по нашему сервису, Вы можете задать их нашей " . CHtml::link('службе поддержки', 'mailto:'.Yii::app()->params['support_email']) . ". Это письмо было сгенерировано автоматически, и мы просим не отвечать на него!<br />
Искренне Ваш, " . CHtml::link('ZIZIZ.ru', $this->createUrl('site/index'));
    }
}
