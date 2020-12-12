<?php
//Hit Location//

if ($Pull == "Right"){

    //Has to be into Mid/Deep Outfield//

    if ($Game->InnHalf == 1){
        $Defender = $HRF;

        $Roll = mt_rand(1,2);

        if ($Roll == 1){
            $HitLoc = "Mid Right";
        } else {
            $HitLoc = "Deep Right";
        }

    } else {
        $Defender = $ARF;

        $Roll = mt_rand(1,2);

        if ($Roll == 1){
            $HitLoc = "Mid Right";
        } else {
            $HitLoc = "Deep Right";
        }
    }

} elseif ($Pull == "Center") {

    //Mid Center
    //Deep Center

    $Roll = mt_rand(1,2);

    if ($Game->InnHalf == 1){ //Home Defense

        $Defender = $HCF;

        if ($Roll == 1) { //Mid Center CF
            $HitLoc = "Mid Center";
        }  else { //Deep Center CF
            $HitLoc = "Deep Center";
        }

    } else { //Away Defense

        $Defender = $ACF;

        if ($Roll == 1) { //Mid Center CF
            $HitLoc = "Mid Center";
        }  else { //Deep Center CF
            $HitLoc = "Deep Center";
        }

    }

} else { //Pull Left//

    //Mid Left LF
    //Deep Left LF

    $Roll = mt_rand(1,2);

    if ($Game->InnHalf == 1){ //Home Defense

        $Defender = $HLF;

        if ($Roll == 1) { //Mid Left LF
            $HitLoc = "Mid Left";
        } elseif ($Roll <= 14) { //Deep Left LF
            $HitLoc = "Deep Left";
        }

    } else {

        $Defender = $ALF;

        if ($Roll == 1) { //Mid Left LF
            $HitLoc = "Mid Left";
        } elseif ($Roll <= 14) { //Deep Left LF
            $HitLoc = "Deep Left";
        }

    }

}