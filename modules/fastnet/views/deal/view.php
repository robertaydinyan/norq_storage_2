<?php

use app\components\DailyPricing;
use app\components\Helper;
use app\models\User;
use app\modules\billing\models\DealPaymentLog;
use app\modules\billing\models\DisruptionOptions;
use app\modules\crm\models\Cashier;
use app\modules\fastnet\models\Deal;
use Carbon\Carbon;
use dmstr\helpers\Html;
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use yii\bootstrap4\Alert;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\widgets\ActiveForm;
use app\components\Pricing;

/* @var $deal app\modules\fastnet\models\Deal */

$this->registerJsFile('@web/js/modules/billing/payment.js', ['depends'=>'yii\web\JqueryAsset', 'position' => View::POS_END]);
$this->registerJsFile('@web/js/popover-price-preview.js', ['depends'=>'yii\web\JqueryAsset', 'position' => View::POS_END]);
$this->registerCss(".images.detail-img > :first-child { margin-left: 0 !important; } .images.detail-img > :last-child {margin-right: 0 !important; }");

$this->title = Yii::t('app', 'Գործարք։ ') . $deal->deal_number;

$this->registerCss('.select2-selection--single {
        height: 36px !important;;
    }
    #select2-vacation-type-container, #select2-reason-container {
        height: 36px;
    }
    .select2-selection__rendered {
        height: 36px !important;
    }
    #payment-pay {
        padding: 1.14rem 1rem;
    }
    .input-group > .form-control:not(:first-child), .input-group > .custom-select:not(:first-child) {
        border-top-left-radius: 0.25rem !important;
        border-bottom-left-radius: 0.25rem !important;
    }
    #set-payment-date-datetime {
        margin-bottom: 0;
    }
    #set-payment-date {
        padding: 1.14rem 0.75rem !important;
        font-size: 12px !important;
    }
    table:not(.table-condensed){
        width: 100%;
    }
    .vacation{
        padding: 10px;
    }
    table:not(.table-condensed):not(.datetimepicker table) td, table:not(.table-condensed):not(.datetimepicker table) tr, table:not(.table-condensed):not(.datetimepicker table) th {
        border: 1px dashed lightgray;
        border-collapse: separate;
        padding: 15px;
        border-spacing: 5px;
    }
    .datetimepicker.dropdown-menu {
        color: inherit !important;
    }
    .payment-log td,.payment-log tr,.payment-log th{
        border: 1px solid lightgray;
        border-collapse: separate;
        padding: 15px;
        font-size: 19px;
        border-spacing: 5px;
        text-align: right;
    }
    
    .input-group-text.kv-datetime-remove {
        
    }
    ');

if ($deal->isDaily()) {
    $pricing = new DailyPricing($deal);
} else {
    $pricing = new Pricing($deal);
}

$balance = $deal->status == Deal::CONTRACT_TERMINATION ? $pricing->virtualBalance(false) : $pricing->virtualBalance() - $pricing->currentMonthTotalPayed();
?>

<div class="deal-view mt-3">

    <input type="hidden" id="deal_number" value="<?= $deal->deal_number ?>">
    <input type="hidden" id="deal_id" value="<?= $deal->id ?>">

    <div class="col-sm-12 p-0">
        <!-- Danger message alert -->
        <?php if (Yii::$app->session->hasFlash('danger')) : ?>
            <?= Alert::widget([
                'options' => ['class' => 'alert-danger'],
                'body' => Yii::$app->session->getFlash('danger'),
                'closeButton' => false
            ]) ?>
        <?php endif; ?>

        <!-- Success message alert -->
        <?php if (Yii::$app->session->hasFlash('success')) : ?>
            <?= Alert::widget([
                'options' => ['class' => 'alert-success'],
                'body' => Yii::$app->session->getFlash('success'),
                'closeButton' => false
            ]) ?>
        <?php endif; ?>
    </div>

    <div class="col-sm-12 p-0">
        <div class="card card-body border-0 req-block">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row align-items-center">
                        <div class="col-sm-12 col-md-6">
                            <p class="head-title">Հաճախորդի մասին</p>
                        </div>

                        <div class="col-sm-12 col-md-6 text-right">
                            <?php if ($deal->crm_company_id && $deal->status == 1) : ?>
                                <button type="button" class="btn btn-danger mr-3 text-white" id="disable-company-service" data-url="<?= Url::toRoute(['disable-company-service']) ?>">
                                    <div class="d-flex align-items-center">
                                        <span class="spinner-border spinner-border-sm text-light mr-2" style="display: none" role="status" aria-hidden="true"></span>
                                        <?= Yii::t('app', 'Անջատել') ?>
                                    </div>
                                </button>
                            <?php endif; ?>

                            <a href="<?= Url::toRoute(['preview-agreement', 'id' => $deal->agreement->id]) ?>" target="_blank" class="btn btn-light <?= !$deal->agreement ? 'disabled' : '' ?>" data-toggle="tooltip" data-placement="top" title="Դիտել պայմանագիրը">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?= Url::toRoute(['download-agreement', 'id' => $deal->agreement->id]) ?>" class="btn btn-light <?= !$deal->agreement ? 'disabled' : '' ?>" data-toggle="tooltip" data-placement="top" title="Ներբեռնել պայմանագիրը">
                                <i class="fas fa-file-download"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Requisite -->
            <div class="module-service-form-card border-muted position-relative mt-3 p-0">
                <div class="row">
                    <?php

                    if(!empty($deal)) : ?>

                        <div class="col-sm-4 info-elements">
                            <div>
                                <?php if ($deal->isCompany()) : ?>
                                    <span class="label-req">Անվանում: <b><?= $deal->customer()->name; ?> </b></span>
                                <?php else: ?>
                                    <span class="label-req">Անուն Ազգանուն: <b><?= $deal->customer()->name . ' ' . $deal->customer()->surname; ?> </b></span>
                                <?php endif; ?>
                            </div>
                            <div>
                                <span class="label-req">ԱՆձնագրի համար: <b><?= !empty($deal->customer()->passport_number)? $deal->customer()->passport_number : '-' ?></b></span>
                            </div>

                        </div>
                        <div class="col-sm-4 ">
                            <div>
                                <span class="label-req">Երբ է տրվել: <b><?= !empty($deal->customer()->when_visible)? date('d-m-Y', strtotime($deal->customer()->when_visible)) : '-' ?></b></span>
                            </div>
                            <div>
                                <span class="label-req">Ուժի մեջ է: <b><?= !empty($deal->customer()->valid_until)? date('d-m-Y', strtotime($deal->customer()->valid_until)) : '-' ?></b></span>
                            </div>
                        </div>

                        <div class="col-sm-4 ">
                            <div>
                                <span class="label-req">Ում կողմից: <b><?= !empty($deal->customer()->visible_by)? $deal->customer()->visible_by : '-' ?></b></span>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <?php if (!$deal->isCompany()) : ?>
                                <div>
                                    <span class="label-req">Անձնագրի լուսանկար</span>
                                </div>

                                <div>
                                    <!-- Passport images -->
                                    <div class="images detail-img">

                                        <?php if (!empty($deal->passport())) : ?>
                                            <?php foreach ($deal->passport() as $passportImage) : ?>
                                                <div class="img" style="background-image: url(<?= '/contact_passport/'.$passportImage->image ?>)"></div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="<?= $deal->isCompany() ? 'col-12' : 'col-sm-12 col-md-6' ?>">
                            <div>
                                <span class="label-req">ID Քարտ</span>
                            </div>
                            <div>
                                <div class="images mb-0 detail-img">
                                    <?php if (!empty($deal->passport())) : ?>
                                        <?php foreach ($deal->passport() as $idCard) : ?>
                                            <div class="img" style="background-image: url(<?= '/company_documents/'.$idCard->image ?>)"></div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <!-- .end Requisite -->
        </div>
    </div>

    <div class="col-sm-12 p-0">
        <div class="card card-body border-0 req-block">

            <div class="module-service-form-card border-muted position-relative mt-3 p-0">

                <?php if(!empty($deal)) : ?>
                    <div class="row deal-blok">
                        <div class="deal-info-title d-flex align-items-center">
                            <?= $deal->deal_number; ?>
                            <span class="badge badge-success font-weight-light ml-3" style="color: white !important;">
                                <?= $deal->blacklist === Deal::BLACKLIST_BLACK ? Yii::t('app', 'Հաշվապահություն չէ') : Yii::t('app', 'Հաշվապահություն') ?>
                            </span>

                            <?php if ($deal->isDaily()) : ?>
                                <span class="badge badge-success font-weight-light font-weight-light ml-2" style="color: white !important;">
                                    <?= Yii::t('app', 'Ամսական') ?>
                                </span>

                                <!-- Show warning notice if contract finish date reached to one month or one week -->
                                <?php if (!empty($deal->contractEndingNotice()['text'])) : ?>
                                    <span class="payment-status ml-2"
                                          data-toggle="tooltip"
                                          data-placement="top"
                                          title="<?= $deal->contractEndingNotice()['text'] ?>"
                                          style="background-color: <?= $deal->contractEndingNotice()['color'] ?>"></span>
                                <?php endif; ?>

                            <?php endif; ?>
                        </div>
                        <table>
                            <tr>
                                <th>
                                    <?php if (!is_null($deal->tariff->tv_id) && !is_null($deal->tariff->inet_speed)) {
                                        echo 'Փաթեթ';
                                    } else if (is_null($deal->tariff->tv_id)) {
                                        echo 'Ծառայություն';
                                    } else {
                                        echo 'Հեռուստատեսություն';
                                    } ?>
                                </th>
                                <th>Ամսվա վճար - (<?= date('m-Y') ?>)</th>
                                <th>Ծառայության վճար</th>
                                <th>IP Գումար</th>
                                <th>Միացման գումար</th>
                                <th>Հոսանքի վճար</th>
                                <th>Զեղչ</th>
                                <th>Հասցե</th>
                                <th>Միացման Օր</th>
                                <?php if ($deal->isDaily()) : ?>
                                    <th>Անջատման ամս․</th>
                                <?php endif; ?>
                            </tr>
                            <tr>
                                <td><?= !empty($deal->connect_id)? $deal->tariff->name : '-'; ?></td>
                                <td><?= $deal->isTermination() ? 'Խզված է' : $pricing->virtualBalance() . ' AMD' ?> </td>
                                <td><?= $pricing->totalDealAmount(false) ?> AMD</td>
                                <td><?= $pricing->sumIPPrice()?> </td>
                                <td><?= Helper::removeUselessZeroDigits($deal->connect_price) ?> </td>
                                <td><?= $deal->electricity ? Helper::removeUselessZeroDigits($deal->electricity) . ' AMD' : '-' ?> </td>
                                <td><?= $deal->discount ? Helper::removeUselessZeroDigits($deal->discount) . ' AMD' : '-' ?></td>
                                <td>
                                    <?= $deal->formatedAddress() ?>
                                </td>
                                <td><?= Carbon::parse($deal->start_day)->format('d-m-Y') ?> </td>
                                <?php if ($deal->isDaily()) : ?>
                                    <td>
                                        <?= Carbon::parse($deal->daily_month_end)->format('d-m-Y') ?>  <?= $deal->month ? '/ ('.$deal->month.')' : '' ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                            <tr>
                                <td colspan="1">
                                    <div class="d-flex flex-column">
                                        <div>
                                            <b><?= Yii::t('app', 'Բալանս') ?></b>
                                            <input type="hidden" name="total_paid" value="<?= $balance ?>">

                                            <span class="payment-status mr-3" data-paid="<?= $balance ?>" style="background-color: <?= $deal->status() ?>" title="<?=Helper::getPaidColor($balance)['text']?>"></span>
                                            <span class="payment-price" data-paid="<?= $balance ?>" ><?= round($balance) ?></span>
                                        </div>
                                        <div>
                                            <div class="popover-block-container mt-3">
                                                <div tabindex="0" type="button" class="popover-icon html-popover" data-url="<?= Url::to(['deal/get-total-price']) ?>" data-id="<?= $deal->id ?>" data-popover-content="#price-list-popover" data-toggle="popover" data-placement="right">
                                                    Ընդհանուր
                                                </div>
                                                <div id="price-list-popover" style="display:none;">
                                                    <div class="popover-body">
                                                        <div class="popover-close close"><i class="far fa-times"></i></div>

                                                        <ul class="list-group">
                                                            <li class="list-group-item">
                                                                <span class="font-weight-bolder mr-3">Ծառայության արժեք։</span>
                                                                <span class="ml-auto popover-service-price"></span>
                                                            </li>
                                                            <li class="list-group-item item-penalty">
                                                                <span class="font-weight-bolder">Տուգանք։</span>
                                                                <span class="ml-auto popover-penalty-price"></span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="font-weight-bolder">Ընդհանուր։</span>
                                                                <span class="ml-auto popover-total-price"></span>
                                                            </li>

                                                            <?php if ($deal->contract_end) : ?>
                                                                <li class="list-group-item border-top mt-3 pt-3">
                                                                    <span class="font-weight-bolder">
                                                                        <?= Yii::t('app', 'Պայմանագրի ավարտ') ?>
                                                                    </span>
                                                                    <span class="ml-auto contract-ending-date"></span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <span class="font-weight-bolder"><?= Yii::t('app', 'Մնացել է') ?></span>
                                                                    <span class="ml-auto"><span class="remaining-date"></span> <?= Yii::t('app', 'օր') ?></span>
                                                                </li>
                                                            <?php endif; ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td colspan="7">
                                    <?php if ($deal->status != Deal::CONTRACT_TERMINATION) : ?>
                                        <div class="row align-items-center">
                                            <?php if (Yii::$app->user->identity->isCashier() || Yii::$app->user->identity->isAdmin()) : ?>
                                                <div class="col-sm-2">
                                                    <div class="sk-floating-label form-group mb-0">
                                                        <input type="number" class="form-control bg-white" id="payment-pay"
                                                               data-deal-id="<?= $last_id ?>" data-url="<?= \yii\helpers\Url::to(['/fastnet/deal/pay']) ?>">
                                                        <label for="payment-pay"><?= Yii::t('app', 'Գումար') ?></label>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="col-12">
                                                    <?= Alert::widget([
                                                        'options' => ['class' => 'alert-danger mb-0 py-1 px-2'],
                                                        'body' => Yii::t('app', 'Դուք չեք կարող կատարել վճարում քանի որ կցված չեք որևէ դրամարկղում'),
                                                        'closeButton' => false
                                                    ]) ?>
                                                </div>
                                            <?php endif; ?>

                                            <?php if (Yii::$app->user->identity->isAdmin()) : ?>
                                                <div class="col-sm-3">
                                                    <div class="sk-floating-label">
                                                        <?= Select2::widget([
                                                            'name' => 'responsible_id',
                                                            'data' => ArrayHelper::map(Cashier::find()->active()->all(), 'id', 'name'),
                                                            'theme' => Select2::THEME_KRAJEE,
                                                            'options' => [
                                                                'placeholder' => Yii::t('app', 'Ընտրել գանձապահ'),
                                                                'id' => 'responsible_id',
                                                                'multiple'=>false,
                                                            ],
                                                            'pluginOptions' => [
                                                                'allowClear' => true,
                                                            ],
                                                        ]); ?>
                                                        <label for="">Գանձապահ</label>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <input type="hidden" name="responsible_id" id="responsible_id" value="<?= Yii::$app->user->identity->cashierOperator->cashier_id ?>">
                                            <?php endif; ?>

                                            <?php if (Yii::$app->user->can('setPaymentDate') || Yii::$app->user->identity->isAdmin()) : ?>
                                                <div class="col-sm-3">
                                                    <?= DateTimePicker::widget([
                                                        'name' => 'set_payment_date',
                                                        'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,
                                                        'options' => [
                                                            'id' => 'set-payment-date',
                                                            'placeholder' => 'Նշել վճարման ամս․'
                                                        ],
                                                        'convertFormat' => true,
                                                        'pluginOptions' => [
                                                            'todayHighlight' => true,
                                                            'todayBtn' => true,
                                                            'format' => 'dd-MM-yyyy H:i',
                                                            'autoclose' => true,
                                                        ]
                                                    ]); ?>
                                                </div>
                                            <?php endif; ?>

                                            <?php if (Yii::$app->user->identity->isCashier() || Yii::$app->user->identity->isAdmin()) : ?>
                                                <div class="col-sm-1">
                                                    <button type="button" class="btn btn-primary add-payment d-flex align-items-center text-white">
                                                        <span class="spinner-border spinner-border-sm text-light mr-2" style="display: none" role="status" aria-hidden="true"></span>
                                                        <?= Yii::t('app', 'Վճարել') ?>
                                                    </button>
                                                </div>

                                                <?php if (Yii::$app->user->can('sendToPrintCashRegisterReceipt')) : ?>
                                                    <div class="col-md-3 text-right">
                                                        <div class="c-checkbox mt-1">
                                                            <input type="checkbox" id="deal-hdm" class="form-control" name="Deal[hdm]">
                                                            <label class="has-star mb-0" for="deal-hdm"><?= Yii::t('app', 'ՀԴՄ') ?></label>
                                                            <div class="help-block invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <!-- Vacation -->
    <?php if ($deal->balance && $deal->status != Deal::CONTRACT_TERMINATION && $deal->isNotDaily()) : ?>
        <div class="col-sm-12 p-0">
            <div class="card card-body border-0 req-block">
                <p class="head-title"><?= Yii::t('app', 'Արձակուրդ') ?>
                    <?php if (!empty($deal->contract_end) && date('Y-m-d') < date('Y-m-d', strtotime($deal->contract_end))) : ?>
                        <span class="text-muted lead">(<?= Yii::t('app', 'Պայմանագիր ունի') ?>)</span>
                    <?php endif; ?>
                </p>
                <?php $form = ActiveForm::begin(); ?>

                <?php if (!$deal->vacation->isNewRecord) : ?>
                    <input type="hidden" id="vacation_id" value="<?= $deal->vacation->id ?>">
                    <input type="hidden" id="old_date_end" value="<?=date('d-m-Y', strtotime($deal->vacation->data_end))?>">
                <?php endif; ?>
                <?php if($deal->status == 1 || $deal->status == 2): ?>
                <div class="row vacation">

                    <!-- Vacation start date field -->
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="crmdealvacation-data_start"><?= Yii::t('app', 'Սկիզբ') ?></label>
                            <?= DatePicker::widget([
                                'name' => '',
                                'type' => DatePicker::TYPE_INPUT,
                                'value' => $deal->vacation->data_start ? date('d-m-Y', strtotime($deal->vacation->data_start)) : '',
                                'options' => [
                                    'id' => 'crmdealvacation-data_start',
                                    'disabled' => $deal->vacation->data_start ? true : false
                                ],
                                'pluginOptions' => [
                                    'startDate' => date('d-m-Y'),
                                    'autoclose' => true,
                                    'format' => 'dd-mm-yyyy'
                                ]
                            ]); ?>
                        </div>
                    </div>

                    <!-- Vacation end date field -->
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="crmdealvacation-data_end"><?= Yii::t('app', 'Ավարտ') ?></label>
                            <?= DatePicker::widget([
                                'name' => '',
                                'type' => DatePicker::TYPE_INPUT,
                                'value' => $deal->vacation->data_end ? date('d-m-Y', strtotime($deal->vacation->data_end)) : '',
                                'options' => [
                                    'id' => 'crmdealvacation-data_end'
                                ],
                                'pluginOptions' => [
                                    'startDate' => date('d-m-Y', strtotime($deal->vacation->data_start)),
                                    'autoclose' => true,
                                    'format' => 'dd-mm-yyyy'
                                ]
                            ]); ?>
                        </div>
                    </div>

                    <!-- Vacation types select -->
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="vacation-type"><?= Yii::t('app', 'Արձակուրդի տարբերակներ') ?></label>
                            <?= Select2::widget([
                                'name' => 'vacation_type',
                                'value' => $deal->vacation->vacation_type_id,
                                'data' => ArrayHelper::map($vacationTypes, 'id', 'name'),
                                'theme' => Select2::THEME_KRAJEE,
                                'options' => [
                                    'placeholder' => Yii::t('app', 'Ընտրել տարբերակ'),
                                    'id' => 'vacation-type',
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ],
                            ]); ?>
                        </div>
                    </div>

                    <!-- Vacation reason -->
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="comment"><?= Yii::t('app', 'Պատճառը') ?></label>
                            <textarea id="comment" class="form-control" cols="30" rows="4"><?= !empty($deal->vacation->comment) ? $deal->vacation->comment : null ?></textarea>
                        </div>
                    </div>

                    <!-- Save Vacation button -->
                    <div class="col-sm-12 text-right">
                        <div class="form-group">
                            <button type="button" class="btn addVacation btn-success text-white" data-url="<?= Url::to(['deal/add-vacation']); ?>"><?= !$deal->vacation ? Yii::t('app', 'Ավելացնել') : Yii::t('app', 'Թարմացնել') ?></button>
                        </div>
                    </div>

                    <?php if ($deal->vacation) : ?>
                        <div class="col-sm-12 p-0">
                            <div class="card card-body border-0 req-block">

                                <div class="module-service-form-card border-muted position-relative mt-3 p-0">

                                    <div class="row ">
                                        <table>
                                            <tbody>
                                            <tr>
                                                <td><b>Սկիզբ</b></td>
                                                <td><?= date('d-m-Y',strtotime($deal->vacation->data_start)) ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Ավարտ</b></td>
                                                <td><?=date('d-m-Y',strtotime($deal->vacation->data_end))?></td>
                                            </tr>
                                            <?php
                                            $vacation_price  = new Helper();
                                            $leftPrice = $pricing->vacationPrice();
                                            ?>
                                            <tr style="border-bottom: 1px dashed #ccc;">
                                                <td><b>Տևողություն</b></td>
                                                <td><?= (intval($leftPrice['totalDay'])+1); ?> օր</td>
                                            </tr>
                                            <tr style="border-bottom: 1px dashed #ccc;">
                                                <td><b>Մնացել է</b></td>
                                                <td><?= $vacation_price->holidayDays($deal->vacation->data_end); ?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <div class="clearfix"></div>
                                        <br>
                                        <div class="p-2">
                                            <button type="button" data-url="<?= Url::to(['deal/end-vacation']); ?>" class="btn btn-info" id="end_vc">Ավարտ</button>
                                        </div>
                                        <div class="clearfix"></div>
                                        <br>
                                        <div class="col-sm-12 p-3">
                                            <div class="card border-0 req-block">
                                                <!-- CRM timeline -->
                                                <div class="crm-entity-stream-container">
                                                    <div class="crm-entity-stream-container-content ajax-payment-result">
                                                        <?php if(!empty($leftPrice) && !empty($leftPrice['currentBalanceWithMonth'])) {

                                                            foreach ($leftPrice['currentBalanceWithMonth'] as $key => $val) { ?>
                                                                <div>
                                                                    <div class="crm-entity-stream-section crm-entity-stream-section-history-label">
                                                                        <div class="crm-entity-stream-section-content">
                                                                            <div class="crm-entity-stream-history-label bg-primary" style="color:white !important;">
                                                                                <?php echo $key;?>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="crm-entity-stream-section crm-entity-stream-section-history crm-entity-stream-section-createEntity ">
                                                                        <div class="crm-entity-stream-section-icon crm-entity-stream-section-icon-info bg-primary"></div>

                                                                        <div class="crm-entity-stream-section-content">
                                                                            <div class="crm-entity-stream-content-event">
                                                                                <div class="crm-entity-stream-content-detail">

                                                                                    <div class="d-flex align-items-center">
                                                                                        <p class="crm-entity-stream-content-detail-info-status">
                                                                                            <i class="far fa-clock"></i> <?php echo $key;?>                                                       </p>
                                                                                        <span class="crm-entity-stream-content-detail-info-separator-icon"></span>
                                                                                        <p class="crm-entity-stream-content-detail-info-status">
                                                                                            <?php echo number_format($val, 2, '.', ',');?> AMD
                                                                                        </p>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php }
                                                        } ?>

                                                    </div>
                                                </div>
                                                <!-- .end CRM timeline -->
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>


            <?php ActiveForm::end(); ?>
        </div>
    <?php endif; ?>
    <!-- .end Vacation -->

    <!-- Contract termination block -->
    <div class="col-sm-12 p-0">
        <div class="card card-body border-0 req-block">
            <p class="head-title"><?= Yii::t('app', 'Պայմանագրի խզում') ?></p>

            <?php if($deal->status !==3) : ?>
                <div class="row align-items-center">
                    <div class="col-sm-1">
                        <div class="c-checkbox">
                            <input type="checkbox" value="1" id="cancel" class="form-control" name="cancel_deal">
                            <label class="has-star mb-0" for="cancel"><?= Yii::t('app', 'խզում') ?></label>
                            <div class="help-block invalid-feedback"></div>
                        </div>
                    </div>

                    <?php if ($deal->penalty) : ?>
                        <div class="col-sm-3 hide show_any">
                            <span class="mr-2"><?= Yii::t('app', 'Տուգանք') ?>՝</span> <?= $deal->penalty ?> AMD
                        </div>
                    <?php endif; ?>

                    <div class="col-sm-3 hide">

                        <?= Select2::widget([
                            'name' => 'reason',
                            'data' => ArrayHelper::map($reasons, 'id', 'name'),
                            'theme' => Select2::THEME_KRAJEE,
                            'options' => [
                                'placeholder' => Yii::t('app', 'Ընտրել պատճառը'),
                                'id' => 'reason',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ]); ?>
                    </div>
                    <div class="col-sm-3 hide">
                        <textarea name="reason_text" rows="1" class="form-control reason_text" placeholder="Պատճառը"></textarea>
                    </div>
                    <div class="col-sm-2 hide">
                        <button class="btn btn-danger cancel_btn d-flex align-items-center text-white" type="button" id="disruption" data-url="<?php echo Url::to(['deal/add-disruption']);?>">
                            <span class="spinner-border spinner-border-sm text-light mr-2" style="display: none" role="status" aria-hidden="true"></span>
                            Խզել
                        </button>
                    </div>
                </div>
            <?php else : ?>
                <p>Պայմանագիրը խզված է</p>
                <p>Պատճառը՝ <?php if(!$disruption->reason_id){ echo $disruption->reason_text;} else { echo $disruption->reasonName; }?></p>
            <?php endif; ?>
        </div>
    </div>
    <!-- .end Contract termination block -->

    <?php if ($deal->isNotDaily()) : ?>
        <div class="col-sm-12 p-0">
            <div class="card card-body border-0 req-block">

                <p class="head-title"><?= Yii::t('app', 'Պատմություն') ?></p>
                <!-- stex petk e lini date-->

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for=""><?= Yii::t('app', 'Սկիզբ') ?></label>
                            <?php echo DatePicker::widget([
                                'name' => 'date_range',
                                'attribute2' => 'to_date',
                                'options' => [
                                    'autocomplete' => 'off',
                                    'id' => 'filter-payment-log'
                                ],
                                'type' => DatePicker::TYPE_RANGE,
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'startView' => 'year',
                                    'minViewMode' => 'months',
                                    'format' => 'mm-yyyy'
                                ]
                            ]); ?>
                        </div>
                    </div>
                </div>

                <div class="payment-log history_log mb-5">
                    <?= $html_history ?>
                </div>

            </div>
        </div>
    <?php endif; ?>
</div>

