<?php

class AnnPriceSearch extends CWidget
{
    public $cur_category;
    
    public function run()
    {
        $form = new AnnPriceSearchForm();
        
        if (isset($_POST['AnnPriceSearchForm']))
        {
        	$form->price_ot = $_POST['AnnPriceSearchForm']['price_ot'];
        	$form->price_do = $_POST['AnnPriceSearchForm']['price_do'];
       	}
        $this->render('annPriceSearch', array(
            'form'=>$form,
            'cur_category'=>$this->cur_category,
        ));
    }
}