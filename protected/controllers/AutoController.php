<?php

class AutoController extends Controller
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
				'actions'=>array('index','view','getModel', 'getModification', 'getCheckModification', 'renderModelByBrendId'),
				'roles'=>array('guest'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create'),
				'roles'=>array('guest'),
			),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update', 'delPhoto'),
				'roles'=>array('user'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'roles'=>array('moderator'),
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
        $model = Auto::model()->with(array(
            'user',
            'user.city',
            'automodel',
            'automodel.modelbrend',
            'commentBranchs',
            'commentBranchs.comments'))->findByPk($id, 'city.translit=:gorod', array(':gorod'=>$gorod));
            
        if($model===null)
			throw new CHttpException(404,'Страница не найдена.');

        $allowAccess = $model->user->user_id === Yii::app()->user->id;
        $allowAccess = $allowAccess || Yii::app()->user->checkAccess('moder') || Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('root');
        $allowAccess = $allowAccess || $model->auto_status == Auto::STATUS_PUBLISHED;
            
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
        if (Yii::app()->user->isGuest)
        {
            $user = new Users('force');
        }	   

		$model = new Auto;
        $brends = Brend::model()->findAll();
        
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Auto']))
		{
            
            // на случай если объявление добавляет авторизованный пользователь ставлю валидацию юзера в 1
			$user_valid = true;
            if (Yii::app()->user->isGuest && isset($_POST['Users']))
            {
                $user->attributes = $_POST['Users'];
                $password = 'qwe123'; // Functions::generateKey(6);
                $user->user_pass = $password;
                $user->user_role = 'user';
                $user->email_notice = true;
                $user->user_type = Users::USERTYPE_PHYS_PERSON;
                $session = Yii::app()->session;
                $session->open();
                $user->user_city_id = $session['cur_city_id'];
                $session->close();
                
                $user_valid = $user->validate();
                $user_reg = true;
            }		  

			$model->attributes=$_POST['Auto'];
            $auto_valid = $model->validate() && $user_valid;
            
            if ($auto_valid)
            {
                if ($user_reg)
                {
                    if ($user->save(false))
                        $model->auto_user = $user->user_id;
                    else
                        throw new CHttpException(403, "Не могу добавить пользователя");
                }
                else
                    $model->auto_user = Yii::app()->user->user_id;
                
                $model->auto_title = $model->automodel->modelbrend->b_name.' '
                    .$model->automodel->m_name.', '
                    .$model->auto_year.' года, пробег '
                    .Functions::priceFormat($model->auto_run).' км, цена '
                    .Functions::priceFormat($model->auto_price).' р.';
                    
                $model->auto_status = Auto::STATUS_PUBLISHED;
                
    			if($model->save(false))
                {
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
                    }

                    // редирект
                     $logmodel = new LoginForm;
                    $logmodel->username = $user->user_login;
                    $logmodel->password = $password;
                    $logmodel->rememberMe = 1;
                    if ($logmodel->login())
                    {
                        $this->render('/site/message', array(
                            'title'=>'Оповещение',
                            'message'=>'Вы зарегистрировались на сайте. Пароль выслан на Ваш email. Вы можете дополнить информацию о себе в '
                                .CHtml::link('личном кабинете', $this->createUrl('users/view', array('id'=>$user->user_id))) . '.',
                            'returnUrl'=>$this->createUrl('view', array('id'=>$model->auto_id, 'gorod'=>$model->user->city->translit))
                        ));
                        Yii::app()->end();
                    }
                    else
                        $this->redirect(array('view','id'=>$model->auto_id, 'gorod'=>$model->user->city->translit));
    			}
                else
                    throw new CHttpException(404, "Не могу сохранить объявление");
            }
		}
        
		$this->render('create',array(
			'model'=>$model,
            'brend'=>(isset($model->automodel->modelbrend)) ? $model->automodel->modelbrend : Brend::model(),
            'automodel'=>(isset($model->automodel)) ? $model->automodel : Carmodel::model(),
            'modification'=>(isset($model->modification)) ? $model->modification : Modification::model(),
            'user'=>$user,
            'brends'=>$brends
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
                if (file_exists($_SERVER['DOCUMENT_ROOT'].$del->ph_url))
                    unlink($_SERVER['DOCUMENT_ROOT'].$del->ph_url); //Удаляем оригинал
                if (file_exists($_SERVER['DOCUMENT_ROOT'].$mini))
                    unlink($_SERVER['DOCUMENT_ROOT'].$mini); //Удаляем маленькую
                if (file_exists($_SERVER['DOCUMENT_ROOT'].$big))
                    unlink($_SERVER['DOCUMENT_ROOT'].$big); //Удаляем большую
                
                $del->delete(); //Чистим базу
            }
        }
    }    
    
    public function actionGetModel($brend_id, $model_id)
    {
        $brend = Brend::model()->with('models', 'models.modifications')->findByPk($brend_id);
        
        if($brend===null)
			throw new CHttpException(404,'Страница не найдена.');

       	$this->renderPartial('getModel',array(
			'models'=>$brend->models,
            'model_id'=>$model_id,
		));
        
        Yii::app()->end();
    }
    
    public function actionGetModification($model_id, $modification_id)
    {
        $carmodel = Carmodel::model()->with('modifications')->findByPk($model_id);
        
        if($carmodel===null)
			throw new CHttpException(404,'Страница не найдена.');

        if ($modification_id == 0)
        {
            $modification = new Modification;
            
            $modification->mod_carcass = Yii::app()->request->getQuery('auto_carcass', 0);
            $modification->mod_fuel = Yii::app()->request->getQuery('auto_fuel', 0);
            $modification->mod_control = Yii::app()->request->getQuery('auto_control', 0);
            $modification->mod_box = Yii::app()->request->getQuery('auto_box', 0);
            $modification->mod_drive = Yii::app()->request->getQuery('auto_drive', 0);
            $modification->mod_vol = (Yii::app()->request->getQuery('auto_vol')==0) ? null : Yii::app()->request->getQuery('auto_vol');
            $modification->mod_year = (Yii::app()->request->getQuery('auto_year')==0) ? null : Yii::app()->request->getQuery('auto_year');
        }
        else
        {
            $modification = Modification::model()->findByPk($modification_id);
        }
        if ($modification ===null)
            throw new CHttpException(404,'Страница не найдена.');
            
       	$this->renderPartial('getModification',array(
			'modifications'=>$carmodel->modifications,
            'modification'=>$modification,
		));
        
        Yii::app()->end();
    }
    
    public function actionGetCheckModification($modification_id)
    {
        $model = Modification::model()->findByPk($modification_id);
        
//        if($model===null)
//			throw new CHttpException(404,'Страница не найдена.');

       	$this->renderPartial('getCheckModification',array(
			'model'=>($model===null) ? new Modification : $model,
		));
        
        Yii::app()->end();
    }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
        if (Yii::app()->user->id <> $model->auto_user) {
            throw new CHttpException(403, 'Вы можете редактировать только свои объявления');
        }
        $users = Users::model()->findAll();
        $brends = Brend::model()->findAll();
        
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Auto']))
		{
			$model->attributes=$_POST['Auto'];
            $model->auto_title = $model->automodel->modelbrend->b_name.' '
                .$model->automodel->m_name.', '
                .$model->auto_year.' года, пробег '
                .Functions::priceFormat($model->auto_run).' км, цена '
                .Functions::priceFormat($model->auto_price).' р.';
			if($model->save())
				$this->redirect(array('view','id'=>$model->auto_id, 'gorod'=>$model->user->city->translit));
		}
//        if(isset($_POST['Brend'])){
//            $brend->attributes=$_POST['Brend'];
//        }

		$this->render('create',array(
			'model'=>$model,
            'brend'=>(isset($model->automodel->modelbrend)) ? $model->automodel->modelbrend : Brend::model(),
            'automodel'=>(isset($model->automodel)) ? $model->automodel : Carmodel::model(),
            'modification'=>(isset($model->modification)) ? $model->modification : Modification::model(),
            'users'=>$users,
            'brends'=>$brends
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
            if ( !(Yii::app()->user->id === $model->auto_user) AND !(Yii::app()->user->checkAccess('admin')) )
                throw new CHttpException(403, 'Вы не обладаете достаточными правами для совершения данной операции');
                        
            $model->auto_status = Auto::STATUS_REMOVED;
            $model->save(false);
            
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('users/view', 'id'=>$model->auto_user));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($gorod = false)
    {
        $search = new AnnSearchForm;
        
        $session = Yii::app()->session;
        $session->open();

        if (!Yii::app()->request->isAjaxRequest)
        {
            $sess_city = Functions::translit($session['cur_city']);
            $session->close();
            $url = $this->createUrl('auto/index', array('gorod'=>$sess_city));
            if($sess_city != $gorod)
                $this->redirect($url);
        }
        
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
                'automodel',
                'automodel.modelbrend',
                'modification',
                'user'=>array(
                    'select'=>'user_city_id',
                ),
            ),
            'order'=>'auto_public_date DESC',
        ));
        $criteria->addCondition('auto_status='.Auto::STATUS_PUBLISHED.' AND user.user_city_id='.$city_id);
        
        $search_empty = true;
        
        if (isset($_POST['AnnSearchForm']))
        {
            $session->add('AnnSearchForm', $_POST['AnnSearchForm']);
        }
        
        if (isset($_POST['AutoSearch']))
        {
            $session->add('AutoSearch', $_POST['AutoSearch']);
        }
        
        if (isset($_POST['clear_search']))
        {
            $session->remove('AnnSearchForm');
            $session->remove('AutoSearch');
            $search_empty = true;
        }
        
        if (!empty($session['AnnSearchForm']))
        {
            $search->attributes = $_POST['AnnSearchForm'];
            $words = Functions::getWords($search->string);
            foreach ($words as $word)
            {
                $criteria->compare('auto_title', $word, true);
            }
            $search_empty = false;
        }
        

        if (!empty($session['AutoSearch']))
        {
            $criteria->compare('auto_carcass', $session['AutoSearch']['kuzov']);
        	$criteria->compare('auto_fuel', $session['AutoSearch']['fuel']);
        	$criteria->compare('auto_control', $session['AutoSearch']['control']);
        	$criteria->compare('auto_box', $session['AutoSearch']['kpp']);
        	$criteria->compare('auto_drive', $session['AutoSearch']['drive']);
            $criteria->compare('auto_year', $session['AutoSearch']['year']);
            
            if ( !empty($session['AutoSearch']['price_ot']) ) {
                $criteria->addCondition('auto_price>=:price_ot');
                $criteria->params[':price_ot'] = $session['AutoSearch']['price_ot'];
            }
                
            if ( !empty($session['AutoSearch']['price_do']) ) {
                $criteria->addCondition('auto_price<:price_do');
                $criteria->params[':price_do'] = $session['AutoSearch']['price_do'];
            }
            
            if (!empty($session['AutoSearch']['brend']))
            {
                $criteria->addCondition('b_id=:brend');
                $criteria->params[':brend'] = $session['AutoSearch']['brend'];
                $searchBrend = Brend::model()->with('models', 'models.modifications')->findByPk($session['AutoSearch']['brend']);
            }
            
            if (!empty($session['AutoSearch']['model']))
            {
                $criteria->addCondition('m_id=:model');
                $criteria->params[':model'] = $session['AutoSearch']['model'];
            }
            
            $search_empty = false;
            foreach ($session['AutoSearch'] as $item)
            {
                if (!empty($item))
                    break;
                $search_empty = true;
            }
        }
        
        $session->close();

        $dataProvider=new CActiveDataProvider('Auto', array(
            'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));
        
        if (Yii::app()->request->isAjaxRequest)
        {
        	$this->renderPartial('_list-view', array(
                'dataProvider' => $dataProvider,
                'search_empty' => $search_empty,
                //'search_params' => (isset($search_params)) ? $search_params : null,
            ));
        }
        else
        {            
            $this->render('index',array(
            	'dataProvider'=>$dataProvider,
                'AnnSearch'=>$search,
                'search_params' => $session['AutoSearch'],
                'search_empty' => $search_empty,
                'city_id' => $city_id,
                'gorod'=>$gorod,
                'searchBrend'=>$searchBrend,
            ));
        }
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Auto('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Auto']))
			$model->attributes=$_GET['Auto'];

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
		$model=Auto::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='auto-form')
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
            if (Yii::app()->user->id != Yii::app()->request->getPost('user_id', -1))
                throw new CHttpException(403, 'У Вас недостаточно прав для выполнения указанного действия');
                
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
    
    public function actionRenderModelByBrendId($brend_id = 0, $model_id = 0)
    {
        $brend = Brend::model()->with('models')->findByPk($brend_id);
        
        $listdata[''] = 'Любая';
        foreach(CHtml::ListData($brend->models, 'm_id', 'm_name') as $key => $item)
            $listdata[$key] = $item;


        reset($listdata);
        $seleketed_key = ($model_id==0) ? key($listdata) : $model_id;
        
        echo "<label>Модель</label>";
        echo "<div class='drop_list unexpand'>";
        echo "<span class='selected_value'>".$listdata[$seleketed_key]."</span>";
        echo CHtml::DropDownList('AutoSearch[model]', 'auto_model_id', $listdata);
        echo "<div class='select_options'>";
        foreach($listdata as $key => $item)
		{
		    $selected = ($key=='') ? ' selected' : '';
			echo CHtml::openTag('div', array('class'=>'select_option'.$selected, 'value'=>$key));
			echo $item;
			echo CHtml::closeTag('div');
		}
        echo "</div></div>";
        
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