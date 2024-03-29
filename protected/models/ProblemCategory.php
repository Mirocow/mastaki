<?php

/**
 * This is the model class for table "problem_category".
 *
 * The followings are the available columns in table 'problem_category':
 * @property integer $id
 * @property integer $pos
 * @property string $name
 * @property string $icon
 * @property integer $active
 * @property integer $device_type_id
 */
class ProblemCategory extends CActiveRecord
{
    public $icon_file;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'problem_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, device_type_id', 'required'),
			array('name', 'length', 'max'=>45),
            array('icon_file', 'file', 'types'=>'jpg, jpeg, gif, png', 'allowEmpty' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, device_type_id, pos, icon, active', 'safe', 'on'=>'search'),
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
            'problems' => array(self::HAS_MANY, 'Problem', 'problem_category_id'),
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProblemCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function nextPos()
    {
        $criteria = new CDbCriteria;
        $criteria->select = new CDbExpression('MAX(pos) as maxPos');
        $cmd = self::model()->getCommandBuilder()->createFindCommand(self::model()->tableName(), $criteria);
        $max = $cmd->query()->read();

        return $max['maxPos'] + 1;
    }

    protected function beforeSave()
    {

        if($this->isNewRecord)
        {
            $this->pos = $this->nextPos();
        }
        parent::beforeSave();
        return true;
    }
}
