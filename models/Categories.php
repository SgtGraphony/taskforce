<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "CATEGORIES".
 *
 * @property int $ID
 * @property int|null $CHARACTER_CODE
 * @property string $CATEGORY
 * @property string|null $ICON
 *
 * @property TASKS[] $TASKSs
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'CATEGORIES';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CHARACTER_CODE'], 'integer'],
            [['CATEGORY'], 'required'],
            [['CATEGORY'], 'string'],
            [['ICON'], 'string', 'max' => 255],
            [['CHARACTER_CODE'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'CHARACTER_CODE' => 'Character Code',
            'CATEGORY' => 'Category',
            'ICON' => 'Icon',
        ];
    }

    /**
     * Gets query for [[TASKSs]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTASKSs()
    {
        return $this->hasMany(TASKS::class, ['CATEGORY_ID' => 'ID']);
    }

    /**
     * {@inheritdoc}
     * @return CategoriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoriesQuery(get_called_class());
    }
}
