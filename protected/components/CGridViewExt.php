<?php

class CGridViewExt extends CGridView
{
    //public $status;
    
    /**
	 * Renders a table body row.
	 * @param integer $row the row number (zero-based).
	 */
	public function renderTableRow($row)
	{
		if($this->rowCssClassExpression!==null)
		{
			$data=$this->dataProvider->data[$row];
			echo '<tr class="'.$this->evaluateExpression($this->rowCssClassExpression,array('row'=>$row,'data'=>$data)).'">';
		}
		else if(is_array($this->rowCssClass) && ($n=count($this->rowCssClass))>0)
			echo '<tr class="'.$this->rowCssClass[$row%$n].'">';
        //else if($data->)
		else
			echo '<tr>';
		foreach($this->columns as $column)
			$column->renderDataCell($row);
		echo "</tr>\n";
	}
}