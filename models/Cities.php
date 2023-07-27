<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Cities".
 *
 * @property int $ID
 * @property string|null $CITY
 * @property float|null $LATITUDE
 * @property float|null $LONGDITUDE
 */
class Cities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Cities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CITY'], 'string'],
            [['LATITUDE', 'LONGDITUDE'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'CITY' => 'City',
            'LATITUDE' => 'Latitude',
            'LONGDITUDE' => 'Longditude',
        ];
    }

    /**
     * {@inheritdoc}
     * @return CitiesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CitiesQuery(get_called_class());
    }
}
