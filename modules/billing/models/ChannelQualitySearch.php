<?php

namespace app\modules\billing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\billing\models\ChannelQuality;
use yii\helpers\Url;

/**
 * ChannelQualitySearch represents the model behind the search form of `app\modules\billing\models\ChannelQuality`.
 */
class ChannelQualitySearch extends ChannelQuality
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name'], 'safe'],
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

    /**
     * @param int $page
     * @param string $sort
     * @param string $column
     * @param string $dataSearch
     * @return mixed
     */
    public function search_new( $page = 1,  $sort = 'none' , $column = '' , $dataSearch=''){
        $query = ChannelQuality::find();
        $columns = TableSettings::find()->where(['user_id' => Yii::$app->user->id, 'page'=>'/channel-quality'])->asArray()->one();
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

        if($dataSearch) {
            $filter_all =  explode(',' ,$dataSearch);
        }
        if(!empty($filter_all)){
            $total = ChannelQuality::find();
            for ($i = 0; $i < count($filter_all); $i++){
                $filter_simple =  explode('|',$filter_all[$i]);
                if($filter_simple[0]) {
                    $total->orWhere([$filter_simple[0]=>$filter_simple[1]]);
                    $query->orWhere([$filter_simple[0]=>$filter_simple[1]]);
                }
            }
            $total = $total->count();
        } else {
            $total = intval(ChannelQuality::find()->count());
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
                    $query->orderBy(['id' => SORT_DESC]);
                }
            } else {
                $query->orderBy(['id' => SORT_DESC]);
            }

        } else {
            $this->updateSortData($column, $sort);
            if($sort == 'ASC'){
                $query->orderBy([$column=>SORT_ASC]);
            } else if($sort == 'DESC') {
                $query->orderBy([$column=>SORT_DESC]);
            } else {
                $query->orderBy(['id' => SORT_DESC]);
            }
        }
        $table = $query->asArray()->all();

        return $this->makeTable($table, $columns, $page, $count_show, $total, $column, $sort, $pined);
    }

    /**
     * @param $column
     * @param $sort
     */
    public function updateSortData($column, $sort){
        $model = TableSettings::find()->where(['user_id'=>Yii::$app->user->id, 'page'=>'/channel-quality'])->one();
        if(!empty($model)){
            $model->sort_column = $column;
            $model->sort_type = $sort;
            $model->save();
        } else {
            $model = new TableSettings();
            $model->page = '/channel-quality';
            $model->sort_column = $column;
            $model->sort_type = $sort;
            $model->user_id = Yii::$app->user->id;
            $model->save();
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
    public function makeTable($table, $columns, $page, $count_show, $total, $column, $sort, $pined) {

        $columns_all = [];
        $columns_all_search = [];
        $l = 0;
        $searchMemory = SearchSettings::find()->where(['user_id' => Yii::$app->user->id, 'page' => '/channel-quality'])->all();
        $list = [];
        $arrTable['items_all'] = [];

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

                for ($k = 0; $k < count($col_search); $k++) {
                    $column_search = explode('-', $col_search[$k]);
                    if (isset($column_search[1])) {
                        $new_res = explode('|', $column_search[1]);
                        $stat = true;

                        if ($new_res[0] == 'false') {
                            $stat = false;
                        }

                        $arrTable['search'][$l]['items'][] = ['alias' => $column_search[0], 'name' => ChannelQuality::getAttributeLabel($column_search[0]), 'is_visible' => $stat, 'value' => intval($new_res[1])];
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
            if(!empty($columns['column_order'])){
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
            foreach ($table as $k => $tbl) {
                $i = 0;
                $arrTable['items_all'][] = $tbl;
                foreach ($keys as $ks => $v) {

                    $i++;
                    $type = 'text';
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
                            'name' => ChannelQuality::getAttributeLabel($v),
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
                                'name' => ChannelQuality::getAttributeLabel($v),
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
                                'name' => ChannelQuality::getAttributeLabel($v),
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
                        $arrTable['body'][$k]['items'][] = ['alias' => $v, 'class' => 'body_class', 'link' => '', 'value' => $tbl[$v], 'type' => $type, 'editable' => $editable];
//                        $tbl['internet_id'] = ;
//                        varDumper((object) $table);
                    }
                }
            }
            $arrTable['menu'][0] = [
                'value' => Yii::t('yii', 'View'),
                'data-url' => '',
                'confirm' => '',
                'method' => '',
                'class' => 'open_docs_view',
                'url' => Url::to(['channel-quality/view']),
                'form' => ''
            ];

            $arrTable['menu'][1] = [
                'value' => Yii::t('yii', 'Update'),
                'data-url' => '',
                'confirm' => '',
                'method' => '',
                'class' => 'open_docs_form',
                'url' => Url::to(['channel-quality/update'   ]),
                'form' => 'Редактировать'
            ];

            $arrTable['menu'][2] = [
                'value' => Yii::t('yii', 'Delete'),
                'data-url' => 'delete',
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post',
                'class' => 'open_docs_view',
                'url' => Url::to(['channel-quality/delete' ]),
                'form' => ''
            ];

            $arrTable['number'] = 'DESC';
            $arrTable['multiselect'] = false;
            $pages = ceil(intval($total)/$count_show);
            $arrTable['pagination'] = ['all_pages' => $total, 'pages' => $pages, 'current' => $page, 'count_by_page' => $count_show];
            $arrTable['option_data'] = [];
            $arrTable['search'] = array_reverse($arrTable['search']);

            return $arrTable;
        }
    }
}
