<?php

$log = $_GET['log'];

$logFiles = scandir($GLOBALS['Path'] . '/logs/');

foreach($logFiles as $file) {
    if ($file != '.' && $file != '..') {
        echo "<a href='?view=logs&log={$file}'>";
        echo $file;
        echo "</a> |";
    }
}

echo '<br/><br/>';

if (isset($log)) {

    echo '<div style="overflow:auto; height:300px; width:100%">';

    $logLines = file($GLOBALS['Path'] . '/logs/' . $log);

    foreach ($logLines as $Line) {
        echo $Line . '<br/>';
    }

    echo '</div>';
}