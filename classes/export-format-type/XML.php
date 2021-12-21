<?php
use LSS\Array2Xml;
require_once('classes/interfaces/FormatInterface.php');

class XML implements FormatInterface
{
    public function __construct($exportData)
    {
        $this->exportData = $exportData;
    }

    public function format() {
        header('Content-type: text/xml');

        // fix any keys starting with numbers
        $keyMap = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
        $xmlData = [];
        foreach ($this->exportData->all() as $row) {
            $xmlRow = [];
            foreach ($row as $key => $value) {
                $key = preg_replace_callback('(\d)', function($matches) use ($keyMap) {
                    return $keyMap[$matches[0]] . '_';
                }, $key);
                $xmlRow[$key] = $value;
            }
            $xmlData[] = $xmlRow;
        }
        $xml = Array2XML::createXML('data', [
            'entry' => $xmlData
        ]);
        return $xml->saveXML();
    }

}