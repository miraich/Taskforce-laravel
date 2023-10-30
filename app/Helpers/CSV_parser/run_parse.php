<?php
require_once("../../../vendor/autoload.php");

use App\Helpers\CSV_parser\Csv_parser;

$parser = new Csv_parser();
$parser->importCsv();
