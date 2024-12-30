<?php

// if(5>3)
// {
//     echo "5 is greater ";
// }

// $x=4;
// if($x<20)
// {
//     echo"HELLO";
// }


//comparison operator
// $x=12;
// if($x==12)
// {
//     echo"It i same";
// }



// //multidimensional array
// $x=array(array(1,array("a",1,2),array("d",3,4)),array("b",2,3),array("c",3,4));

// //array push
// $x=array("1","2");
// array_push($x,"3");
// print_r($x);

// //array merge
// $x=array("b"=>"two","e"=>"six");
// $y=["c"=>"three","d"=>"four"];
// $z=array_merge($x,$y);
// print_r($z);

//array diff
$x=array("b"=>"two","e"=>"six","f"=>"eight");
$y=array_diff($x,["two"]);
print_r($y);


?>