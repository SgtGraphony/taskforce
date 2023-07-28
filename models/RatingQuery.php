<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Rating]].
 *
 * @see Rating
 */
class RatingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Rating[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Rating|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
