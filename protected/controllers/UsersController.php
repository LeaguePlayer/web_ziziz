<?php

class UsersController extends Controller
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
				'actions'=>array('login','logout'),
				'roles'=>array('guest'),
            ),
            array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('registration', 'registration_ok', 'send', 'recall', 'recovery'),
				'roles'=>array('guest'),
			),
            array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view'),
				'roles'=>array('guest'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update', 'updatePass', 'updateAvatar'),
				'roles'=>array('user'),
			),
//			array('allow', // allow admin user to perform 'admin' and 'delete' actions
//				'actions'=>array('admin','delete','index'),
//				'roles'=>array('root'),
//			),
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
        $anker = '';
        // если пользователь зашел в свой личный кабинет
        if ($id == Yii::app()->user->id)
        {
            // акции
            if (isset($_POST['Users']['delete_actions']) && isset($_POST['Users']['check_actions']))
            {
                $criteria = new CDbCriteria;
                $criteria->addInCondition('id', array_keys($_POST['Users']['check_actions']));
                $models = Actions::model()->findAll($criteria);
                foreach ($models as $act)
                {
                    $act->status = Actions::STATUS_REMOVED;
                    $act->remove_date = date('Y-m-d H:i');
                    $act->save(false);
                    $anker = 'action-'.$act->id;
                }
            }
            
            if (isset($_POST['Users']['public_actions']))
            {
                $act = Actions::model()->findByPk(key($_POST['Users']['public_actions']));
                if ($act->status != Actions::STATUS_PUBLISHED)
                {
                    $act->status = Actions::STATUS_MODERATED;
                    $act->save(false);
                }
            }
            
            // авто
            if (isset($_POST['Users']['delete_auto']))
            {
                $criteria = new CDbCriteria;
                $criteria->addInCondition('auto_id', array_keys($_POST['Users']['check_auto']));
                $models = Auto::model()->findAll($criteria);
                foreach ($models as $auto)
                {
                    $auto->auto_status = Auto::STATUS_REMOVED;
                    $auto->save(false);
                }
            }
            
            if (isset($_POST['Users']['extend_auto']))
            {
                $criteria = new CDbCriteria;
                $criteria->addInCondition('auto_id', array_keys($_POST['Users']['check_auto']));
                $models = Auto::model()->findAll($criteria);
                foreach ($models as $auto)
                {
                    $auto->auto_actual_date = date('Y-m-d H:i:s', strtotime('+1 week', time()));
                    $auto->save(false);
                }
            }
            
            if (isset($_POST['Users']['public_auto']))
            {
                $auto = Auto::model()->findByPk(key($_POST['Users']['public_auto']));
                if ($auto->auto_status != Auto::STATUS_PUBLISHED)
                {
                    $auto->auto_status = Auto::STATUS_MODERATED;
                    $auto->save(false);
                }
            }
            
            //запчасти
            if (isset($_POST['Users']['delete_ann']))
            {
                $criteria = new CDbCriteria;
                $criteria->addInCondition('ann_id', array_keys($_POST['Users']['check_ann']));
                $models = Announcements::model()->findAll($criteria);
                foreach ($models as $ann)
                {
                    $ann->ann_status = Announcements::STATUS_REMOVED;
                    $ann->save(false);
                }
            }
            
            if (isset($_POST['Users']['extend_ann']))
            {
                $criteria = new CDbCriteria;
                $criteria->addInCondition('ann_id', array_keys($_POST['Users']['check_ann']));
                $models = Announcements::model()->findAll($criteria);
                
                foreach ($models as $ann)
                {
                    $ann->ann_actual_date = date('Y-m-d H:i:s', strtotime('+1 week', time()));
                    $ann->save(false);
                }
            }
            
            if (isset($_POST['Users']['public_ann']))
            {
                $ann = Announcements::model()->findByPk(key($_POST['Users']['public_ann']));
                if ($ann->ann_status != Announcements::STATUS_PUBLISHED)
                {
                    $ann->ann_status = Announcements::STATUS_MODERATED;
                    $ann->save(false);
                }
            }
            
            if (isset($_POST['Users']['extend']) && isset($_POST['Users']['checked']))
            {
                switch ($_POST['Users']['interval_code']){
                    default:
                        $interval = '+1 week';
                        break;
                    case 2:
                        $interval = '+2 week';
                        break;
                    case 3:
                        $interval = '+1 month';
                        break;
                }
                
                $criteria = new CDbCriteria;
                switch ($_POST['Users']['extend']){
                    case 'auto':
                        $criteria->addInCondition('auto_id', array_keys($_POST['Users']['checked']));
                        $models = Auto::model()->findAll($criteria);
                        foreach ($models as $ann)
                        {
                            $ann->auto_actual_date = date('Y-m-d H:i:s', strtotime($interval, time()));
                            $ann->save(false);
                        }
                        break;
                    case 'ann':
                        $criteria->addInCondition('ann_id', array_keys($_POST['Users']['checked']));
                        $models = Announcements::model()->findAll($criteria);
                        
                        foreach ($models as $ann)
                        {
                            $ann->ann_actual_date = date('Y-m-d H:i:s', strtotime($interval, time()));
                            $ann->save(false);
                        }
                        break;
                }  
            }
        }
        
        
        
        $model = Users::model()->with(array(
            'actions',
            'auto',
            'auto.automodel',
            'auto.automodel.modelbrend',
            'announcements',
            'company',
        ))->findByPk($id);
        
        if ($model===null)
            throw new CHttpException(404, 'Не найден пользователь');
            
        if (Yii::app()->request->isAjaxRequest) {
            echo $this->renderPartial('_announce_list_in_profile', array(
                'model' => $model,
            ));
            Yii::app()->end();
        }
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Users;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
			if($model->save()){
//                $message = new Messages;
//                $message->from = 0;
//                $message->to = $model->user_id;
                $this->redirect(array('view','id'=>$model->user_id));
			}
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
        if ($id != Yii::app()->user->id)
            throw new CHttpException(403, "У Вас недостаточно прав для выполнения указанного действия");
            
		$model=$this->loadModel($id);
        $model->setScenario('update');
        $citys = Citys::model()->findAll(array(
            'order'=>'city_name',
        ));
        
        if ($model->user_type == Users::USERTYPE_JUR_PERSON)
        {
            $company = Company::model()->find('company_user_id=:u_id', array(':u_id'=>$model->user_id));
            $old_address = $company->company_address;
        }
        
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        $success = false;
		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
			if($model->save())
                $success = true;
		}
        
        if (isset($_POST['Company']))
        {
            $company->attributes = $_POST['Company'];
            if ($company->company_address != $old_address)
            {
                $company->company_ymap_pos1 = '';
                $company->company_ymap_pos2 = '';
            }
            if(!$company->save())
                $success = false;
        }
        if ($success)
            $this->redirect(array('view','id'=>$model->user_id));

		$this->render('update',array(
			'model'=>$model,
            'citys'=>$citys,
            'company'=>$company
		));
	}
    
    public function actionUpdatePass($id)
    {
        
        if ($id != Yii::app()->user->id)
            throw new CHttpException(403, "У Вас недостаточно прав для выполнения указанного действия");
        
        $session = Yii::app()->session;
        $session->open();
        // сохранение предыдущей страницы в первое обращение к контроллеру
        if (!isset($session['url_referrer'])) $session->add('url_referrer', Yii::app()->request->urlReferrer);
        
        $model=new UserPass;

        if (isset($_POST['UserPass']))
        {
            $model->attributes = $_POST['UserPass'];
            if ($model->validate())
            {
                $user = Users::model()->findByPk(Yii::app()->user->id);
                if ($user === null)
                    throw new CHttpException(403, 'Не найден пользоваетель');
                $user->user_pass = md5(Yii::app()->params['salt'].$model->new_pass);
                if (!$user->save(false))
                {
                    throw new CHttpException(403, 'Не удалось обновить пароль');
                }
                $url = $session['url_referrer'];
                $session->remove('url_referrer');
                $session->close();
                $this->render('message', array('message_title'=>'Изменение пароля', 'message'=>'Пароль успешно изменен', 'returnUrl'=>$url));
                Yii::app()->end();
            }
        }
        
        $session->close();
		$this->render('update_pass',array(
			'model'=>$model,
		));
    }
    
    public function getInfoArray(){
        return  array(
            'role' => array(
                'root' => 'Суперадмин',
                'administrator' => 'Админ',
                'moderator' => 'Модератор',
                'user' => 'Пользователь',
                'guest' => 'Гость'
            ),
            'type' => array(
                1 => 'Физическое лицо',
                2 => 'Юридическое лицо'
            ),
        );
    }

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
        $this->redirect(array('view', 'id'=>$id));
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
		$dataProvider=new CActiveDataProvider('Users');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Users('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Users']))
			$model->attributes=$_GET['Users'];

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
		$model=Users::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='users-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    /**
     * Метод выхода с сайта
     * 
     * Данный метод описывает в себе выход пользователя с сайта
     * Т.е. кнопочка "выход"
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
    }
    
    /**
     * Метод регистрации
     *
     * Выводим форму для регистрации пользователя и проверяем
     * данные которые придут от неё.
     */
    public function actionRegistration()
    {
        $model = new Users;
        $company = new Company;
        $toStep = 1;
        
        if ($_GET['backform'] == 1)
        {
            if (isset($_POST['Users']))
            {
                $model->user_type = $_POST['Users']['user_type'];
                if ($model->validate('step1'))
                {
                    $model->setScenario('step2');
                    $toStep = 2;
                    $model->email_notice = 1;
                }
            }
        }
        
        if ($_GET['backform'] == 2)
        {
            $toStep = 2;
            $model->setScenario('step2');
            
            if (isset($_GET['store_usertype']))
                $model->user_type = $_GET['store_usertype'];
            
            if(isset($_POST['Users']))
            {
                $model->attributes = $_POST['Users'];
                if (!Yii::app()->user->checkAccess('root'))
                {
                    $model->user_role = 'user';
                }
                if ($model->validate('step2'))
                {
                    // Регистрация города пользователя
                    $city = Citys::model()->findByAttributes(array('city_name'=>$_POST['Users']['user_cityname']));
                    if ($city===null)
                    {
                        $city = new Citys;
                        $city->city_name = $_POST['Users']['user_cityname'];
                        $city->save(false);
                    }
                    $model->user_city_id = $city->city_id;
                    
                    $pass = $model->user_pass;
                    if ($model->user_type == Users::USERTYPE_PHYS_PERSON)
                    {
                    	if ($model->save(false)){
                    		$subject = "Уведомление о регистрации на ZIZIZ";
	                   		$message = $this->textAfterRegistration($model->user_fio);
	                       	$mess = new Messages;
	                       	$mess->subject = $subject;
	                       	$mess->text = $message;
	                       	$mess->from = 'no-repeat@ziziz.ru';
	                       	$mess->to = $model->user_email;
	                       	$mess->save();
	                        if ($model->email_notice){
	                            Functions::sendMail($subject, $message, $model->user_email, 'no-repeat@ziziz.ru');
	                        }
                            
                            $loginForm = new LoginForm;
                            $loginForm->username = $model->user_login;
                            $loginForm->password = $_POST['Users']['user_pass'];
                            if ($loginForm->login())
                                $this->redirect(array('view', 'id'=>Yii::app()->user->id));
                            else
	                           $this->redirect(array('registration_ok'));
                    	}
                    }
                    else{
                    	$model->setScenario('step3');
	                    $toStep = 3;
                        $company->show_on_map = 1;
                    }
                }
            } 
        }
        
        if ($_GET['backform'] == 3)
        {
            $toStep = 3;
            $model->setScenario('step3');
            
            if(isset($_POST['Users']) && isset($_POST['Company']))
            {
                $model->attributes = $_POST['Users'];
                $company->attributes = $_POST['Company'];
                if ($company->validate())
                {
                    $pass = $model->user_pass;
                    if ($model->save(false))
                    {
                        $company->company_user_id = $model->user_id;
                        if ($company->save(false))
                        {
                        	$subject = "Уведомление о регистрации на ZIZIZ";
                            $message = $this->textAfterRegistration($model->user_fio);
                            $mess = new Messages;
	                       	$mess->subject = $subject;
	                       	$mess->text = $message;
	                       	$mess->from = 'no-repeat@ziziz.ru';
	                       	$mess->to = $model->user_email;
	                       	$mess->save();
                            if ($model->email_notice){
                            
                                Functions::sendMail($subject, $message, $model->user_email, 'no-repeat@ziziz.ru');
                            }
                            
                            $loginForm = new LoginForm;
                            $loginForm->username = $model->user_login;
                            $loginForm->password = $_POST['Users']['user_pass'];
                            if ($loginForm->login())
                                $this->redirect(array('view', 'id'=>Yii::app()->user->id));
                            else
	                           $this->redirect(array('registration_ok'));
                        }
                        else
                        {
                            $model->delete();
                            $this->render('message', array('message'=>'Регистрация не удалась'));
                            Yii::app()->end();
                        }
                    }
                }
            }          
        }
        
        if ($_GET['backform'] == 3 && isset($_POST['Users']['back']))
        {
            $toStep = 2;
            $model->setScenario('step2');
            $model->attributes = $_POST['Users'];
        }
        
        $_GET['step'] = $toStep;
		$this->render('registration',array(
			'model'=>$model,
            'company'=>$company,
            'step'=>$toStep,
		));
    }
    
    /**
     * Успешная регистрация
     *
     * Рендерим собщение об успешной регистрации.
     */
    public function actionRegistration_ok()
    {
        $this->render('registration_ok');
    }
    
    /**
     * Выбрана ссылка "Забыли пароль"
     *
     * Переходим на страницу восстановления пароля.
     */
    public function actionRecall()
    {
        $model = new RecallForm;
        if (isset($_POST['RecallForm']))
        {
            $model->attributes = $_POST['RecallForm'];
            if ($model->validate())
            {
                $key = $this->generateKey();
                $today = date('Y-m-d H:i');
                
                $recovery_key = new RecoveryKeys;
                $recovery_key->hash_key = $key;
                $recovery_key->user_id = $model->user_id;
                $recovery_key->date_create = $today;
                $recovery_key->lifetime = date('Y-m-d H:i', strtotime("+3 days".$today)); // 3 дня
                
                if ($recovery_key->save())
                {
                    $user = Users::model()->findByAttributes(array('user_email'=>$model->email));
                    $url = 'http://ziziz.ru'.Yii::app()->createUrl('users/recovery', array(
                        'key'=>$key,
                        'email'=>$model->email,
                    ));
                    $username = (!empty($user->user_fio)) ? $user->user_fio : $user->user_login;
                    $message = $this->textByRecoveryKey($username, $url);
                    if (Functions::sendMail('Письмо для восстановления пароля на сервисе ZIZIZ', $message, $model->email, "no-repeat@ziziz.ru"))
                    {
                        $this->render('send_ok');
                        Yii::app()->end();
                    }
                    else
                    {
                        $recovery_key->delete();
                        $this->render('message', array('$message_title'=>'Ошибка', 'message'=>'Не удалось отправить письмо с ключом'));
                        Yii::app()->end();
                    }
                }
            }
        }
        $this->render('recall', array('model'=>$model));
    }
    
    /**
     * Пользователь перешел по ссылке в e-maile
     *
     * 
     */
    public function actionRecovery()
    {
    	$model = new RecoveryForm;
        if (isset($_GET['key']))// && isset($_GET['email']))
        {
            $model->key = $_GET['key'];
            $model->email = $_GET['email'];
            $model->validateKey('key', null);
		}
        
        if (isset($_POST['RecoveryForm']))
        {
            $model->attributes = $_POST['RecoveryForm'];
            if ($model->validate())
            {
                $user = Users::model()->find('user_email=:email', array(':email'=>$model->email));
                if($user===null)
                {
                    $this->render('message', array('message'=>'Не найден пользователь.'));
                    Yii::app()->end();
                }
                
                $user->user_pass = md5(Yii::app()->params['salt'].$model->pass);
                if ($user->save(false))
                {
                    $del = RecoveryKeys::model()->findByPk($model->key_id);
                    $del->delete();
                    
                    $subject = "Уведомление о восстановлении пароля на сервисе ZIZIZ";
                    $username = (!empty($user->$user_fio)) ? $user->$user_fio : $user->user_login;
                    $message = $this->textAfterRecoveryPassword($username);
                    if ($user->email_notice){
                        Functions::sendMail($subject, $message, $user->user_email, 'no-repeat@ziziz.ru');
                    }
                    $mess = new Messages;
                    $mess->from = 0;
                    $mess->to = $user->user_id;
                    $mess->subject = $subject;
                    $mess->text = $message;
                    $mess->save();
                    
                    $loginForm = new LoginForm;
                    $loginForm->username = $user->user_login;
                    $loginForm->password = $model->pass;
                    if ($loginForm->login())
                        $this->redirect($this->createUrl('site/index'));
                    else
                        $this->render('message', array('message_title'=>'Восстановление пароля', 'message'=>'Пароль успешно восстановлен.'));
                    Yii::app()->end();
                }
                else
                {
                    $this->render('message', array('message_title'=>'Ошибка', 'message'=>'Не удалось изменить пароль.'));
                    Yii::app()->end();
                }
            }
        }
        
        $this->render('recovery', array(
            'model'=>$model,
        ));
    }
    
    private function generateKey()
    {
        $string = 'abcdefghijlklmnopqrstuvwxyzABCDEFGHIJLKLMNOPQRSTUVWXYZ1234567890';
        $result = '';
        $n = strlen($string);
        for ($i=0; $i<10; $i++)
        {
            $result .= $string[rand(0, $n)];
        }        
        return $result;
    }
    
    private function hashKey($key, $salt)
    {
        return md5($salt.$key);
    }
    
    public function actionUpdateAvatar()
    {
        if (isset($_POST['user_id']) && Yii::app()->user->id == $_POST['user_id'])
        {
            
            $uploaddir = '/uploads/avatars/';
            
            if (!is_dir($_SERVER['DOCUMENT_ROOT'].$uploaddir))
                mkdir($_SERVER['DOCUMENT_ROOT'].$uploaddir);
            
            $file_info = pathinfo($_FILES['Avatar']['name']);
            
//            if (strtolower($file_info['extension']) != 'jpg' || strtolower($file_info['extension']) != 'jpeg' || strtolower($file_info['extension']) != 'png')
//            {
//                echo strtolower($file_info['extension']);
//                Yii::app()->end();
//            }
            
            $filename = md5(time().$file_info['basename']).'.'.$file_info['extension'];
            
            $uploadfile = $_SERVER['DOCUMENT_ROOT'] . $uploaddir . $filename;
            
            if (move_uploaded_file($_FILES['Avatar']['tmp_name'], $uploadfile))
            {
                $user = Users::model()->findByPk($_POST['user_id']);
                if (is_file($_SERVER['DOCUMENT_ROOT'] . $uploaddir . $user->avatar))
                    unlink($_SERVER['DOCUMENT_ROOT'] . $uploaddir . $user->avatar);
                
                Yii::import('ext.phpthumb.EasyPhpThumb');
                $thumbs = new EasyPhpThumb();
                $thumbs->init();
                $thumbs->setThumbsDirectory($uploaddir);
                
                $thumbs
                ->load($_SERVER['DOCUMENT_ROOT'] . $uploaddir . $filename)
                ->resizeByGhz(177,215)
                ->save($filename);
                
                $user->avatar = $filename;
                $user->save(false);
                echo CHtml::image($uploaddir . $filename, '', array('id'=>'avatar_image'));
            }
            else
            {
               //WARNING! DO NOT USE "FALSE" STRING AS A RESPONSE!
               //Otherwise onSubmit event will not be fired
              echo "error";
            }
        }
        else
            echo "error";
        
        Yii::app()->end();
    }
    
    private function textAfterRegistration($name)
    {
        $zizizlink = CHtml::link('ZIZIZ.ru', $this->createUrl('site/index'));
        return
"<p>Здравствуйте, <strong>$name</strong>.</p>
<p>Мы благодарим Вас, что Вы воспользовались нашим бесплатным сервисом \"ZIZIZ.ru\". Мы стараемся сделать сервис максимально полезным для Наших пользователей, наша основная цель, организовать удобную базу объявлений.</p>
<p>Уважаемый(ая), <strong>$name</strong>, мы благодарим Вас за регистрацию на нашем сайте. Надеюсь мы принесем Вам пользу.</p>
<p>Если у Вас возникнут какие-либо вопросы по нашему сервису, Вы можете задать их нашей " . CHtml::link('службе поддержки', 'mailto:'.Yii::app()->params['support_email']) . ".</p>
<p>Это письмо было сгенерировано автоматически, и мы просим не отвечать на него!</p>
<p>Искренне Ваш, " . $zizizlink . "</p>";
    }
    
    private function textByRecoveryKey($name, $recoverylink)
    {
        $zizizlink = CHtml::link('ZIZIZ.ru', $this->createUrl('site/index'));
        return
"Здравствуйте, <strong>$name</strong>.<br />
Мы благодарим Вас, что Вы воспользовались нашим бесплатным сервисом \"ZIZIZ.ru\". Мы стараемся сделать сервис максимально полезным для Наших пользователей, наша основная цель, организовать удобную базу объявлений.<br />
Уважаемый(ая), <strong>$name</strong>, мы получили заявку на восстановления пароля для Вашего личного кабинета на сайте ZIZIZ.ru.<br />
Если данный запрос Вы не делали, мы призываем Вас проигнорировать это письмо!<br />
Для того, чтобы восстановить пароль, наш сервис сгенерировал ссылку, которой нужно перейти.<br />"
.CHtml::link($recoverylink, $recoverylink)
."Если у Вас возникнут какие-либо вопросы по нашему сервису, Вы можете задать их нашей " . CHtml::link('службе поддержки', 'mailto:'.Yii::app()->params['support_email']) . ". Это письмо было сгенерировано автоматически, и мы просим не отвечать на него!<br />
Искренне Ваш, " . $zizizlink . "</p>";
    }
    
    private function textAfterRecoveryPassword($name)
    {
        return
"Здравствуйте, <strong>$name</strong>.<br />
Поздравляем, Ваш пароль был успешно изменен!<br />
Если у Вас возникнут какие-либо вопросы по нашему сервису, Вы можете задать их нашей " . CHtml::link('службе поддержки', 'mailto:'.Yii::app()->params['support_email']) . ". Это письмо было сгенерировано автоматически, и мы просим не отвечать на него!<br />
Искренне Ваш, " . CHtml::link('ZIZIZ.ru', $this->createUrl('site/index'));
    }
}