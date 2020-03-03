<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sm.quiz_question".
 *
 * @property int $id
 * @property string|null $question
 */
class Quiz_question extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sm.quiz_question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question' => 'Question',
        ];
    }
}
