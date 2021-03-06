<?php

class CommentsAutoController extends Controller
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
				'roles'=>array('guest'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'roles'=>array('guest'),
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
	public function actionCreate($auto_id, $branch_id = 0)
	{
        if (isset($_POST['comment_cancel']))
        {
            $gorod = Auto::model()->findByPk($auto_id)->user->city->translit;
            $this->redirect($this->createUrl('auto/view', array('id'=>$auto_id, 'gorod'=>$gorod)));
        }
        
		$model=new CommentsAuto;
        
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        $branch = CommentBranchAuto::model()->with(array(
            'auto'=>array('select'=>'auto_user, auto_title'),
            'comments',
            'comments.author',
        ))->findByPk($branch_id);
		if(isset($_POST['CommentsAuto']))
		{
            $isNewBranch = false;
            if ($branch === null)
            {
                $branch = new CommentBranchAuto;
                $branch->auto_id = $auto_id;
                if (!$branch->save())
                    throw new CHttpException(404, "Не могу добавить комментарий.");
                $isNewBranch = true;
            }
            
			$model->attributes=$_POST['CommentsAuto'];
            $model->branch_id = $branch->id;
			if($model->save())
            {
                $author = $model->author;
                $seler = $branch->auto->user;
                if ($author->user_id != $seler->user_id)
                {
                    $subject = "Уведомление с сервиса ZIZIZ";
                    
                    if (!empty($seler->user_fio))
                        $selername = $seler->user_fio;
                    else
                        $selername = $seler->user_login;
                    $postname = $branch->auto->auto_title;
                    $postlink =  Yii::app()->params['domain'].$this->createUrl('auto/view', array('id'=>$branch->auto->auto_id, 'gorod'=>$seler->city->translit));
                    $text = $this->textByComment($selername, $postname, $postlink);
                    if ($seler->email_notice == true){
                        Functions::sendMail($subject, $text, $seler->user_email, "no-repeat@ziziz.ru");
                    }
                    
                    $message = new Messages;
                    $message->from = $author->user_id;
                    $message->to = $seler->user_id;
                    $message->subject = $subject;
                    $message->text = $text;
                    $message->post_type = 'auto';
                    $message->post_id = $branch->auto->auto_id;
                    $message->save();
                    
                }
                $this->redirect($this->createUrl('auto/view', array('id'=>$auto_id, 'gorod'=>$seler->city->translit, '#'=>'branch-'.$branch->id)));
			}
            else if ($isNewBranch)
                $branch->delete();
		}
        if (Yii::app()->request->isAjaxRequest)
        {
            $this->renderPartial('_form', array('model'=>$model, 'branch'=>$branch));
            Yii::app()->end();
        }
        
		$this->render('create',array(
			'model'=>$model,
            'branch'=>$branch,
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

		if(isset($_POST['CommentsAuto']))
		{
			$model->attributes=$_POST['CommentsAuto'];
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
		$dataProvider=new CActiveDataProvider('CommentsAuto');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new CommentsAuto('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CommentsAuto']))
			$model->attributes=$_GET['CommentsAuto'];

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
		$model=CommentsAuto::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='comments-auto-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    private function textByComment($username, $postname, $postlink)
    {
        return
"Здравствуйте, <strong>$username</strong>.<br />
Уважаемый, <strong>$username</strong>, хотим Вам с радостью сообщить, что на сайте ZIZIZ.ru Вам поступил вопрос по объявлению «{$postname}».". CHtml::link('Перейти к просмотру', $postlink) ."<br />
Если у Вас возникнут какие-либо вопросы по нашему сервису, Вы можете задать их нашей " . CHtml::link('службе поддержки', 'mailto:'.Yii::app()->params['support_email']) . ". Это письмо было сгенерировано автоматически, и мы просим не отвечать на него!<br />
Искренне Ваш, " . CHtml::link('ZIZIZ.ru', $this->createUrl('site/index'));
    }
}
