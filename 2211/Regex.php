<?php

//preg_match() function will tell you whether a string contains matches of a pattern.
// $x = "Hey Khilraj";
// $pattern = "/Hey/i";
// echo preg_match($pattern, $x);


//preg_match_all() function will tell you how many matches were found for a pattern in a string.
$x = "Hey ,how are you Khilraj";
$pattern = "/h/i";
echo preg_match_all($pattern, $x);


//preg_replace() function will replace all of the matches of the pattern in a string with another string.
// $x = "Hey Khilraj!";
// $pattern = "/Khilraj/i";
// echo preg_replace($pattern, "Raj", $x);


?>