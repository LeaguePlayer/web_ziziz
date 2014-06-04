<?php

/**
 * This is the model class for table "citys".
 *
 * The followings are the available columns in table 'citys':
 * @property integer $city_id
 * @property string $city_name
 * @property double $city_ymap_pos1
 * @property double $city_ymap_pos2
 */
class Citys extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Citys the static model class
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
		return 'citys';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('city_name', 'required'),
			array('city_ymap_pos1, city_ymap_pos2', 'numerical'),
			array('city_name', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('city_id, city_name, city_ymap_pos1, city_ymap_pos2', 'safe', 'on'=>'search'),
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
			'city_id' => 'City',
			'city_name' => 'City Name',
			'city_ymap_pos1' => 'City Ymap Pos1',
			'city_ymap_pos2' => 'City Ymap Pos2',
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

		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('city_name',$this->city_name,true);
		$criteria->compare('city_ymap_pos1',$this->city_ymap_pos1);
		$criteria->compare('city_ymap_pos2',$this->city_ymap_pos2);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function beforeSave()
    {
        if (parent::beforeSave())
        {
            $this->city_name = trim($this->city_name);
            $this->city_name = preg_replace('/\s{2}/', ' ', $this->city_name);
            $this->city_name = str_replace(array('г.', 'город'), '', strtolower($this->city_name));
            $this->translit = Functions::translit($this->city_name);
            return true;
        }
        return false;
    }
}