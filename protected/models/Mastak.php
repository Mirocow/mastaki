<?php

/**
 * This is the model class for table "mastak".
 *
 * The followings are the available columns in table 'mastak':
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $address
 * @property string $education
 * @property string $experience
 * @property string $qualities
 * @property string $birthdate
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Skill[] $skills
 */
class Mastak extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mastak';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, phone, address, education, experience, qualities, birthdate', 'required'),
			array('name', 'length', 'max'=>128),
			array('phone, status', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, phone, address, education, experience, qualities, birthdate, status', 'safe', 'on'=>'search'),
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
			'skills' => array(self::MANY_MANY, 'Skill', 'mastak_skill(mastak_id, skill_id)'),
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
			'phone' => 'Phone',
			'address' => 'Address',
			'education' => 'Education',
			'experience' => 'Experience',
			'qualities' => 'Qualities',
			'birthdate' => 'Birthdate',
			'status' => 'Status',
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
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('education',$this->education,true);
		$criteria->compare('experience',$this->experience,true);
		$criteria->compare('qualities',$this->qualities,true);
		$criteria->compare('birthdate',$this->birthdate,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Mastak the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
