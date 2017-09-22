<?php

$i = 0;//$_GET['i'];
$ii = $_GET['i'];
//


echo getCount($ii);

 function getCount($ii){
  $d = "00";
  $dd = "000";
  $ddd = "0000";
  $dddd = "00000";
  
  if ($ii < 10)
  {$i = $dddd . $ii; return $i;}
  else if ($ii < 100)
  {$i = $ddd . $ii; return $i;}
  else if ($ii < 1000)
  {$i = $dd . $ii; return $i;}
  else if ($ii < 10000)
  {$i = $d . $ii; return $i;}

}