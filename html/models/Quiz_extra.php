<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sm.quiz_extra".
 *
 * @property int $id
 * @property string|null $href
 * @property string|null $utm
 * @property string|null $notify
 * @property string|null $cookies
 * @property string|null $ip
 * @property int|null $quiz_basic_id
 */
class Quiz_extra extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sm.quiz_extra';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quiz_basic_id'], 'integer'],
            [['href', 'utm', 'notify', 'cookies', 'ip'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'href' => 'Href',
            'utm' => 'Utm',
            'notify' => 'Notify',
            'cookies' => 'Cookies',
            'ip' => 'Ip',
            'quiz_basic_id' => 'Quiz Basic ID',
        ];
    }
}
