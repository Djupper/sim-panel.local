<?php

namespace app\models;

use app\controllers\BasicController;
use Yii;
use app\models\Basic;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $basic_key
 * @property string|null $lid_key
 * @property string|null $date_add
 * @property int|null $on_site_id
 * @property int|null $on_page_id
 * @property int|null $on_team_id
 * @property string|null $subcategory
 * @property string|null $phone_number
 * @property string|null $name
 * @property string|null $phone_rec
 * @property int|null $on_status_client_id
 * @property int|null $on_reason_id
 * @property int|null $on_rieltor_id
 * @property string|null $time_set
 * @property int|null $time_reaction
 * @property int|null $on_rieltor_status_id
 * @property string|null $message_id_ready
 * @property string|null $message_id_audio
 * @property string|null $notice
 * @property string|null $time_call_center
 * @property string|null $time_manager
 * @property int|null $city_id
 * @property int|null $on_number_line_id
 * @property int|null $on_partner_number_id
 * @property string|null $tab
 * @property string|null $rec
 * @property string|null $date_duble
 * @property int|null $partner_id
 * @property string|null $crc_summ
 * @property string|null $status_duble
 * @property string|null $info_from_client
 * @property int|null $lid_id
 */
class User extends Basic implements IdentityInterface
{

    const STATUS_WAIT = 0;
    const STATUS_BLOCKED = 5;
    const STATUS_ACTIVE = 10;


    public $rememberMe = true;  //запомнить и оставить валидацию на 30 дней

    /**
     * Возращает наименование базы данных указанное в конфигурации
     *
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_add', 'time_set'], 'safe'],
            [['on_site_id', 'on_page_id', 'on_team_id', 'on_status_client_id', 'on_reason_id', 'on_rieltor_id', 'time_reaction', 'on_rieltor_status_id', 'city_id', 'on_number_line_id', 'on_partner_number_id', 'partner_id', 'lid_id'], 'integer'],
            [['info_from_client'], 'string'],
            [['basic_key', 'lid_key', 'subcategory', 'phone_number', 'name', 'phone_rec', 'message_id_ready', 'message_id_audio', 'notice', 'time_call_center', 'time_manager', 'tab', 'rec', 'date_duble', 'crc_summ', 'status_duble'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            /*'id' => 'ID пользователя в ЛК',
            'basic_key' => 'Basic Key',
            'lid_key' => 'Lid Key',
            'date_add' => 'Date Add',
            'on_site_id' => 'On Site ID',
            'on_page_id' => 'On Page ID',
            'on_team_id' => 'On Team ID',
            'subcategory' => 'Subcategory',
            'phone_number' => 'Phone Number',
            'name' => 'Name',
            'phone_rec' => 'Phone Rec',
            'on_status_client_id' => 'On Status Client ID',
            'on_reason_id' => 'On Reason ID',
            'on_rieltor_id' => 'On Rieltor ID',
            'time_set' => 'Time Set',
            'time_reaction' => 'Time Reaction',
            'on_rieltor_status_id' => 'On Rieltor Status ID',
            'message_id_ready' => 'Message Id Ready',
            'message_id_audio' => 'Message Id Audio',
            'notice' => 'Notice',
            'time_call_center' => 'Time Call Center',
            'time_manager' => 'Time Manager',
            'city_id' => 'City ID',
            'on_number_line_id' => 'On Number Line ID',
            'on_partner_number_id' => 'On Partner Number ID',
            'tab' => 'Tab',
            'rec' => 'Rec',
            'date_duble' => 'Date Duble',
            'partner_id' => 'Partner ID',
            'crc_summ' => 'Crc Summ',
            'status_duble' => 'Status Duble',
            'info_from_client' => 'Info From Client',
            'lid_id' => 'Lid ID',*/

            'id' => 'ID пользователя в ЛК',
            'id_lis' => 'ID пользователя в ЛИС',
            'status' => 'Статус пользователя',
            'user_name' => 'Логин',
            'user_password' => 'Пароль',
            'user_email' => 'Email',
            'user_groupe_id'   =>'Группы пользователя',
            'auth_key'  =>  'Ключ системной аутентификации',
            'auth_key_first' => 'Первичный ключ авторизации',
            'auth_key_second' => 'Вторичный ключ авторизации',
            'user_f'=>'Фамилия',
            'user_i'=>'Имя',
            'user_o'=>'Отчество',
            'content'=>'Должность'

        ];
    }
//////////////////////////////////////////////////////////////////////////////
   public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusesArray(), $this->status);
    }

    /**
     * Статусы пользователей
     *
     * @return array
     */
    public static function getStatusesArray()
    {
        return [
            self::STATUS_BLOCKED => 'Заблокирован',
            self::STATUS_ACTIVE => 'Активен',
            self::STATUS_WAIT => 'Ожидает подтверждения',
        ];
    }

    /**
     * Поиск по имени пользователя
     *
     * @param $username
     * @return null|static
     */
    public static function findByUsername($user_name)
    {
        return static::findOne(['user_name' => $user_name, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Проверяем пароль
     *
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {
        if ($this->user_password == md5($password)) {
            return TRUE;
        } else {
            return FALSE;
        }
        //return Yii::$app->security->validatePassword($password, $this->user_password);
    }

    /**
     * Проверяем первичный ключ
     *
     * @param $key
     * @return bool
     */
    public function validateFirstKey($key)
    {
        if ($this->auth_key_first == $key) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Устанавливаем хэш пароля
     *
     * @param $user_password
     * @throws \yii\base\Exception
     */
    public function setUserPassword($user_password)
    {
        $this->user_password = md5($user_password);

    }

    /**
     * Ключ автоматический аутентификации
     *
     * @throws \yii\base\Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }


    /**
     * Находит экземпляр identity class используя ID пользователя
     *
     * @param int|string $id
     * @return void|IdentityInterface
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }


    /**
     * Этот метод находит экземпляр identity class, используя токен доступа
     *
     * @param mixed $token
     * @param null $type
     * @return void|IdentityInterface
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }


    /**
     * Возвращает ID пользователя
     *
     * @return int|mixed|string
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }


    /**
     * Внутренний ключ авторизации
     *
     * @return string
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }


    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Перед записью
     * Перегенерация ключа
     *
     * @param bool $insert
     * @return bool
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->generateAuthKey();
                if (empty($this->user_groupe_id)) {
                    $this->user_groupe_id = 10; //default
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Пользователь ожидает проверки
     *
     * @return bool
     */
    public static function testUserHold($user_id)
    {
        if (User::findOne(['id' => $user_id, 'status'=>User::STATUS_WAIT])) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Пользователь заблокирован
     *
     * @return bool
     */
    public static function testUserStop($user_id)
    {
        if (User::findOne(['id' => $user_id, 'status'=>User::STATUS_BLOCKED])) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Пользователь активен
     *
     * @return bool
     */
    public static function testUserActive($user_id)
    {
        if (User::findOne(['id' => $user_id, 'status'=>User::STATUS_ACTIVE])) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Удаляет первичный ключ
     */
    public function deleteAuthFirstKey()
    {
        $this->auth_key_first = '';
    }

    /**
     * Генерация первичного ключа авторизации
     *
     * @return string
     * @throws \yii\base\Exception
     */
    public static function generateAuthFirstKey()
    {
        return Yii::$app->security->generateRandomString(8);
    }

    /**
     * Получаем разименновыный массив груп пользователей
     *
     * @param bool $user_id
     * @return array|bool
     */
    public static function getGroupeUser($user_id=FALSE)
    {
        if ($user_id && $model = User::findOne($user_id)) {
            if ($model->user_groupe_id) {
                if (substr_count($model->user_groupe_id, ',') >= 1) {
                    $aGroups = explode(',', $model->user_groupe_id);
                } else {
                    $aGroups[] = $model->user_groupe_id;
                }
                return $aGroups;
            }
        }
        return FALSE;
    }


    /**
     * Возвращает ID пользователя по его ключу
     *
     * @param bool $key
     * @return bool|int
     */
    public static function getApiAuth($key=FALSE)
    {
        if ($key && !empty($key) && User::find()->where(['auth_key_second'=>$key])->exists()) {
            $model = User::findOne(['auth_key_second'=>$key]);
            return $model->id;
        }
        return FALSE;
    }

    /**
     * Получаем актуальную дату время
     *
     * @return string
     */
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

///////////////////////////////////////////////////////////////////////////////

}
