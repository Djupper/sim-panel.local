<?php

namespace app\models;

use app\models\user\User;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;
use Yii;

class Basic extends ActiveRecord
{

    /**
     * Сессия
     *
     * @var
     */
    public $session;


    /**
     * Первичная инициализация для всех моделей
     */
    public function init()
    {
        if (isset(Yii::$app->session)   ) {
            $this->session = Yii::$app->session;
            if (!$this->session->isActive) {
                $this->session->open();
            }
        }
    }
}