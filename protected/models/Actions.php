<?php

/**
 * This is the model class for table "actions".
 *
 * The followings are the available columns in table 'actions':
 * @property string $id
 * @property string $title
 * @property string $short_desc
 * @property string $full_desc
 * @property string $img
 * @property string $date_public
 * @property string $meta_title
 * @property string $meta_keys
 * @property string $meta_desc
 * @property string $last_update
 * @property integer $status
 * @property integer $actual_date
 */
class Actions extends CActiveRecord
{
    const STATUS_MODERATED 		= 1; // на модерации
	const STATUS_PUBLISHED 		= 2; // опубликовано
    const STATUS_BLOCKED 		= 3; // заблокировано
	const STATUS_REMOVED 		= 4; // удалено
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Actions the static model class
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
		return 'actions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, short_desc, full_desc, actual_date', 'required'),
			array('title, img, meta_title', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, short_desc, full_desc, img, date_public, meta_title, meta_keys, meta_desc, last_update, status, actual_date', 'safe', 'on'=>'search'),
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
            'user'=>array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Заголовок',
			'short_desc' => 'Краткое описание',
			'full_desc' => 'Полное описание',
			'img' => 'Фото',
			'date_public' => 'Дата публикации',
			'meta_title' => 'Meta Title',
			'meta_keys' => 'Meta Keys',
			'meta_desc' => 'Meta Desc',
			'last_update' => 'Last Update',
			'status' => 'Status',
			'actual_date' => 'Актуально до',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('short_desc',$this->short_desc,true);
		$criteria->compare('full_desc',$this->full_desc,true);
		$criteria->compare('img',$this->img,true);
		$criteria->compare('date_public',$this->date_public,true);
		$criteria->compare('meta_title',$this->meta_title,true);
		$criteria->compare('meta_keys',$this->meta_keys,true);
		$criteria->compare('meta_desc',$this->meta_desc,true);
		$criteria->compare('last_update',$this->last_update,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('actual_date',$this->actual_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    protected function beforeSave()
    {
        $this->last_update = date('Y-m-d H:i');
        if ($this->isNewRecord)
        {
            $today = time();
            $this->date_public = date('Y-m-d',$today);
            $this->status = self::STATUS_MODERATED;
            $this->user_id = Yii::app()->user->id;
        }
        return true;
    }
}