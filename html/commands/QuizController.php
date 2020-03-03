<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Quiz_answer;
use app\models\Quiz_basic;
use app\models\Quiz_contact;
use app\models\Quiz_extra;
use app\models\Quiz_input;
use app\models\Quiz_question;
use yii\console\Controller;
use yii\console\ExitCode;

class QuizController extends Controller
{
    public $model_quiz;
    public $quiz;


    public function actionRun($id=FALSE)
    {

        if (!$id && Quiz_input::find()->where(['processed'=>0])->exists()) {
            $models = Quiz_input::find()->where(['processed'=>0])->all();
        }

        if ($id && Quiz_input::find()->where(['id'=>$id])->exists()) {
            $models = Quiz_input::find()->where(['id'=>$id])->all();
        }

        if (isset($models) && $models) foreach ($models as $model) {
            $this->quiz['quiz_input_id'] = $model->id;
            $this->model_quiz = json_decode($model->content,TRUE);

            $this->pr_basic();
            $this->pr_contact();
            $this->pr_extra();
            $this->pr_question();
            $this->pr_answer();
            $model->processed = 1;
            $model->save();
        }
    }


    /**
     * Quiz_basiz
     */
    public function pr_basic() {
        if ($this->model_quiz) {
            if ($this->quiz['quiz_input_id'] && Quiz_basic::find()->where(['quiz_input_id'=>$this->quiz['quiz_input_id']])->exists()) {
                $model = Quiz_basic::findOne(['quiz_input_id'=>$this->quiz['quiz_input_id']]);
            } else {
                $model = new Quiz_basic();
                $model->date_add = self::getNowDateTime();
            }
            $model->created = print_r($this->model_quiz['created'],TRUE);
            $model->result =  print_r($this->model_quiz['result'],TRUE);
            $model->quiz_input_id = $this->quiz['quiz_input_id'];

            $model->name = (isset($this->model_quiz['quiz']) && isset($this->model_quiz['quiz']['name'])) ? $this->model_quiz['quiz']['name'] : '';
            $model->uid = (isset($this->model_quiz['quiz']) && isset($this->model_quiz['quiz']['id'])) ? $this->model_quiz['quiz']['id'] : '';

            $model->save();
            $this->quiz['quiz_basic_id'] = $model->id;
            unset ($model);
        }
    }

    /**
     * Quiz_contact
     */
    public function pr_contact() {
        if ($this->model_quiz && $this->quiz['quiz_basic_id']) {
            $model = new Quiz_contact();
            $model->name = (isset($this->model_quiz['contacts']) && isset($this->model_quiz['contacts']['name'])) ? $this->model_quiz['contacts']['name'] : '';
            $model->email = (isset($this->model_quiz['contacts']) && isset($this->model_quiz['contacts']['email'])) ? $this->model_quiz['contacts']['email'] : '';
            $model->phone = (isset($this->model_quiz['contacts']) && isset($this->model_quiz['contacts']['phone'])) ? $this->model_quiz['contacts']['phone'] : '';
            $model->quiz_basic_id = $this->quiz['quiz_basic_id'];
            $model->save();
            unset($model);
        }
    }

    /**
     * Quiz_extra
     */
    public function pr_extra() {
        if ($this->model_quiz) {
            $model = new Quiz_extra();
            $model->href = (isset($this->model_quiz['extra']) && isset($this->model_quiz['extra']['href'])) ? $this->model_quiz['extra']['href'] : '';
            $model->notify = (isset($this->model_quiz['extra']) && isset($this->model_quiz['extra']['notify'])) ? $this->model_quiz['extra']['notify'] : '';
            $model->ip = (isset($this->model_quiz['extra']) && isset($this->model_quiz['extra']['ip'])) ? $this->model_quiz['extra']['ip'] : '';
            $model->utm = (isset($this->model_quiz['extra']) && isset($this->model_quiz['extra']['utm'])) ? print_r($this->model_quiz['extra']['utm'],TRUE) : '';
            $model->utm = (isset($this->model_quiz['extra']) && isset($this->model_quiz['extra']['cookies']) && isset($this->model_quiz['extra']['cookies']['_ga']) ) ? $this->model_quiz['extra']['cookies']['_ga'] : '';
            $model->quiz_basic_id = $this->quiz['quiz_basic_id'];
            $model->save();
            unset($model);
        }
    }

    /**
     * Quiz_question
     */
    public function pr_question() {
        if ($this->model_quiz) {
            if (isset($this->model_quiz['raw']) && is_array($this->model_quiz['raw'])) {
                foreach ($this->model_quiz['raw'] as $raw) {
                    if (trim($raw['q']) && !Quiz_question::find()->where(['question'=>trim($raw['q'])])->exists()) {
                        $model = new Quiz_question();
                        $model->question = trim($raw['q']);
                        $model->save();
                        unset($model);
                    }
                }
            }
        }
    }

    public function pr_answer() {
        if ($this->model_quiz) {
            if (isset($this->model_quiz['raw']) && is_array($this->model_quiz['raw'])) {
                foreach ($this->model_quiz['raw'] as $raw) {
                    $q_id = Quiz_question::findOne(['question'=>trim($raw['q'])]);
                    $model = new Quiz_answer();
                    $model->date_add = self::getNowDateTime();
                    $model->question_id = $q_id->id;
                    $model->answer = $raw['a'];
                    $model->quiz_basic_id = $this->quiz['quiz_basic_id'];
                    $model->save();
                    unset($model);
                }
            }
        }
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
