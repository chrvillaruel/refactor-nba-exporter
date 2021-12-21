<?php
require_once('classes/interfaces/FormatInterface.php');

class JSON implements FormatInterface
{
    public function __construct($exportData)
    {
        $this->exportData = $exportData;
    }

    public function format() {
        header('Content-type: application/json');
        return json_encode($this->exportData->all());
    }

}