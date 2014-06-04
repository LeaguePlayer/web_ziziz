<?php

/**
 * This is the model class for table "lookup".
 *
 * The followings are the available columns in table 'lookup':
 * @property integer $lookup_id
 * @property string $name
 * @property string $type
 * @property integer $code
 * @property integer $position
 */
class Lookup extends CActiveRecord
{
    // Типы кодификаторов
    const PRODUCT_STATE = 'ProductState';
    const ANNOUNCEMENTS_STATUS = 'AnnouncementsStatus';
    const USER_TYPE = 'UserType';
    const COMPANY_TYPE = 'CompanyType';
    const DATE_INTERVAL = 'DateInterval';
    const COMMENT_TYPE = 'CommentType';
    const PROPOSAL_TYPE = 'ProposalType';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Lookup the static model class
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
		return 'lookup';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, type, code, position', 'required'),
			array('code, position', 'numerical', 'integerOnly'=>true),
			array('name, type', 'length', 'max'=>64),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('lookup_id, name, type, code, position', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'lookup_id' => 'Lookup',
			'name' => 'Name',
			'type' => 'Type',
			'code' => 'Code',
			'position' => 'Position',
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

		$criteria->compare('lookup_id',$this->lookup_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('code',$this->code);
		$criteria->compare('position',$this->position);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	private static $_items=array();
 
    public static function items($type)
    {
        if(!isset(self::$_items[$type]))
            self::loadItems($type);
        return self::$_items[$type];
    }
 
    public static function item($type,$code)
    {
        if(!isset(self::$_items[$type]))
            self::loadItems($type);
        return isset(self::$_items[$type][$code]) ? self::$_items[$type][$code] : false;
    }
 
    private static function loadItems($type)
    {
        self::$_items[$type]=array();
        $models=self::model()->findAll(array(
            'condition'=>'type=:type',
            'params'=>array(':type'=>$type),
            'order'=>'position',
        ));
        foreach($models as $model)
            self::$_items[$type][$model->code]=$model->name;
    }
}