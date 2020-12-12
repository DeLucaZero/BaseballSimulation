<?php

//Hit Type//

#echo "<br>Batted Ball Page";

$Roll = mt_rand(1,1869);

if ($Roll <= 315){ //LineDrive
    $HitType = "LD";
} elseif ($Roll <= 1076){ //GroundBall
    $HitType = "GB";
} else { //FlyBall
    $HitType = "FB";

    //11% of FB are InField
}

if ($HitType == "GB"){

    include 'GroundBall.php';

    #echo "<br>Groundball";

} elseif ($HitType == "LD"){

    include 'LineDrive.php';
    #echo "<br>LineDrive";

} else { //FB

    include 'FlyBall.php';
    #echo "<br>FlyBall";

}

include 'NextBatter.php';