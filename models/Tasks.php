<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "TASKS".
 *
 * @property int $ID
 * @property string|null $PUBLICATION_DATE
 * @property string $TITLE
 * @property string $DESCRIPTION
 * @property int|null $BUDGET
 * @property string|null $FILES
 * @property int|null $STATUS
 * @property string|null $EXECUTION_DATE
 * @property int $CATEGORY_ID
 * @property int $CUSTOMER_ID
 * @property int|null $EXECUTIONER_ID
 * @property int|null $CITY_ID
 *
 * @property CATEGORIES $CATEGORY
 * @property CITIES $CITY
 * @property USERS $CUSTOMER
 * @property USERS $EXECUTIONER
 * @property RATINGS[] $RATINGSs
 */
class Tasks extends \yii\db\ActiveRecord
{

    public $noResponses;
    public $noLocation;
    public $filterPeriod;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'TASKS';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['PUBLICATION_DATE', 'EXECUTION_DATE'], 'safe'],
            [['TITLE', 'DESCRIPTION', 'CATEGORY_ID', 'CUSTOMER_ID'], 'required'],
            [['TITLE', 'DESCRIPTION'], 'string'],
            [['BUDGET', 'STATUS_ID', 'CATEGORY_ID', 'CUSTOMER_ID', 'EXECUTIONER_ID', 'CITY_ID'], 'integer'],
            [['FILES'], 'string', 'max' => 255],
            [['CATEGORY_ID'], 'exist', 'skipOnError' => true, 'targetClass' => CATEGORIES::class, 'targetAttribute' => ['CATEGORY_ID' => 'ID']],
            [['CUSTOMER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => USERS::class, 'targetAttribute' => ['CUSTOMER_ID' => 'ID']],
            [['EXECUTIONER_ID'], 'exist', 'skipOnError' => true, 'targetClass' => USERS::class, 'targetAttribute' => ['EXECUTIONER_ID' => 'ID']],
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
            'PUBLICATION_DATE' => 'Дата публикации',
            'TITLE' => 'Название',
            'DESCRIPTION' => 'Описание',
            'BUDGET' => 'Бюджет',
            'FILES' => 'Файлы',
            'STATUS_ID' => 'Статус',
            'EXECUTION_DATE' => 'Дата исполнения',
            'CATEGORY_ID' => 'Категория',
            'CUSTOMER_ID' => 'Клиент',
            'EXECUTIONER_ID' => 'Исполнитель',
            'CITY_ID' => 'Город',
            'noResponses' => 'Без исполнителя',
            'noLocation' => 'Удаленная работа'
        ];
    }

    /**
     * Gets query for [[CATEGORY]].
     *
     * @return \yii\db\ActiveQuery|CategoriesQuery
     */
    public function getCATEGORY()
    {
        return $this->hasOne(CATEGORIES::class, ['ID' => 'CATEGORY_ID']);
    }

    /**
     * Gets query for [[CITY]].
     *
     * @return \yii\db\ActiveQuery|CitiesQuery
     */
    public function getCITY()
    {
        return $this->hasOne(CITIES::class, ['ID' => 'CITY_ID']);
    }

    /**
     * Gets query for [[CUSTOMER]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getCUSTOMER()
    {
        return $this->hasOne(USERS::class, ['ID' => 'CUSTOMER_ID']);
    }

    /**
     * Gets query for [[EXECUTIONER]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getEXECUTIONER()
    {
        return $this->hasOne(USERS::class, ['ID' => 'EXECUTIONER_ID']);
    }

    /**
     * Gets query for [[RATINGSs]].
     *
     * @return \yii\db\ActiveQuery|RatingsQuery
     */
    public function getRATINGSs()
    {
        return $this->hasMany(RATINGS::class, ['TASK' => 'ID']);
    }

    /**
     * {@inheritdoc}
     * @return TasksQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TasksQuery(get_called_class());
    }

    public function getSearchQuery() 
    {
        $query = self::find();

        $query->where(['STATUS_ID' => '1']);

        $query->andFilterWhere(['CATEGORY_ID' => $this->CATEGORY_ID]);

        if($this->noLocation) {
            $query->andWhere('CITY_ID IS NULL');
        }

        if($this->noResponses) {
            $query->andWhere([$this->EXECUTIONER_ID => '1']);
        }

        if($this->filterPeriod) {
            $query->andWhere('UNIX_TIMESTAMP(TASKS.PUBLICATION_DATE) > UNIX_TIMESTAMP() - :period', [':period' => $this->filterPeriod]);
        }

        return $query->orderBy('PUBLICATION_DATE DESC')->all();
    }
}
