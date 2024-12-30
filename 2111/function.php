//define constant,make function and use it .
<!-- <?php
$GREETING="It is a variable";
define("GREETING", "It is constant");
// echo GREETING;
function x()
{
    // echo GREETING;
    global $GREETING;
    echo $GREETING;
}
x();
// echo $GREETING;
?> -->


<!-- <?php
$x=["ab","cd","ef"];
foreach($x as &$y)
{
    $y="gg";
}
unset($y);
print_r ($x);
?> -->

<!-- 
<?php
$x=["a","b","c"];
foreach($x as &$g)
{
    $g="f";
}
$g="h";
print_r($x);
?> -->



