<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sm.quiz_contact".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $phone
 * @property int|null $quiz_basic_id
 */
class Quiz_contact extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sm.quiz_contact';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quiz_basic_id'], 'integer'],
            [['name', 'email'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'quiz_basic_id' => 'Quiz Basic ID',
        ];
    }
}
