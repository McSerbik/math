<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Gambler]].
 *
 * @see Gambler
 */
class GamblerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Gambler[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Gambler|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
