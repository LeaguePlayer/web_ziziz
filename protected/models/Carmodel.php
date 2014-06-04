<?php

/**
 * This is the model class for table "model".
 *
 * The followings are the available columns in table 'model':
 * @property integer $m_id
 * @property string $m_name
 * @property integer $m_brend_id
 */
class Carmodel extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Model the static model class
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
		return 'carmodel';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('m_name, m_brend_id', 'required'),
			array('m_brend_id', 'numerical', 'integerOnly'=>true),
			array('m_name', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('m_id, m_name, m_brend_id', 'safe', 'on'=>'search'),
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
            'modelbrend'=>array(self::BELONGS_TO, 'Brend', 'm_brend_id'),
            'modifications'=>array(self::HAS_MANY, 'Modification', 'mod_model_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'm_id' => 'M',
			'm_name' => 'Название модели',
			'm_brend_id' => 'Марка',
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

		$criteria->compare('m_id',$this->m_id);
		$criteria->compare('m_name',$this->m_name,true);
		$criteria->compare('m_brend_id',$this->m_brend_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}