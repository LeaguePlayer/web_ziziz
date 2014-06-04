<?php

class CLinkPagerExt extends CLinkPager
{   
    public $anker = 'listview-container';
    
	protected function createPageButton($label, $page, $class, $hidden, $selected)
    {
//        $idController = $this->getController()->getId();        
//        $url = $this->getController()->createUrl("$idController/index", array($idController."_page"=>$page+1));
//        if($hidden || $selected)
//            $class.=' '.($hidden ? self::CSS_HIDDEN_PAGE : self::CSS_SELECTED_PAGE);
//        return '<li class="'.$class.'">'.CHtml::ajaxLink($label,$url,array(
//            'update'=>'#listview-container',
//        )).'</li>';
        
        if($hidden || $selected)
			$class.=' '.($hidden ? self::CSS_HIDDEN_PAGE : self::CSS_SELECTED_PAGE);
		return '<li class="'.$class.'">'.CHtml::link($label,$this->createPageUrl($page).'#'.$this->anker).'</li>';
    }
}