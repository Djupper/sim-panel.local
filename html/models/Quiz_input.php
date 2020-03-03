<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sm.quiz_input".
 *
 * @property int $id
 * @property string|null $ip
 * @property string|null $date_add
 * @property string|null $content
 * @property int|null $processed
 */
class Quiz_input extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sm.quiz_input';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_add'], 'safe'],
            [['content'], 'string'],
            [['processed'], 'integer'],
            [['ip'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
            'date_add' => 'Date Add',
            'content' => 'Content POST',
            'processed' => 'Processed',
        ];
    }

    public static function getNowDateTime()
    {
        $dateFile = new \DateTime();
        return $dateFile->format('Y-m-d H:i:s');
    }

    public static function getNowDate()
    {
        $dateFile = new \DateTime();
        return $dateFile->format('Y-m-d');
    }
}
