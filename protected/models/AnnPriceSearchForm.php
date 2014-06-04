<?php

class AnnPriceSearchForm extends CFormModel
{
    public $price_ot;
    public $price_do;
    
    public function safeAttributes()
    {
        return array('price_ot, price_do');
    }

}