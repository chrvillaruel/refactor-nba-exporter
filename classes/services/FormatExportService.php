<?php
use Illuminate\Support;
require_once('classes/export-format-type/CSV.php');
require_once('classes/export-format-type/JSON.php');
require_once('classes/export-format-type/HTML.php');
require_once('classes/export-format-type/XML.php');

class FormatExportService
{
    public $format = "";
    public $type = "";
    public $exportData = [];

    public function __construct($format = 'html', $exportData) {

        $this->format = $format;

        $this->exportData = $exportData;
    }

    public function process() {
        // return the right data format
        switch($this->format) {
            case 'xml':
                return (new XML($this->exportData))->format();
                break;
            case 'json':
                return (new JSON($this->exportData))->format();
                break;
            case 'csv':
                return (new CSV($this->exportData))->format();
                break;
            default: // html
                return (new HTML($this->exportData))->format();
                break;
        }
    }


}