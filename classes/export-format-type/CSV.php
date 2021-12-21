<?php
require_once('classes/interfaces/FormatInterface.php');

class CSV implements FormatInterface
{
    public function __construct($exportData)
    {
        $this->exportData = $exportData;
    }

    public function format() {
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="export.csv";');
        if (!$this->exportData->count()) {
            return;
        }
        $csv = [];

        // extract headings
        // replace underscores with space & ucfirst each word for a decent headings
        $headings = collect($this->exportData->get(0))->keys();
        $headings = $headings->map(function($item, $key) {
            return collect(explode('_', $item))
                ->map(function($item, $key) {
                    return ucfirst($item);
                })
                ->join(' ');
        });
        $csv[] = $headings->join(',');

        // format data
        foreach ($this->exportData as $dataRow) {
            $csv[] = implode(',', array_values($dataRow));
        }
        return implode("\n", $csv);
    }

}