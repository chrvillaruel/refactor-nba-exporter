<?php
use Illuminate\Support;  // https://laravel.com/docs/5.8/collections - provides the collect methods & collections class
use LSS\Array2Xml;
require_once('classes/services/ExporterService.php');


class Controller {

    public $args;

    public function __construct($args) {
        $this->args = $args;
    }

    public function export() {
        $format = $this->args->pull('format') ?: 'html';

        $type = $this->args->pull('type');

        if (!$type) {
            exit('Please specify a type');
        }

        return (new ExporterService($format, $type, $this->args))->processExport();
    }


}