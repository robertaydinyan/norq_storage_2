<?php

namespace app\components\Importer;

use app\modules\fastnet\models\Deal;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Importer
{

    public $file = 'SRM_file.xlsx';

    public $delimiter;

    public $tableName;

    public $importer;

    public function __construct()
    {
        $this->importer = IOFactory::load($this->file);
        $this->tableName = Deal::tableName();
    }

    /**
     * Will read file.
     * 
     * @return array
     */
    public function read()
    {
        $reader = $this->importer->getActiveSheet()->toArray(null, true, true, true);
        unset($reader[1]);
        return $reader;
    }

    public function formatColumns()
    {
        return [
            'A' => 'is_daily',
            'B' => 'deal_number',
            'C' => 'provider',
            'F' => 'blacklist',
            'G' => 'name',
            'H' => 'surname',
            'I' => 'is_daily',
            'J' => 'is_daily',
        ];
    }

}