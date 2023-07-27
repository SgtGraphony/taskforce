<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "USERS".
 *
 * @property int $ID
 * @property string|null $REGISTRATION_DATE
 * @property string $NAME
 * @property string $PASSWORD
 * @property string $EMAIL
 * @property string|null $PICTURE
 * @property string|null $BIRTHDAY
 * @property int|null $PHONE_NUMBER
 * @property string|null $TELEGRAM
 * @property string|null $ABOUT
 * @property int $CITY_ID
 *
 * @property CITIES $CITY
 * @property RATINGS[] $RATINGSs
 * @property RATINGS[] $RATINGSs0
 * @property TASKS[] $TASKSs
 * @property TASKS[] $TASKSs0
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'USERS';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['REGISTRATION_DATE', 'BIRTHDAY'], 'safe'],
            [['NAME', 'PASSWORD', 'EMAIL', 'CITY'], 'required'],
            [['NAME', 'ABOUT'], 'string'],
            [['PHONE_NUMBER', 'CITY'], 'integer'],
            [['PASSWORD', 'EMAIL', 'PICTURE', 'TELEGRAM'], 'string', 'max' => 255],
            [['EMAIL'], 'unique'],
            [['CITY_ID'], 'exist', 'skipOnError' => true, 'targetClass' => CITIES::class, 'targetAttribute' => ['CITY_ID' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'Идентификатор',
            'REGISTRATION_DATE' => 'Дата регистрации',
            'NAME' => 'Имя',
            'PASSWORD' => 'Пароль',
            'EMAIL' => 'Электронная почта',
            'PICTURE' => 'Изображение',
            'BIRTHDAY' => 'Дата рождения',
            'PHONE_NUMBER' => 'Номер телефона',
            'TELEGRAM' => 'Telegram',
            'ABOUT' => 'Описание',
            'CITY_ID' => 'город',
        ];
    }

    /**
     * Gets query for [[CITY]].
     *
     * @return \yii\db\ActiveQuery|CitiesQuery
     */
    public function getCITY()
    {
        return $this->hasOne(CITIES::class, ['ID' => 'CITY']);
    }

    /**
     * Gets query for [[RATINGSs]].
     *
     * @return \yii\db\ActiveQuery|RatingsQuery
     */
    public function getRATINGSs()
    {
        return $this->hasMany(RATINGS::class, ['RATED_USER' => 'ID']);
    }

    /**
     * Gets query for [[RATINGSs0]].
     *
     * @return \yii\db\ActiveQuery|RatingsQuery
     */
    public function getRATINGSs0()
    {
        return $this->hasMany(RATINGS::class, ['RATING_USER' => 'ID']);
    }

    /**
     * Gets query for [[TASKSs]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTASKSs()
    {
        return $this->hasMany(TASKS::class, ['CUSTOMER_ID' => 'ID']);
    }

    /**
     * Gets query for [[TASKSs0]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTASKSs0()
    {
        return $this->hasMany(TASKS::class, ['EXECUTIONER_ID' => 'ID']);
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
