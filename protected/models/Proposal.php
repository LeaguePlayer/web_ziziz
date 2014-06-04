<?php

/**
 * This is the model class for table "proposal".
 *
 * The followings are the available columns in table 'proposal':
 * @property integer $id
 * @property integer $type
 * @property string $user_id
 * @property string $description
 * @property string $user_phone
 */
class Proposal extends CActiveRecord
{
    const TYPE_SEARCH_SPAREPART = 'sparepart';
    const TYPE_SEARCH_SERVICES = 'service';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Proposal the static model class
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
		return 'proposal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_phone', 'required'),
            array('description', 'required', 'message'=>'Заявка не заполнена'),
			array('user_phone', 'length', 'max'=>20),
            array('year', 'date', 'format'=>array('yyyy')),
            array('VIN, carcass_number, carcass_type, box, brend_id, fuel', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('id, type, user_id, description, user_phone', 'safe', 'on'=>'search'),
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
            'brend'=>array(self::BELONGS_TO, 'Brend', 'brend_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'type' => 'Type',
			'user_id' => 'User',
			'description' => 'Заявка',
			'user_phone' => 'Телефон',
			'user_email' => 'Ваш email',
            'VIN'=>'VIN',
            'carcass_number'=>'Номер кузова',
            'carcass_type'=>'Тип кузова',
            'box'=>'Коробка передач',
            'brend_id'=>'Марка авто',
            'year'=>'Год выпуска',
            'fuel'=>'Тип топлива'
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

		$criteria->compare('id',$this->id);
		$criteria->compare('type',$this->type);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('user_phone',$this->user_phone,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}