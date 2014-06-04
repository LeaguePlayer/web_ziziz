<?php

class AnnSearch extends CWidget
{
    public $params = array(
        'url' => '',
        'update'=>'',
    );
    
    public function run()
    {
        $form = new AnnSearchForm();
        if (isset($_POST['AnnSearchForm']))
        	$form->attributes = $_POST['AnnSearchForm'];
        $this->render('annSearch', array(
            'form'=>$form,
            'url'=>$this->params['url'],
            'update'=>$this->params['update'],
        ));
    }
}