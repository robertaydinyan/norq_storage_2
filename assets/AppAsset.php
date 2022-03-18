<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/app.css',
        'js/plugins/fullcalendar/fullcalendar.css',
        'css/plugins/table/table.css',
        'css/plugins/table/search.css',
        'css/plugins/table/style.css',
        'css/modules/crm/jquery-ui.min.css',
        'css/modules/crm/style.css',
        'css/modules/crm/style2.css',
        'css/modules/crm/arrow_slides.css',
        'css/modules/crm/spectrum_colorPicker/spectrumColorpicker.css',
        'css/modules/crm/lead_kanban.css',
        'task/css/task_kanban.css',
        'css/modules/crm/jquery-ui.min.css',
        'css/plugins/fontawesome/all.min.css',
        'css/modules/crm/ui-kit.css',

        //changes 11/26/2020
        'css/modules/crm/kanban.css',
        'https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'


    ];
    public $js = [
        'js/app.js',
        'js/script.js',
        'js/geocoder.js',
        'js/calendar.js',
        'js/modules/crm/PLUGINS/moment.js',
        'js/modules/billing/ajax-modal-popup.js',
        'js/modules/crm/PLUGINS/jquery-ui.min.js',
        'js/modules/crm/PLUGINS/spectrum_colorPicker/spectrumColorpicker.js',
        'js/modules/crm/KANBAN/all_template.js',
        'js/modules/crm/KANBAN/lead_kanban/kanban_lead_items.js',
        'js/modules/crm/KANBAN/templates/templates.js',
        'js/plugins/table/table.js',
        'js/plugins/table/search.js',
        'js/plugins/table/script.js',
        'js/modules/crm/arrow_sliders.js',
        'js/modules/crm/KANBAN/kanban.js',

        'js/modules/crm/script2.js',
        'js/plugins/fullcalendar/fullcalendar.min.js',
        'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
