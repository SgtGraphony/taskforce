<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reply".
 *
 * @property int $id
 * @property int|null $task_id
 * @property int|null $client_id
 * @property int|null $performer_id
 * @property string|null $publication_dt
 * @property string|null $comment
 * @property int|null $budget
 *
 * @property User $client
 * @property User $performer
 * @property Task $task
 */
class Reply extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reply';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'client_id', 'performer_id', 'budget'], 'integer'],
            [['publication_dt'], 'safe'],
            [['task_id', 'client_id', 'performer_id', 'comment', 'budget'], 'required'],
            [['comment'], 'string'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['task_id' => 'id']],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['client_id' => 'id']],
            [['performer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['performer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'client_id' => 'Client ID',
            'performer_id' => 'Performer ID',
            'publication_dt' => 'Publication Dt',
            'comment' => 'Comment',
            'budget' => 'Budget',
        ];
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
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }

    /**
     * {@inheritdoc}
     * @return ReplyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReplyQuery(get_called_class());
    }

    public function taskReplies() {

        $query = self::find();
        $query->where(['task_id' => $this->task_id]);
        $query->join('INNER JOIN', 'users', 'reply.performer_id = user.id');

        return $query->orderBy('publication_dt DESC');

    }
}
