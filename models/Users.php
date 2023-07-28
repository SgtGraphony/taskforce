<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string|null $registration_dt
 * @property string $name
 * @property string $password
 * @property string $email
 * @property string|null $picture
 * @property string|null $birthday
 * @property int|null $phone_number
 * @property string|null $telegram
 * @property string|null $about
 * @property int $city_id
 *
 * @property City $city
 * @property Rating[] $ratings
 * @property Rating[] $ratings0
 * @property Task[] $tasks
 * @property Task[] $tasks0
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['registration_dt', 'birthday'], 'safe'],
            [['name', 'password', 'email', 'city_id'], 'required'],
            [['name', 'about'], 'string'],
            [['phone_number', 'city_id'], 'integer'],
            [['password', 'email', 'picture', 'telegram'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'registration_dt' => 'Registration Dt',
            'name' => 'Name',
            'password' => 'Password',
            'email' => 'Email',
            'picture' => 'Picture',
            'birthday' => 'Birthday',
            'phone_number' => 'Phone Number',
            'telegram' => 'Telegram',
            'about' => 'About',
            'city_id' => 'City ID',
        ];
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery|CityQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Ratings]].
     *
     * @return \yii\db\ActiveQuery|RatingQuery
     */
    public function getRatings()
    {
        return $this->hasMany(Rating::class, ['performer_id' => 'id']);
    }

    /**
     * Gets query for [[Ratings0]].
     *
     * @return \yii\db\ActiveQuery|RatingQuery
     */
    public function getRatings0()
    {
        return $this->hasMany(Rating::class, ['client_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['client_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Task::class, ['performer_id' => 'id']);
    }

    public function getReply()
    {
        return $this->hasMany(Reply::class, ['performer_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }
}
