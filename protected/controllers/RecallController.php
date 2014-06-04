<?php
class RecallController extends Controller
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
				'actions'=>array('index', 'send'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
    
    public function actionIndex()
    {
        $this->render('index');
    }
    
    public function actionSend()
    {
        if (isset($_POST['Users'])) ;
        if (!$user)
        {
            //
        }
        
        $recall = new Recall();
        $recall->recall_key = $recall->generateKey();
        $recall->recall_user_id = $user->user_id;
        $recall->recall_date_create = time();
        $recall->recall_lifetime = time() + 3600 * 24 * 3; // 3 дня
        
        print_r($recall->recall_user_id);
        die();
        if ($recall->save())
        {
            $url = Yii::app()->createUrl('recall/index', array('key'=>$recall->recall_key,));
            if (mail($user->user_email, 'Восстановление пароля', $url))
                $this->render('send');
        }
    }
 }
 ?>