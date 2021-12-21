<?php
use Illuminate\Support;
require_once('classes/services/FormatExportService.php');
require_once('classes/filter-type/PlayerStats.php');
require_once('classes/filter-type/Players.php');

// retrieves & formats data from the database for export
class ExporterService {

    public $format = "";
    public $type = "";
    public $args = "";
    public $exportData = [];

    public function __construct($format = 'html', $type, $args) {

        $this->format = $format;

        $this->type = $type;

        $this->args = $args;
    }

    public function processExport() {
        switch ($this->type) {
            case 'playerstats':
                $this->exportData = (new PlayerStats($this->args))->getData();
                break;
            case 'players':
                $this->exportData = (new Players($this->args))->getData();
                break;
        }

        if (! $this->exportData) {
            exit("Error: No data found!");
        }

       return (new FormatExportService($this->format, $this->exportData))->process();

    }

}

?>