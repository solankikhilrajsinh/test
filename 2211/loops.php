<?php

//BREAK STATEMENT
// $i=1;
// while($i<200)
// {
//     if($i==100)
//     {
//         break;
//     }
//     echo $i;
//     $i++;
// }

//CONTINUE STATEMENT
// $i=0;
// while($i<6)
// {
//     $i++;
//     if($i==2)
//     {
//         continue;
//     }
//     echo $i;
// }

//FOREACH STATEMENT
// $members = array("a"=>"35", "b"=>"37", "c"=>"43");

// foreach ($members as $x => $y) {
//   echo "$x : $y <br>";
// }/


//foreach Loop on Objects
// class Alpha {
//     public $a;
//     public $b;
//     public function __construct($a, $b) {
//       $this->a = $a;
//       $this->b = $b;
//     }
//   }
  
//   $myCar = new Alpha("c", "d");
  
//   foreach ($myCar as $x => $y) {
//     echo "$x: $y <br>";
//   }


//for each loop with break
$colors = array("red", "green", "blue", "yellow");

foreach ($colors as $x) {
  if ($x == "blue") break;
  echo "$x <br>";
}



?>