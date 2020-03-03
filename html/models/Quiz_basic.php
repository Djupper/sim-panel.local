<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sm.quiz_basic".
 *
 * @property int $id
 * @property string|null $date_add
 * @property int|null $quiz_input_id
 * @property string|null $created
 * @property string|null $name
 * @property string|null $uid
 * @property string|null $result
 */
class Quiz_basic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sm.quiz_basic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_add'], 'safe'],
            [['quiz_input_id'], 'integer'],
            [['result'], 'string'],
            [['created'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 500],
            [['uid'], 'string', 'max' => 300],
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
            'quiz_input_id' => 'Quiz Input ID',
            'created' => 'Created',
            'name' => 'Name',
            'uid' => 'Uid',
            'result' => 'Result',
        ];
    }
}
