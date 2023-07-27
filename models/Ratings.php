<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "RATINGS".
 *
 * @property int $ID
 * @property int|null $RATED_USER
 * @property int|null $RATING_USER
 * @property int|null $SCORE
 * @property int|null $TASK
 * @property string|null $DT_ADD
 *
 * @property USERS $RATEDUSER
 * @property USERS $RATINGUSER
 * @property TASKS $TASK
 */
class Ratings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'RATINGS';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['RATED_USER', 'RATING_USER', 'SCORE', 'TASK'], 'integer'],
            [['DT_ADD'], 'safe'],
            [['RATED_USER'], 'exist', 'skipOnError' => true, 'targetClass' => USERS::class, 'targetAttribute' => ['RATED_USER' => 'ID']],
            [['RATING_USER'], 'exist', 'skipOnError' => true, 'targetClass' => USERS::class, 'targetAttribute' => ['RATING_USER' => 'ID']],
            [['TASK'], 'exist', 'skipOnError' => true, 'targetClass' => TASKS::class, 'targetAttribute' => ['TASK' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'RATED_USER' => 'Rated User',
            'RATING_USER' => 'Rating User',
            'SCORE' => 'Score',
            'TASK' => 'Task',
            'DT_ADD' => 'Dt Add',
        ];
    }

    /**
     * Gets query for [[RATEDUSER]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getRATEDUSER()
    {
        return $this->hasOne(USERS::class, ['ID' => 'RATED_USER']);
    }

    /**
     * Gets query for [[RATINGUSER]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getRATINGUSER()
    {
        return $this->hasOne(USERS::class, ['ID' => 'RATING_USER']);
    }

    /**
     * Gets query for [[TASK]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTASK()
    {
        return $this->hasOne(TASKS::class, ['ID' => 'TASK']);
    }

    /**
     * {@inheritdoc}
     * @return RatingsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RatingsQuery(get_called_class());
    }
}
