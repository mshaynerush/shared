<?php

$fuck = 'JOSIDFOISJDF';
$cunt = 'a1a';

$item_fuck = preg_replace('/[^0-9]/', '', $fuck);
$item_cunt = preg_replace('/[^0-9]/', '', $cunt);

if(is_numeric($item_cunt)){
echo $item_fuck;
echo '<br>';
echo $item_cunt;
} 
if (is_numeric($item_fuck)){
    echo 'cunt';
}

?>



