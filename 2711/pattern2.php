<?php
$x=5;
for($i=1;$i<=$x;$i++)
{
    for($j=$i;$j<$x;$j++)
    {
        echo"-";
    }
    for ($k = 1; $k <= $i; $k++) {
        echo "*";
        if($k<$i)
        {
            echo " ";
        }
        for($l = $i; $l < $x; $l++) {
            echo "-";
        }
    }
    echo"<br>";
}
?>



