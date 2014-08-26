<?php

/**
 * This is the model class for table "tasks".
 *
 * The followings are the available columns in table 'tasks':
 * @property string $id
 * @property string $user_id
 * @property string $text
 * @property string $date_to
 * @property integer $is_closed
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Task extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tasks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('is_closed', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>11),
			array('text', 'length', 'max'=>255),
			array('date_to', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, text, date_to, is_closed', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'text' => 'Text',
			'date_to' => 'Date To',
			'is_closed' => 'Is Closed',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('date_to',$this->date_to,true);
		$criteria->compare('is_closed',$this->is_closed);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Task the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function recognizeDate()
    {
        if (preg_match('/(сегодня|Сегодня|Завтра|завтра|Послезавтра|послезавтра|Вчера|вчера|Позавчера|позавчера)/i', $this->text, $matches))
        {
            $date_matches = array(
                'сегодня' => date('Y-m-d'),
                'Сегодня' => date('Y-m-d'),
                'завтра' => date('Y-m-d', time()+3600*24),
                'Завтра' => date('Y-m-d', time()+3600*24),
                'послезавтра' => date('Y-m-d', time()+3600*24*2),
                'Послезавтра' => date('Y-m-d', time()+3600*24*2),
                'вчера' => date('Y-m-d', time()-3600*24),
                'Вчера' => date('Y-m-d', time()-3600*24),
                'позавчера' => date('Y-m-d', time()-3600*24*2),
                'Позавчера' => date('Y-m-d', time()-3600*24*2),
            );

            $this->date_to = $date_matches[$matches[0]];

            return true;
        }

        if (preg_match('/((\s|^)[0-3]?[0-9]\s+(января|февраля|марта|апреля|мая|июня|июля|августа|сентября|октября|ноября|декабря))/i', $this->text, $matches))
        {
            $day = reset(explode(' ', trim($matches[0])));
            $month = array_search($matches[3], explode('|', 'января|февраля|марта|апреля|мая|июня|июля|августа|сентября|октября|ноября|декабря'));

            $this->date_to = date('Y-m-d', strtotime(sprintf('%s.%s.%s', $day, $month+1, date('Y'))));

            return true;
        }

        if (preg_match('/([0-3]?[0-9]{1})\.([0-1]?[0-9]{1})\.(20[0-9]{2})/', $this->text, $matches))
        {
            $this->date_to = date('Y-m-d', strtotime($matches[0]));

            return true;
        }

        $this->addError('date_to', 'Упс.... Не удалось распознать дату!');

        return false;
    }

    /**
     * True если просрочено
     * @return bool
     */
    public function isOverdue()
    {
        return strtotime(date('Y-m-d', time())) > strtotime($this->date_to);
    }

    public function close()
    {
        $this->is_closed = 1;

        $this->save(false);
    }

    public function getAllErrors()
    {
        $errs = array();

        foreach ($this->getErrors() as $e)
            $errs[] = join(', ', $e);

        return join(', ', $errs);
    }
}
