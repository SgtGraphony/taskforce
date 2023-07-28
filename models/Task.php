<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string|null $publication_dt
 * @property string $title
 * @property string $description
 * @property int|null $budget
 * @property string|null $files
 * @property int|null $status_id
 * @property string|null $execution_dt
 * @property int $category_id
 * @property int $client_id
 * @property int|null $performer_id
 * @property int|null $city_id
 * @property string|null $adress
 *
 * @property Category $category
 * @property City $city
 * @property User $client
 * @property User $performer
 * @property Rating[] $ratings
 * @property Status $status
 */
class Task extends \yii\db\ActiveRecord
{

    public $noResponses;
    public $noLocation;
    public $filterPeriod;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['publication_dt', 'execution_dt'], 'safe'],
            [['title', 'description', 'category_id', 'client_id'], 'required'],
            [['title', 'description', 'adress'], 'string'],
            [['budget', 'status_id', 'category_id', 'client_id', 'performer_id', 'city_id'], 'integer'],
            [['files'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['client_id' => 'id']],
            [['performer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['performer_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Идентификатор',
            'publication_dt' => 'Дата публикации',
            'title' => 'Название',
            'description' => 'Описание',
            'budget' => 'Бюджет',
            'files' => 'Файлы',
            'status_id' => 'Статус',
            'execution_dt' => 'Дата выполнения',
            'category_id' => 'Категория',
            'client_id' => 'Клиент',
            'performer_id' => 'Исполнитель',
            'city_id' => 'Город',
            'adress' => 'Адрес',
            'noLocation' => 'Удаленная работа',
            'noResponses' => 'Без отзывов'
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery|CategoryQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
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
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getClient()
    {
        return $this->hasOne(User::class, ['id' => 'client_id']);
    }

    /**
     * Gets query for [[Performer]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getPerformer()
    {
        return $this->hasOne(User::class, ['id' => 'performer_id']);
    }

    /**
     * Gets query for [[Ratings]].
     *
     * @return \yii\db\ActiveQuery|RatingQuery
     */
    public function getRatings()
    {
        return $this->hasMany(Rating::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery|StatusQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery|ReplyQuery
     */
    public function getReply()
    {
        return $this->hasMany(Reply::class, ['task_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return TaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskQuery(get_called_class());
    }

    public function getSearchQuery() 
    {
        $query = self::find();

        $query->where(['status_id' => '1']);

        $query->andFilterWhere(['category_id' => $this->category_id]);

        if($this->noLocation) {
            $query->andWhere('city_id IS NULL');
        }

        if($this->noResponses) {
            $query->andWhere([$this->performer_id => '1']);
        }

        if($this->filterPeriod) {
            $query->andWhere('UNIX_TIMESTAMP(task.publication_dt) > UNIX_TIMESTAMP() - :period', [':period' => $this->filterPeriod]);
        }

        return $query->orderBy('publication_dt DESC');
    }

}
