<?php

/**
 * This is the model class for table "brend".
 *
 * The followings are the available columns in table 'brend':
 * @property integer $b_id
 * @property string $b_name
 * @property string $b_meta_keys
 * @property string $b_meta_title
 * @property string $b_meta_description
 * @property string $b_meta_html
 */
class Brend extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Brend the static model class
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
		return 'brend';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('b_id', 'numerical', 'integerOnly'=>true),
			array('b_name', 'required'),
			array('b_name', 'length', 'max'=>150),
			array('b_meta_keys, b_meta_title', 'length', 'max'=>255),
			array('b_meta_description, b_meta_html', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('b_id, b_name, b_meta_keys, b_meta_title, b_meta_description, b_meta_html', 'safe', 'on'=>'search'),
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
            'models'=>array(self::HAS_MANY, 'Carmodel', 'm_brend_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'b_id' => 'B',
			'b_name' => 'Название марки',
            'b_meta_title' => 'Title',
            'b_meta_keys' => 'Ключи',
            'b_meta_description' => 'Description',
            'b_meta_html' => 'Html',
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

		$criteria->compare('b_id',$this->b_id);
		$criteria->compare('b_name',$this->b_name,true);
		$criteria->compare('b_meta_keys',$this->b_meta_keys,true);
		$criteria->compare('b_meta_title',$this->b_meta_title,true);
		$criteria->compare('b_meta_description',$this->b_meta_description,true);
		$criteria->compare('b_meta_html',$this->b_meta_html,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}