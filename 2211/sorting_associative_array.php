<?php
$x=array("a"=>"z","b"=>"y","c"=>"x");
asort($x);//sort associative arrays in ascending order, according to the value
ksort($x);//sort associative arrays in ascending order, according to the key
arsort($x);//sort associative arrays in descending order, according to the value
krsort($x);//sort associative arrays in descending order, according to the key
print_r($x);
?>