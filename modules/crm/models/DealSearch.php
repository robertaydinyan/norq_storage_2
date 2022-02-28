<?php

namespace app\modules\crm\models;

use app\modules\billing\models\SearchSettings;
use app\modules\billing\models\Services;
use app\modules\billing\models\Share;
use app\modules\billing\models\TableSettings;
use app\modules\billing\models\Tariff;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\crm\models\Deal;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * DealSearch represents the model behind the search form of `app\modules\crm\models\Deal`.
 */
class DealSearch extends Deal
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'create_at', 'update_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Deal::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'create_at' => $this->create_at,
            'update_at' => $this->update_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    /**
     * @param int $page
     * @param string $sort
     * @param string $column
     * @param string $dataSearch
     * @return mixed
     */
    public function search_new($url = '/crm/deal', $page = 1,  $sort = 'none', $column = '', $dataSearch = '', $start_deal = false, $contact_type = false, $payment_type = false) {
        $query = Deal::find();
        $query->where('crm_deal.id IN (
            SELECT MAX(id)
            FROM crm_deal
            GROUP BY name
        )');
        $columns = TableSettings::find()->where(['user_id' => Yii::$app->user->id, 'page'=>$url])->asArray()->one();
        if(!empty($columns['count_show'])){
            $count_show = intval($columns['count_show']);
        } else {
            $count_show = 5;
        }
        if(!empty($columns['pined'])){
            $pined = intval($columns['pined']);
        } else {
            $pined = 1;
        }


        $query->orderBy(['crm_deal.update_at' => SORT_DESC]);
        if($contact_type || $payment_type){
            $query->select("crm_deal.id,crm_deal.name,crm_deal.service_id,crm_deal.share_id,crm_deal.tariff_id,crm_deal.amount,crm_deal.contact_id,crm_deal.company_id,crm_deal.create_at,crm_deal.update_at,crm_deal.status_id");
        }
        if(!$payment_type) {
            if ($dataSearch) {
                $filter_all = explode(',', $dataSearch);
            }
            if (!empty($filter_all)) {
                $total = Deal::find();
                for ($i = 0; $i < count($filter_all); $i++) {
                    $filter_simple = explode('|', $filter_all[$i]);

                    if ($filter_simple[0]) {
                        if (in_array($filter_simple[0], ['create_at', 'update_at', 'finish_date'])) {
                            $total->orWhere(['like', $filter_simple[0], $filter_simple[1]]);
                            $query->orWhere(['like', $filter_simple[0], $filter_simple[1]]);
                        } else {
                            if (!$contact_type) {
                                $total->orWhere([$filter_simple[0] => $filter_simple[1]]);
                                $query->orWhere([$filter_simple[0] => $filter_simple[1]]);
                            } else {
                                $total->orWhere(['crm_deal.' . $filter_simple[0] => $filter_simple[1]]);
                                $query->orWhere(['crm_deal.' . $filter_simple[0] => $filter_simple[1]]);

                            }
                        }
                    }
                }
                $total->groupBy('crm_deal.name');
                $total = $total->count();
            } else {
                $total = intval(Deal::find()->groupBy('crm_deal.name')->count());
            }
        }
        if($start_deal){
            $query->andWhere(['start_deal'=>1]);
        }
        $offset = ($page - 1) * $count_show;
        $query->offset($offset)->limit($count_show);

        if($column == ''){
            if($columns['sort_column'] && $columns['sort_type']){
                $sort = $columns['sort_type'];
                $column = $columns['sort_column'];
                if($columns['sort_type'] == 'ASC'){
                    $query->orderBy([$columns['sort_column']=>SORT_ASC]);
                } else if($columns['sort_type'] == 'DESC'){
                    $query->orderBy([$columns['sort_column']=>SORT_DESC]);
                } else {
                    $query->orderBy(['crm_deal.id' => SORT_DESC]);
                }
            } else {
                $query->orderBy(['crm_deal.update_at' => SORT_DESC]);
            }

        } else {
            $this->updateSortData($column, $sort, $url);
            if($sort == 'ASC'){
                $query->orderBy([$column=>SORT_ASC]);
            } else if($sort == 'DESC') {
                $query->orderBy([$column=>SORT_DESC]);
            } else {
                $query->orderBy(['crm_deal.update_at' => SORT_DESC]);
            }
        }
//        varDumper($query->createCommand()->sql);
        if($payment_type){
            $table = Deal::getDealByContract(false, $page, $count_show, $sort, $column , $dataSearch );
            $total = intval($table['total']);
            $table = $table['data'];
        } else {
            if($contact_type){
//                $query->dealFinished()->asArray()->all();
                $table = $query->joinWith(['status status'])
                    ->onCondition(['status.status_type' => 2])
                    ->asArray()->all();
            } else {
                $table = $query->asArray()->all();
            }
        }


        return $this->makeTable($url, $table, $columns, $page, $count_show, $total, $column, $sort, $pined, $contact_type, $payment_type);
    }

    /**
     * @param $column
     * @param $sort
     */
    public function updateSortData($column, $sort, $url){
        $model = TableSettings::find()->where(['user_id'=>Yii::$app->user->id, 'page'=>$url])->one();
        if(!empty($model)){
            $model->sort_column = $column;
            $model->sort_type = $sort;
            $model->save();
        } else {
            $model = new TableSettings();
            $model->page = $url;
            $model->sort_column = $column;
            $model->sort_type = $sort;
            $model->user_id = Yii::$app->user->id;
            $model->save();
        }
    }
    public function cloneDeal(){
        $last_day = date('t', time());
        $today = date('d', time());
        if($last_day == $today){
            $deals = Deal::find()->all();
            if(!empty($deals)){
                foreach ($deals as $deal => $val){
                    $dealClone = new Deal();
                    $dealClone->attributes = $val->attributes;
                    $dealClone->start_deal = 0;
                    $dealClone->status_id = 77;
                    $dealClone->deal_type_id = 2;

                    if ($dealClone->save()) {
                        $fields = CrmFieldValue::find()->where(['column_id'=>$val->id])->all();
                        if (!empty($fields)) {
                            foreach ($fields as $field => $value) {
                                $Cfields = new CrmFieldValue();
                                $Cfields->attributes = $value->attributes;
                                $Cfields->column_id = $dealClone->id;
                                $Cfields->save();
                            }
                        }
                    }
                }
            }
        }

    }
    /**
     * @param $table
     * @param $columns
     * @param $page
     * @param $count_show
     * @param $total
     * @param $column
     * @param $sort
     * @param $pined
     * @return mixed
     */
    public function makeTable($url, $table, $columns, $page, $count_show, $total, $column, $sort, $pined, $contact_type, $payment_type) {


        $columns_all = [];
        $columns_all_search = [];
        $l = 0;
        $searchMemory = SearchSettings::find()->where(['user_id' => Yii::$app->user->id, 'page' => $url])->all();
        $list = [];

        if(!empty($searchMemory)) {
            foreach ($searchMemory as $search => $vals) {

                $arrTable['search'][$l]['id'] = intval($vals['id']);
                $arrTable['search'][$l]['name'] = $vals['name'];

                if ($pined != false && $vals['id'] == intval($pined)) {
                    $arrTable['search'][$l]['pinned'] = true;
                } else {
                    $arrTable['search'][$l]['pinned'] = false;
                }

                $col_search = explode(',', $vals['column_search']);
                if ($pined != false && $vals['id'] == intval($pined)) {
                    for ($k = 0; $k < count($col_search); $k++) {
                        $column_search = explode('-', $col_search[$k]);
                        if (isset($column_search[1])) {
                            $new_res = explode('|', $column_search[1]);
                            $stat = true;

                            if ($new_res[0] == 'false') {
                                $stat = false;
                            }

                            $arrTable['search'][$l]['items'][] = ['alias' => $column_search[0], 'name' => Deal::getAttributeLabel($column_search[0]), 'is_visible' => $stat, 'value' => intval($new_res[1])];
                        }
                    }
                }
                $l++;
            }
        }

        if(!empty($columns['column_status'])) {
            $columns_array = explode(',', $columns['column_status']);

            for($j = 0; $j < count($columns_array); $j++){
                $columns_ = explode('-', $columns_array[$j]);

                if(isset($columns_[1])) {
                    $columns_all[$columns_[0]] = $columns_[1];
                }
            }
        }

        if(!empty($columns['column_search'])) {
            $columns_array_search = explode(',', $columns['column_search']);

            for($k = 0; $k < count($columns_array_search); $k++){

                $columns_search = explode('-', $columns_array_search[$k]);
                if(isset($columns_search[1])) {
                    $columns_all_search[$columns_search[0]] = $columns_search[1];
                }
            }
        }

        if(!empty($table)) {
            if(!empty($columns['column_order'])) {
                $keys = explode(',', substr($columns['column_order'],0,-1));
            } else {
                $keys = array_keys($table[0]);
            }
            $arrTable['search'][$l]['id'] = 1;
            $arrTable['search'][$l]['name'] = Yii::t('app', 'Поиск по умолчанию');
            if($pined == false || $pined == 1) {
                $arrTable['search'][$l]['pinned'] = true;
            } else {
                $arrTable['search'][$l]['pinned'] = false;
            }

            foreach ($keys as $ks_ => $v_) {
                if(!empty($columns_all_search)) {
                    if($columns_all_search[$v_] == 'true') {
                        $visible = true;
                    } else {
                        $visible = false;
                    }
                } else {
                    $visible = true;
                }
                $arrTable['search'][$l]['items'][] = ['alias' => $v_, 'is_visible' => $visible];
            }
            $all_lists =  $this->getColumnItems();
            foreach ($table as $k => $tbl) {
                $i = 0;
                foreach ($keys as $ks => $v) {

                    $i++;
                    $type = $this->getType($v);
                    if($type == 'select'){
                        $list = $all_lists[$v];
                    }
                    if(!empty($columns_all)) {
                        if($columns_all[$v] == 'true') {
                            $visible = true;
                        } else {
                            $visible = false;
                        }
                    } else {
                        $visible = true;
                    }
                    $editable = true;
                    if($column == '') {
                        $arrTable['header'][$ks] = [
                            'align' => 'left',
                            'checked' => true,
                            'name' => Deal::getAttributeLabel($v),
                            'is_visible' => $visible,
                            'list' => $list,
                            'list_all' => $list,
                            'class' => 'new',
                            'draw' => $v,
                            'alias' => $v,
                            'type' => $type,
                            'width' => '110',
                            'width_unit' => 'px',
                            'sort' => 'NONE',
                            'editable' => $editable
                        ];
                    } else {
                        if($column != $v){
                            $arrTable['header'][$ks] = [
                                'align' => 'left',
                                'checked' => true,
                                'name' => Deal::getAttributeLabel($v),
                                'is_visible' => $visible,
                                'list' => $list,
                                'list_all' => $list,
                                'class'=>'new',
                                'draw' => $v,
                                'alias' => $v,
                                'type' => $type,
                                'width' => '110',
                                'width_unit' => 'px',
                                'sort' => 'NONE',
                                'editable' => $editable
                            ];
                        } else {
                            $arrTable['header'][$ks] = [
                                'align' => 'left',
                                'checked' => true,
                                'name' => Deal::getAttributeLabel($v),
                                'is_visible' => $visible,
                                'list' => $list,
                                'list_all' => $list,
                                'class'=>'new',
                                'draw' => $v,
                                'alias' => $v,
                                'type' => $type,
                                'width' => '110',
                                'width_unit' => 'px',
                                'sort' => strtoupper($sort),
                                'editable' => $editable
                            ];
                        }
                    }
                    if ($tbl[$v] || $tbl[$v] === 0) {

                        $arrTable['body'][$k]['id'] = $tbl['id'];
                        $arrTable['body'][$k]['order'] = $i;
                        $arrTable['body'][$k]['items'][] = ['alias' => $v, 'class' => 'body_class','list' => $list,'list_all' => $list, 'link' => '', 'value' => $tbl[$v], 'type' => $type, 'editable' => $editable];
                    }
                }
            }
            if($contact_type) {
                $arrTable['menu'][0] = [
                    'value' => Yii::t('yii', 'View'),
                    'data-url' => '',
                    'confirm' => '',
                    'method' => '',
                    'class' => 'open_docs_view',
                    'url' => Url::to(['client/view']),
                    'form' => Yii::t('yii', 'Сделки')
                ];
            } else if ($payment_type) {
                $arrTable['menu'][0] = [
                    'value' => Yii::t('yii', 'View'),
                    'data-url' => '',
                    'confirm' => '',
                    'method' => '',
                    'class' => 'open_docs_view',
                    'url' => Url::to(['payment/view']),
                    'form' => Yii::t('yii', 'Сделки')
                ];
            } else {
                $arrTable['menu'][0] = [
                    'value' => Yii::t('yii', 'View'),
                    'data-url' => '',
                    'confirm' => '',
                    'method' => '',
                    'class' => 'open_docs_view',
                    'url' => Url::to(['deal/view']),
                    'form' => Yii::t('yii', 'Сделки')
                ];
                $arrTable['menu'][1] = [
                    'value' => Yii::t('yii', 'Update'),
                    'data-url' => '',
                    'confirm' => '',
                    'method' => '',
                    'class' => 'open_docs_form',
                    'url' => Url::to(['deal/update']),
                    'form' => Yii::t('yii', 'Сделки')
                ];
                $arrTable['menu'][2] = [
                    'value' => Yii::t('yii', 'Delete'),
                    'data-url' => 'delete',
                    'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                    'class' => 'open_docs_view',
                    'url' => Url::to(['deal/delete']),
                    'form' => Yii::t('yii', 'Сделки')
                ];
            }

            $arrTable['number'] = 'DESC';
            $arrTable['multiselect'] = false;
            $pages = ceil(intval($total)/$count_show);
            $arrTable['pagination'] = ['all_pages' => $total, 'pages' => $pages, 'current' => $page, 'count_by_page' => $count_show];
            $arrTable['option_data'] = [];
            $arrTable['search'] = array_reverse($arrTable['search']);
            return $arrTable;
        }
    }
    public function getType($column){
        switch ($column){
            case 'id':
                return 'number';
            case 'debt':
                return 'number';
            case 'name':
                return 'text';
            case 'create_at':
                return 'date';
            case 'update_at':
                return 'date';
                case 'date_finish':
                return 'date';
            case 'status_id':
                return 'select';
            case 'contact_id':
                return 'select';
            case 'company_id':
                return 'select';
            case 'deal_type_id':
                return 'select';
            case 'share_id':
                return 'select';
            case 'service_id':
                return 'select';
            case 'tariff_id':
                return 'select';
            case 'ordering':
                return 'number';
                case 'amount':
                return 'number';
                case 'start_deal':
                return 'number';
            case 'work_price':
                return 'number';
            default:
                return 'text';

        }
    }
    public function getColumnItems(){
        $list = [];
        $list['status_id'] = CrmStatus::getListForSearch();
        $list['contact_id'] = Contact::getListForSearch();
        $list['company_id'] = Company::getListForSearch();
        $list['service_id'] = Services::getListForSearch();
        $list['deal_type_id'] = DealType::getListForSearch();
        $list['tariff_id'] = Tariff::getListForSearch();
        $list['share_id'] = Share::getListForSearch();

          return $list;

    }

}
