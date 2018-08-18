<?php

require_once 'AuxiliaryFunctions.php';
ini_set('memory_limit', '-1');
$files = listDirectory("/../sources/fromExternalResults");
foreach ($files as $file) {
    $language = explode('_', $file);
    $content = file_get_contents(__DIR__ . "/../sources/fromExternalResults/" . $file);
    $rows = explode(PHP_EOL, $content);

    foreach ($rows as $key => $row) {

        if ($row == ',' || preg_match('/\[?{"head":{},"en-' . $language[0] . '":{"regular":\[\]}},?/',$row)) {
            unset($rows[$key]);
        }
    }
    $result = implode(PHP_EOL, $rows);
    file_put_contents(__DIR__ . "/../sources/fromExternalResults/" .$file,$result);
}
echo "DONE";
//echo "CURRENTLY NOT AVAILABLE";