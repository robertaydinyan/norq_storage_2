<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Cron;
use app\modules\warehouse\controllers\CurrencyController;
use app\modules\warehouse\models\Currency;
use fedemotta\cronjob\models\CronJob;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CronController extends Controller
{
    public function actionIndex(){

        $command = CronJob::run($this->id, $this->action->id, 0, 0);
        if ($command === false){
            return Controller::EXIT_CODE_ERROR;
        }else{
            Currency::updateCurrenciesValues();
            sleep(24 * 60 * 60);

            $command->finish();
            return Controller::EXIT_CODE_NORMAL;
        }
    }
}
