<?php
$x=array("a"=>"z","b"=>"y","c"=>11);
unset($x["b"]);
print_r($x);
// $y=array_diff($x,["y",11]); //this function also used to remove elements
// print_r($y);
?>