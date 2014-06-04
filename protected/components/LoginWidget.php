<?
class LoginWidget extends CWidget
{
    public $visible=true;
 
    public function run()
    {
        if($this->visible)
        {
            $this->renderContent();
        }
    }
 
    protected function renderContent()
    {
    	if ($this->controller->action->id != 'authenticate')
    	{
    		$model = new LoginForm;
        
			// if it is ajax validation request
			if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
			{
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
			// collect user input data
			if(isset($_POST['LoginForm']))
			{
				$model->attributes=$_POST['LoginForm'];
				// validate user input and redirect to the previous page if valid
				if($model->validate() && $model->login())
	            {
	                if ($this->controller->getAction()->getId()=='recovery')
	                    $url = array('site/index');
	                else
	                    $url = $model->url;
	                $this->controller->redirect($url);
	            }
	            else
	            {
	            	$session = Yii::app()->session;
	            	$session->open();
	            	$session->add('LoginForm', $_POST['LoginForm']);
	            	$session->close();
	            	$this->controller->redirect(array('site/authenticate', '#'=>'authenticate-form'));
	            }
			}
			// display the login form
			$this->render('loginForm',array('model'=>$model));
    	}
    }   
}