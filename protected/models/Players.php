<?php

/**
 * This is the model class for table "players".
 *
 * The followings are the available columns in table 'players':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $upid
 * @property integer $state
 * @property integer $group_id
 * @property integer $timetable_id
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property Groups $group
 * @property States $state0
 * @property Users $user
 * @property Timetables $timetable
 */
class Players extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'players';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('state, group_id, timetable_id, user_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('upid', 'length', 'max'=>32),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, description, upid, state, group_id, timetable_id, user_id', 'safe', 'on'=>'search'),
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
			'group' => array(self::BELONGS_TO, 'Groups', 'group_id'),
			'state0' => array(self::BELONGS_TO, 'States', 'state'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'timetable' => array(self::BELONGS_TO, 'Timetables', 'timetable_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
			'upid' => 'Upid',
			'state' => 'State',
			'group_id' => 'Group',
			'timetable_id' => 'Timetable',
			'user_id' => 'User',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('upid',$this->upid,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('timetable_id',$this->timetable_id);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Players the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
