<?php

namespace app\modules\warehouse\controllers;

use app\components\Url;
use app\models\User;
use app\modules\billing\models\Regions;
use app\modules\warehouse\models\Favorite;
use app\modules\warehouse\models\Product;
use app\modules\warehouse\models\ShippingType;
use app\modules\warehouse\models\Warehouse;
use app\modules\warehouse\models\WarehouseGroups;
use app\modules\warehouse\models\WarehouseTypes;
use app\rbac\WarehouseRule;
use Yii;

use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * QtyTypeController implements the CRUD actions for QtyType model.
 */
class ReportsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all QtyType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        $shipping_types=  ShippingType::find()->all();
        $warehouse_types = ArrayHelper::map(WarehouseTypes::find()->asArray()->all(), 'id', 'name');
//        $regions = ArrayHelper::map(Regions::find()->asArray()->all(), 'id', 'name');
        $groups = ArrayHelper::map(WarehouseGroups::find()->asArray()->all(), 'id', 'name');
        $uersData = ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE])->all(), 'id', 'name');

        $get = Yii::$app->request->get();
        $data = false;
        if(!empty($get)){
            $data = Product::findByData($get);
        }
        return $this->render('index', [
            'shipping_types' => $shipping_types,
            'warehouse_types' => $warehouse_types,
            'users' =>$uersData,
            'groups' =>$groups,
            'isFavorite' => $isFavorite,

            'data' =>$data,
        ]);
    }
    public function actionGenerate(){
        $get = Yii::$app->request->get();
        $data = false;
        if(!empty($get)){
            $data = Product::findByData($get);
        }
      return $this->renderAjax('generate', ['data' =>$data]);
    }
      public function actionGenerateSellout(){
        $get = Yii::$app->request->get();
        $data = false;
        if(!empty($get)){
            $data = Product::findBySellOut($get);
        }
     
      return $this->renderAjax('generate_sellout', ['data' =>$data]);
    }
    public function actionGenerateOpening(){
        $get = Yii::$app->request->get();
        $data = false;
        if(!empty($get)){
            $data = Product::findByOpening($get);
        }
     
      return $this->renderAjax('generate_sellout', ['data' =>$data]);
    }
       public function actionGenerateClosing(){
        $get = Yii::$app->request->get();
        $data = false;
        if(!empty($get)){
            $data = Product::findByClosing($get);
        }
      return $this->renderAjax('generate_sellout', ['data' =>$data]);
    }
     public function actionGenerateSellin(){
        $get = Yii::$app->request->get();
        $data = false;
        if(!empty($get)){
            $data = Product::findBySellin($get);
        }
     
      return $this->renderAjax('generate_sellout', ['data' =>$data]);
    }

}
