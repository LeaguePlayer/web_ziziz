<?php

class AnnouncementsController extends Controller
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
				'actions'=>array('index','view','getClassif','GetClassifValues','GetIncludedClassifiers','AjaxTreeRender', 'AjaxClassifBarRender', 'getModel'),
				'roles'=>array('guest'),
                //'roles'=>array('admin')
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create'),
				'roles'=>array('guest'),
			),
			
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update', 'delPhoto'),
				'roles'=>array('user'),
			),
            
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('admin'),
				'roles'=>array('moderator'),
			),
			
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete'),
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
	public function actionView($id, $gorod)
	{       
        $model = Announcements::model()->with(array(
            'user',
            'user.city',
            'commentBranchs',
            'commentBranchs.comments'))->findByPk($id, 'city.translit=:gorod', array(':gorod'=>$gorod));
                        
        if ($model===null)
            throw new CHttpException(404, 'Не найдена запись');

        $allowAccess = $model->user->user_id === Yii::app()->user->id;
        $allowAccess = $allowAccess || Yii::app()->user->checkAccess('moder') || Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('root');
        $allowAccess = $allowAccess || $model->ann_status == Announcements::STATUS_PUBLISHED;
            
        if (!$allowAccess)
            throw new CHttpException(404, 'Страница недоступна');
        
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
		$model=new Announcements;
		//defaults set
        if (Yii::app()->user->isGuest)
        {
            $user = new Users('force');
        }
        
        $model->ann_status = Announcements::STATUS_MODERATED;
        $model->ann_state = Announcements::STATE_UNKNOWN;
        $category = Category::model()->findAll("cat_parent=0");
        
		if(isset($_POST['Announcements']))
		{          		  
            // на случай если объявление добавляет авторизованный пользователь ставлю валидацию юзера в 1
			$user_valid = true;
            if (Yii::app()->user->isGuest && isset($_POST['Users']))
            {
                $user->attributes = $_POST['Users'];
                $password = Functions::generateKey(6);
                $user->user_pass = $password;
                $user->user_role = 'user';
                $user->email_notice = 1;
                $user->user_type = Users::USERTYPE_PHYS_PERSON;
                $session = Yii::app()->session;
                $session->open();
                $user->user_city_id = (isset($session['cur_city_id'])) ? $session['cur_city_id'] : Yii::app()->params['def_city_id'];
                $session->close();
                
                $user_valid = $user->validate();
                $user_reg = true;
            }
            
            $model->attributes=$_POST['Announcements'];
            $ann_valid = $model->validate() && $user_valid;
            if ($ann_valid)
            {
                
                
                if ($user_reg)
                {
                    if ($user->save(false))
                        $model->ann_user_id = $user->user_id;
                    else
                        throw new CHttpException(404, "Не могу добавить пользователя");
                }
                else
                    $model->ann_user_id = Yii::app()->user->user_id;
                
    			if($model->save(false))
                {
                    $city = Citys::model()->findByPk($model->user->user_city_id);
                    // отправка сообщения о быстрой регистрации
                    if ($user_reg)
                    {
                        $login = $model->user->user_login;
                        $subject = "Уведомление о регистрации на ZIZIZ";
                        $text = $this->textAfterForceRegistration($login, $password);
                        if ($model->user->email_notice == true)
                        {
                            Functions::sendMail($subject, $text, $model->user->user_email, 'no-repeat@ziziz.ru');
                        }
                        
                        $message = new Messages;
                        $message->from = 0;
                        $message->to = $model->user->user_id;
                        $message->subject= $subject;
                        $message->text = $text;
                        $message->save();
                        
                        $logmodel = new LoginForm;
                        $logmodel->username = $user->user_login;
                        $logmodel->password = $password;
                        $logmodel->rememberMe = 1;
                        if ($logmodel->login())
                        {
                            $this->redirect(array('view','id'=>$model->ann_id));
                            $this->render('message', array(
                                'title'=>'Оповещение',
                                'message'=>'Вы зарегистрировались на сайте. Пароль выслан на Ваш email. Вы можете дополнить информацию о себе в '
                                    .CHtml::link('личном кабинете', $this->createUrl('users/view', array('id'=>$user->user_id))) . '.',
                                'returnUrl'=>$this->createUrl('view', array('id'=>$model->ann_id))
                            ));
                            Yii::app()->end();
                        }
                        else
                        {
                            $this->redirect(array('index','id'=>$model->ann_id, 'gorod'=>($city===null) ? Functions::translit(Yii::app()->params['def_city_name']) : $city->translit));
                        }
                    }
                    // отправка сообщения о добавлении объявления
//                    $message = new Messages;
//                    $message->from = 0;
//                    $message->to = Users::model()->find('user_role=:role', array(':role'=>'moderator'));
//                    $message->subject= 'Уведомление о добавлении объявления';
//                    $message->text = $text;
//                    $message->save();

                    // редирект
                    //if ($user_reg)
                    //    $this->redirect('users/registration_ok');
                    //$this->redirect(array('/users/view','id'=>Yii::app()->user->id));
                    $this->redirect(array('view','id'=>$model->ann_id, 'gorod'=>($city===null) ? Functions::translit(Yii::app()->params['def_city_name']) : $city->translit));
    			}
                else
                    throw new CHttpException(404, "Не могу сохранить объявление");
            }
		}
 
        //$cs=Yii::app()->getClientScript();
        //$cs->registerScriptFile(Yii::app()->baseUrl.'/js/ann-create-update.js', CClientScript::POS_HEAD);
		
        $this->render('create',array(
            'user'=>$user,
			'model'=>$model,
            'category'=>$category,
		));
	}
    
    /**
	 * Удаляем фотки.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
    private function updatePhoto($id){
        if($id > 0){
            if(is_numeric($_POST['mainphoto']) and $_POST['mainphoto'] > 0){
                $command = Yii::app()->db->createCommand();
                $command->update('photo', array('ph_main'=>0), 'ph_gal_id=:id', array(':id'=>$id));
                $command->update('photo', array('ph_main'=>1), 'ph_id=:id', array(':id'=>$_POST['mainphoto']));
            }
        }  
    }
    
    
    public function actionGetModel($brend_id, $model_id)
    {
        $brend = Brend::model()->with('models')->findByPk($brend_id);
        
        if($brend===null)
			throw new CHttpException(404,'Страница не найдена.');

       	$this->renderPartial('getModel',array(
			'models'=>$brend->models,
            'model_id'=>$model_id,
		));
        
        Yii::app()->end();
    }
    
    
    /**
	 * Удаляем фотки.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
    private function deletePhoto(){
        if(!empty($_POST['delphoto'])){
            
            foreach($_POST['delphoto'] as $photo){
                $del = Photo::model()->findByPk($photo);
                if($del===null) continue;
                $mini = str_replace('original_','thumbs/mini_',$del->ph_url);
                $big = str_replace('original_','thumbs/big_',$del->ph_url);
                unlink($_SERVER['DOCUMENT_ROOT'].$del->ph_url); //Удаляем оригинал
                unlink($_SERVER['DOCUMENT_ROOT'].$mini); //Удаляем маленькую
                unlink($_SERVER['DOCUMENT_ROOT'].$big); //Удаляем большую
                
                $del->delete(); //Чистим базу
            }
        }
    }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=Announcements::model()->with('values')->findByPk($id);
        if ($model===null)
            throw new CHttpException(403, 'Не найдена запись');
        if (Yii::app()->user->id <> $model->ann_user_id) {
            throw new CHttpException(403, 'Вы можете редактировать только свои объявления');
        }
        $category = Category::model()->findAll();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        
		if(isset($_POST['Announcements']))
		{
			$model->attributes=$_POST['Announcements'];
            
			if($model->save())
            {
                $city = Citys::model()->findByPk($model->user->user_city_id);
                $this->redirect(array('view','id'=>$model->ann_id, 'gorod'=>($city===null) ? Functions::translit(Yii::app()->params['def_city_name']) : $city->translit));
			}
		}
        //add jQuery
        Yii::app()->getClientScript()->registerCoreScript('jquery');
        
		$this->render('update',array(
			'model'=>$model,
            'category'=>$category,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
			$model = $this->loadModel($id);
            if ( !(Yii::app()->user->id === $model->ann_user_id) AND !(Yii::app()->user->checkAccess('admin')) )
                throw new CHttpException(403, 'Вы не обладаете достаточными правами для совершения данной операции');
            
            $model->ann_status = Announcements::STATUS_REMOVED;
            $model->save(false);
            
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('users/view', 'id'=>$model->ann_user_id));
	}



	/**
	 * Lists all models.
	 */
    public function actionIndex($gorod=false)
    {
    	// Открываем сессию для хранения текущего критерия отбора объявлений
        $session = Yii::app()->session;
        $session->open();

        if (!Yii::app()->request->isAjaxRequest)
        {
            $sess_city = Functions::translit($session['cur_city']);
            $session->close();
            $url = $this->createUrl('announcements/index', array('gorod'=>$sess_city));
            if($sess_city != $gorod)
                $this->redirect($url);
        }
        
    	// Текущая категория в поиске
        $cur_category = null;
        
        if ($gorod)
        {
            $city_id = Citys::model()->findByAttributes(array('translit'=>$gorod))->city_id;
            if (!$city_id)
                throw new CHttpException(403, 'Запрашиваемая страница не найдена');
        }
        else
        {
            $city_id = (!empty($session['cur_city_id'])) ? $session['cur_city_id'] : false;
            
            if (!$city_id)
            {
                if (Yii::app()->user->isGuest)
                    $city_id = Yii::app()->params['def_city_id'];
                else
                {
                	$user = Users::model()->findByPk(Yii::app()->user->id);
         			$city_id = (!empty($user->user_city_id)) ? $user->user_city_id : Yii::app()->params['def_city_id'];
                }
            }
        }
        
        $criteria = new CDbCriteria(array(
            'with'=>array(
                'user'=>array(
                    'select'=>'user_city_id',
                ),
                'automodel',
                'automodel.modelbrend'
            ),
            'order'=>'ann_public_date DESC',
        ));
        $criteria->addCondition('ann_status='.Announcements::STATUS_PUBLISHED.' AND user.user_city_id='.$city_id);
        
        $session_cleared = true;

		if (isset($_GET['clear_session']) && $_GET['clear_session'])
        {
            $session->remove('AnnSearchForm');
            $session->remove('AnnPriceSearchForm');
            $session->remove('check_classif');
            $session->remove('cat_id');
            $session->remove('ann_brend');
            $session->remove('ann_model');
        }
        
        if (isset($_POST['brend_id']))
        {
            if (is_numeric($_POST['brend_id']))
            {
                $session->add('ann_brend', $_POST['brend_id']);
            }
            else
            {
                $session->remove('ann_brend');
            }
            $session->remove('ann_model');
        }

        if (isset($_POST['brendmodel_id']))
        {
            if (is_numeric($_POST['brendmodel_id']))
            {
                $session->add('ann_model', $_POST['brendmodel_id']);
            }
            else
            {
                $session->remove('ann_model');
            }
        }

        $search = new AnnSearchForm;
        if (isset($_POST['AnnSearchForm']))
        {
            $search->attributes = $_POST['AnnSearchForm'];
            $session['AnnSearchForm'] = $search->string;
        }
        
        
        $priceForm = new AnnPriceSearchForm;        
        if (isset($_POST['AnnPriceSearchForm']))
        {            
            $priceForm->price_ot = $_POST['AnnPriceSearchForm']['price_ot'];
            $priceForm->price_do = $_POST['AnnPriceSearchForm']['price_do'];
            // записываем в сессию
            $session->add('AnnPriceSearchForm', $_POST['AnnPriceSearchForm']);
        }       
        
        if (isset($_GET['cat_id']))
        {
            if (is_numeric($_GET['cat_id']))
            {
                $session->add('cat_id', $_GET['cat_id']);
            }
            else
            {
                $session->remove('cat_id');
            }
            $session->remove('check_classif');
        }

        if (isset($_GET['check_classif']) || isset($_GET['check_classif_value']))
        {
       		$arr = $session['check_classif'];
            if (empty($_GET['check_classif_value']) && isset($arr[$_GET['check_classif']]))
                unset($arr[$_GET['check_classif']]);
            else
       		   $arr[$_GET['check_classif']] = $_GET['check_classif_value'];
            $session->add('check_classif', $arr);
		}

        if(!empty($session['ann_brend']))
        {
            $criteria->addCondition('b_id='.$session['ann_brend']);
            $session_cleared = false;
        }

        if(!empty($session['ann_model']))
        {
            $criteria->addCondition('m_id='.$session['ann_model']);
            $session_cleared = false;
        }

        if (!empty($session['AnnSearchForm']))
        {
            $criteria->addSearchCondition('ann_name', $session['AnnSearchForm']['string']);
            $search->string = $session['AnnSearchForm'];
            $session_cleared = false;
        }
        
		if (!empty($session['AnnPriceSearchForm']))
		{
			if (!empty($session['AnnPriceSearchForm']['price_ot']) && empty($session['AnnPriceSearchForm']['price_do']))
                $criteria->addCondition('ann_price>='.$session['AnnPriceSearchForm']['price_ot']);
            elseif (empty($session['AnnPriceSearchForm']['price_ot']) && !empty($session['AnnPriceSearchForm']['price_do']))
                $criteria->addCondition('ann_price<='.$session['AnnPriceSearchForm']['price_do']);
            elseif (!empty($session['AnnPriceSearchForm']['price_ot']) && !empty($session['AnnPriceSearchForm']['price_do']))
                $criteria->addBetweenCondition('ann_price', $session['AnnPriceSearchForm']['price_ot'], $session['AnnPriceSearchForm']['price_do']);
            if (!empty($session['AnnPriceSearchForm']['cat_id']))
            //$priceForm->price_ot = $session['AnnPriceSearchForm']['price_ot'];
            //$priceForm->price_do = $session['AnnPriceSearchForm']['price_do'];
            
            $session_cleared = false;
		}
        
		if (!empty($session['cat_id']))
		{
			$criteria->addCondition('ann_category='.$session['cat_id']);
			$cur_category = Category::model()->findByPk($session['cat_id']);
            $session_cleared = false;
		}
		
		if (!empty($session['check_classif'])) 
        {
            $criteria->join = "INNER JOIN ann_classif ON ann_id = ac_ann_id";
            //$criteria->distinct = true;
            $len = count($session['check_classif']);
            if ($len > 1)
            {
                $arr = implode(',', $session['check_classif']);
                $criteria->addCondition('ac_classifval_id IN ('.$arr .')');
                $criteria->group = 'ac_ann_id';
                $criteria->having = 'count(DISTINCT ac_classifval_id)='.$len;
            }
            else
            {
                $criteria->addCondition('ac_classifval_id='.array_shift($session['check_classif']));
            }
            $session_cleared = false;
		}
        $dataProvider = new CActiveDataProvider('Announcements', array(
            'criteria'=>$criteria,
            'pagination'=>array(
            	'pageSize'=>20,
           	),
        ));
        $categories = Category::model()->with(array(
			'childs',
			'childsCount',
		))->findAll();

        if (Yii::app()->request->isAjaxRequest)
        {
        	$this->renderPartial('_announceList', array(
                'dataProvider' => $dataProvider,
              	'categories' => $categories,
                'cur_category' => $cur_category,
                'session_cleared' => $session_cleared,
                'check_classif' => $session['check_classif'],
            ));
   		}
        else
        {
        	$this->render('index',array(
                'form'=>$priceForm,
	        	'dataProvider'=>$dataProvider,
	            'categories'=>$categories,
	            'cur_category'=>$cur_category,
                'session_cleared' => $session_cleared,
                'check_classif' => $session['check_classif'],
                'city_id'=>$city_id,
                'brend'=>$session['ann_brend'],
                'brendmodel'=>$session['ann_model']
	        ));
        }
        $session->close();
    }

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Announcements('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Announcements']))
			$model->attributes=$_GET['Announcements'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
    
    public function actionGetClassif($ajax, $category_id=0, $ann_id=0)
	{
		if (Yii::app()->request->isAjaxRequest)
        {
            if ($category_id==0) Yii::app()->end();
            
	        $category = Category::model()->with(array(
                'classifiers',
                'classifiers.values',
            ))->findByPk($category_id);
            
	        if($category===null) Yii::app()->end();
            
            if ($ann_id != 0)
                $announcement = Announcements::model()->with(array('values', 'values.classif'))->findByPk($ann_id);
	        
	       	$this->renderPartial('_classifHtml', array(
				'classifiers'=>$category->classifiers,
                'check_classifvalues'=>$announcement->values,
			));
	        Yii::app()->end();
   		}
    }
    
    public function actionGetIncludedClassifiers($announcement_id)
    {
        if (isset($_POST['ajax']))
        {
            // Достаем ид-шники и значкния подключенных к объявлению классификаторов
            $model = Announcements::model()->with('values')->findByPk($announcement_id);
            //Yii::app()->end();
            $this->renderPartial('_checkedValuesHtml', array(
            	'model'=>$model,
                //'classifValues'=>$model->values,
			));
        }
        Yii::app()->end();
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Announcements::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='announcements-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    public function actionDelPhoto()
    {
        if (Yii::app()->request->isAjaxRequest && isset($_POST['delphoto_id']))
        {
            $del = Photo::model()->findByPk($_POST['delphoto_id']);
            if($del===null)
            {
                echo 0;
                Yii::app()->end();
            }
            $mini = str_replace('original_','thumbs/mini_',$del->ph_url);
            $big = str_replace('original_','thumbs/big_',$del->ph_url);
            if (file_exists($_SERVER['DOCUMENT_ROOT'].$del->ph_url)) unlink($_SERVER['DOCUMENT_ROOT'].$del->ph_url); //Удаляем оригинал
            if (file_exists($_SERVER['DOCUMENT_ROOT'].$mini)) unlink($_SERVER['DOCUMENT_ROOT'].$mini); //Удаляем маленькую
            if (file_exists($_SERVER['DOCUMENT_ROOT'].$big)) unlink($_SERVER['DOCUMENT_ROOT'].$big); //Удаляем большую
            
            $del->delete(); //Чистим базу
            echo 1;
            Yii::app()->end();
        }
        echo 0;
    }
    
    private function textAfterForceRegistration($login, $password)
    {
        return
"Здравствуйте, <strong>$login</strong>.<br />
Мы благодарим Вас, что Вы воспользовались нашим бесплатным сервисом \"ZIZIZ.ru\". Мы стараемся сделать сервис максимально полезным для Наших пользователей, наша основная цель, организовать удобную базу объявлений.<br />
Мы благодарим Вас за размещение объявления на нашем сайте. Так же Вы были автоматически зарегистрированы на нашем сайте:<br />
Ваш логин для входа на сайт <strong>$login</strong><br />
Пароль <strong>$password</strong><br />
Если у Вас возникнут какие-либо вопросы по нашему сервису, Вы можете задать их нашей " . CHtml::link('службе поддержки', 'mailto:'.Yii::app()->params['support_email']) . ". Это письмо было сгенерировано автоматически, и мы просим не отвечать на него!<br />
Искренне Ваш, " . CHtml::link('ZIZIZ.ru', $this->createUrl('site/index'));
    }
}
