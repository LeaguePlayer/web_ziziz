<?php

/**
 * This is the model class for table "modification".
 *
 * The followings are the available columns in table 'modification':
 * @property integer $mod_id
 * @property integer $mod_carcass
 * @property integer $mod_fuel
 * @property integer $mod_control
 * @property integer $mod_box
 * @property integer $mod_drive
 * @property double $mod_vol
 * @property integer $mod_run
 * @property integer $mod_year
 */
class Modification extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Modification the static model class
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
		return 'modification';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mod_carcass, mod_fuel, mod_control, mod_box, mod_drive, mod_vol, mod_year, mod_name, mod_model_id', 'required'),
			array('mod_carcass, mod_fuel, mod_control, mod_box, mod_drive, mod_year, mod_model_id', 'numerical', 'integerOnly'=>true),
			array('mod_vol', 'numerical'),
            array('mod_name', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('mod_id, mod_carcass, mod_fuel, mod_control, mod_box, mod_drive, mod_vol, mod_year', 'safe', 'on'=>'search'),
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
            'automodel'=>array(self::BELONGS_TO, 'Carmodel', 'mod_model_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'mod_id' => 'Mod',
            'mod_model_id' => 'Модель',
            'mod_name' => 'Название модификации',
			'mod_carcass' => 'Кузов',
			'mod_fuel' => 'Топливо',
			'mod_control' => 'Положение руля',
			'mod_box' => 'КПП',
			'mod_drive' => 'Привод',
			'mod_vol' => 'Объем двигателя',
			'mod_year' => 'Год выпуска',
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

		$criteria->compare('mod_id',$this->mod_id);
		$criteria->compare('mod_carcass',$this->mod_carcass);
		$criteria->compare('mod_fuel',$this->mod_fuel);
		$criteria->compare('mod_control',$this->mod_control);
		$criteria->compare('mod_box',$this->mod_box);
		$criteria->compare('mod_drive',$this->mod_drive);
		$criteria->compare('mod_vol',$this->mod_vol);
		$criteria->compare('mod_year',$this->mod_year);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public static function getInfoArray()
    {
        return  array(
            'kuzov' => array(
                0 => 'Не указано',
                1 => 'Седан',
                2 => 'Хэтчбек',
                3 => 'Универсал',
                4 => 'Джи Кроссовер',
                5 => 'Кабриолет',
                6 => 'Пикап'
            ),
            'control' => array(
                0 => 'Не указано',
                1 => 'Слева',
                2 => 'Справа'
            ),
            'fuel' => array(
                0 => 'Не указано',
                1 => 'Бензин', 
                2 => 'Дизель'
            ),
            'kpp' => array(
                0 => 'Не указано',
                1 => 'Механика',
                2 => 'Автомат'
            ),
            'drive' => array(
                0 => 'Не указано',
                1 => 'Передний',
                2 => 'Задний',
                3 => '4WD'
            )
        );
    }
}