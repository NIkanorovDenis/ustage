<?php

function formatBytes($size, $precision = 2) {
  $base = log($size, 1024);
  $suffixes = array('B', 'Kb', 'Mb', 'Gb', 'Tb');

  return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
}

echo 'Свободно: ' . formatBytes(disk_free_space(__DIR__)) . '<br> Всего: ' . formatBytes(disk_total_space(__DIR__));
