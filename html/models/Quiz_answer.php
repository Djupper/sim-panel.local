<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sm.quiz_answer".
 *
 * @property int $id
 * @property string|null $date_add
 * @property int|null $question_id
 * @property string|null $answer
 * @property int|null $quiz_basic_id
 */
class Quiz_answer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sm.quiz_answer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_add'], 'safe'],
            [['question_id', 'quiz_basic_id'], 'integer'],
            [['answer'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_add' => 'Date Add',
            'question_id' => 'Question ID',
            'answer' => 'Answer',
            'quiz_basic_id' => 'Quiz Basic ID',
        ];
    }


}
