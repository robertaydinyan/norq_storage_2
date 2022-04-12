<?php

namespace app\modules\warehouse\models;

use SoapClient;
use Yii;

/**
 * This is the model class for table "currency".
 *
 * @property int $id
 * @property string $symbol
 * @property string $code
 * @property double $value
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['symbol'], 'required'],
            [['symbol', 'code'], 'string', 'max' => 3],
            [['value'], 'double'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'symbol' => Yii::t('app', 'Symbol'),
            'code' => Yii::t('app', 'Code'),
        ];
    }

    public static function getCurrencyByID($id) {
        return Currency::find()->where(['id' => $id])->one();
    }

    public static function updateCurrenciesValues() {
        $currencies = Currency::find()->all();
        $values = Currency::loadCurrencyConverterXML();
        foreach ($currencies as $c) {
            if ($c->code != 'AMD') {
                $c->value = floatval($values[$c->code]);
                $c->save();
            }
        }
    }

    private static function loadCurrencyConverterXML() {
        $opts = ['ssl' => ['ciphers' => 'RC4-SHA', 'verify_peer' => false, 'verify_peer_name' => false]];
        // SOAP 1.2 client
        $params = ['encoding' => 'UTF-8', 'verifypeer' => false, 'verifyhost' => false, 'soap_version' => SOAP_1_2, 'trace' => 1, 'exceptions' => 1, "connection_timeout" => 180, 'stream_context' => stream_context_create($opts) ];

        $serverURL = 'http://api.cba.am/exchangerates.asmx?wsdl';

        try {
            $client = new SoapClient($serverURL, $params);
            $client->__soapCall('ExchangeRatesLatest', []);

        }
        catch(\SoapFault $e) {
            echo "Failed to connect: " . $e->getMessage();
        }

        $xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", '$1$2$3', $client->__last_response);
        $xml = simplexml_load_string($xml);
        $json = json_encode($xml);
        $cr = json_decode($json, true);

        $currentCurrency = $cr['soapBody']['ExchangeRatesLatestResponse']['ExchangeRatesLatestResult']['Rates']['ExchangeRate'];

        # Build currency array
        $arCurrency = [];
        foreach ($currentCurrency as $selectedCurrency) {
            $arCurrency[$selectedCurrency['ISO']] = $selectedCurrency['Rate'];
        }
        return $arCurrency;
    }

    public static function fromDram($n): string {
        $currencies = Currency::find()->all();
        $res = '';
        foreach ($currencies as $c) {
            $res .= number_format($n / $c->value, '0', '.', ',') . $c->symbol . '
';
        }

        return $res;
    }
}
