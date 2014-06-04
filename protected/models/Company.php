<?php

/**
 * This is the model class for table "company".
 *
 * The followings are the available columns in table 'company':
 * @property integer $company_id
 * @property string $company_name
 * @property string $company_address
 * @property double $company_ymap_pos1
 * @property double $company_ymap_pos2
 * @property integer $company_user_id
 */
class Company extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Company the static model class
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
		return 'company';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_name, company_address, company_type', 'required'),
			array('company_name, company_address', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('company_id, company_name, company_address, company_ymap_pos1, company_ymap_pos2, company_user_id', 'safe', 'on'=>'search'),
            array('show_on_map', 'safe'),
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
            'user'=>array(self::BELONGS_TO, 'Users', 'company_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'company_id' => 'Company',
			'company_name' => 'Название фирмы',
			'company_address' => 'Адрес',
			'company_ymap_pos1' => 'Координата 1',
			'company_ymap_pos2' => 'Координата 2',
			'company_user_id' => 'Представитель фирмы',
            'company_type'=>'Тип деятельности',
            'show_on_map'=>'Показать на карте',
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

		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('company_address',$this->company_address,true);
		$criteria->compare('company_ymap_pos1',$this->company_ymap_pos1);
		$criteria->compare('company_ymap_pos2',$this->company_ymap_pos2);
		$criteria->compare('company_user_id',$this->company_user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function types() {
        
        $types = array(
            array('label'=>'СТО' ,'name'=>'sto', 'icon'=>'/images/maps_sto.png'),
            array('label'=>'Автомагазины' ,'name'=>'avtoshop', 'icon'=>'/images/maps_avtoshop.png'),
            array('label'=>'Автомойки' ,'name'=>'autowash', 'icon'=>'/images/maps_sto.png'),
            array('label'=>'Шиномонтаж' ,'name'=>'tireservice', 'icon'=>'/images/maps_sto.png'),
            array('label'=>'АЗС' ,'name'=>'gasstation', 'icon'=>'/images/maps_sto.png'),
        );
        
        if ( Yii::app()->request->isAjaxRequest )
        {
            echo json_encode($types);
            Yii::app()->end();
        }
        
        return $types;
    }
}