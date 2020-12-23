<?php
$c=0;
$a=1;
$b=1;
  function tambahkan($a,$b){
    $GLOBALS['c']=$a+$b;
    echo $GLOBALS['c'];
  }

  function hehe(){
    $a=$GLOBALS['a'];
    $b=$GLOBALS['b'];
    tambahkan($a,$b);
  }

  hehe();

?>