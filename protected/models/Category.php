<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property integer $cat_id
 * @property string $cat_name
 * @property integer $cat_parent
 */
class Category extends CActiveRecord
{
    protected function beforeDelete(){
        
        $command = Yii::app()->db->createCommand();
        $command->delete('cat_classif', 'cc_cat_id=:id', array(':id'=>$this->cat_id));
        
        return parent::beforeDelete();
    }
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Category the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cat_name, cat_parent', 'required'),
			array('cat_parent', 'numerical', 'integerOnly'=>true),
			array('cat_name', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cat_id, cat_name, cat_parent', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'anns_cats'=>array(self::HAS_MANY, 'Announcements', 'ann_category'),
            'classifiers'=>array(self::MANY_MANY, 'Classifier', 'cat_classif(cc_cat_id, cc_classif_id)'),
            //'cv'=>array(self::HAS_MANY,'ClassifValue',array('id'=>''),'through'=>'classifiers'),
            'parent'=>array(self::BELONGS_TO, get_class($this), 'cat_parent'),
            'childs'=>array(self::HAS_MANY, get_class($this), 'cat_parent'),
            'childsCount'=>array(self::STAT, get_class($this), 'cat_parent', 'select'=>'count(*)'),
            'announcementsCount'=>array(self::STAT, 'Announcements', 'ann_category'),
            'classifiersCount' => array(self::STAT, 'Classifier', 'cat_classif(cc_cat_id, cc_classif_id)',
                'select' => 'COUNT(*)'
            ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cat_id' => 'Cat',
			'cat_name' => 'Название категории',
			'cat_parent' => 'Родительская категория',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('cat_id',$this->cat_id);
		$criteria->compare('cat_name',$this->cat_name,true);
		$criteria->compare('cat_parent',$this->cat_parent);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function getAllAnnouncCount()
    {
        $result = $this->announcementsCount;
        foreach ($this->childs as $child)
        {
            $result += $child->getAllAnnouncCount();
        }
        return $result;
    }
    
    public function getRootCategory()
    {
        $root = $this;
        if ($root->cat_parent <> 0)
        {
            $root = $this->parent->getRootCategory();
        }
        return $root;
    }
    
    /**
     *  Функция ищет полный путь до указанного узла в дереве.
     *  @param Category $to - до какого узла ищем путь
     *  @param Category $from - от какого узла. По умолчанию поиск идет от корневого узла.
     *  @return - массив, содержащий узловые категории.
     */
    public static function getNodesToCategory(Category $to, Category $from = null)
    {
        $result = array();
        if ($to)
        {
            if (!$from)
            {
                $from = $to->getRootCategory();
            }
            $temp = $to;
            while ($temp->cat_id <> $from->cat_id)
            {
                array_unshift($result, $temp->parent);
                $temp = $temp->parent;
            }
            $result[] = $to;
        }
        return $result;
    }
    
    
    
    
    public static function compareCategory(Category $A, Category $B)
    {
        return ($A->cat_id == $B->cat_id ? true : false);
    }
    
    
    
    
    public function inArray($arr = array())
    {
        $result = false;
        if (!is_array($arr))
        {
            if ($arr instanceof Category)
            {
                return self::compareCategory($this, $arr);
            }
        }
        else
        {
            foreach ($arr as $node)
            {
                if (self::compareCategory($this, $node))
                {
                    $result = true;
                    break;
                }
            }
        }
        return $result;
    }
}