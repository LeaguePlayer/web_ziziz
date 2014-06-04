<?php
$this->pageTitle = "ZIZIZ | Регистрация нового пользователя"

//$this->menu=array(
	//array('label'=>'Список', 'url'=>array('index')),
	//array('label'=>'Manage Users', 'url'=>array('admin')),
//);
?>

<?php
    if($step == '1')
    {
        
        $this->breadcrumbs=array(
        	'Регистрация пользователя - Шаг 1',
        );
        echo $this->renderPartial('_form-step1', array('model'=>$model));
    }
    elseif($step == '2')
    {
        $this->breadcrumbs=array(
        	'Регистрация пользователя - Шаг 1' => array('registration'),
            'Шаг 2',
        );
        echo $this->renderPartial('_form-step2', array('model'=>$model, 'citys'=>$citys));
    }
    else
    {
        $this->breadcrumbs=array(
        	'Регистрация пользователя - Шаг 1' => array('registration'),
            'Шаг 2' => array('registration', 'step'=>2, 'store_usertype'=>$model->user_type),
            'Шаг 3',
        );
        echo $this->renderPartial('_form-step3', array('model'=>$model, 'company'=>$company));
    }
 ?>
