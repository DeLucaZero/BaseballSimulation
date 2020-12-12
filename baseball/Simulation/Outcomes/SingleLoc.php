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

    //Shallow Center->Right (CF/2B) CF if man on 1st
    //Shallow Center->Left (CF/SS)
    //Shallow Center
    //Mid Center
    //Deep Center

    $Roll = mt_rand(1,7);

    if ($Game->InnHalf == 1){ //Home Defense

        if ($Roll == 1){ //Shallow Center Right, CF
            $Defender = $HCF;
            $HitLoc = "Shallow Center Right";
        } elseif ($Roll == 2) { //Shallow Center Right 2B
            $Defender = $H2B;
            $HitLoc = "Shallow Center Right";
        } elseif ($Roll == 3) { //Shallow Center Left CF
            $Defender = $HCF;
            $HitLoc = "Shallow Center Left";
        } elseif ($Roll == 4) { //Shallow Center Left SS
            $Defender = $HSS;
            $HitLoc = "Shallow Center Left";
        } elseif ($Roll == 5) { //Mid Center CF
            $Defender = $HCF;
            $HitLoc = "Mid Center";
        } elseif ($Roll == 6) { //Shallow Center CF
            $Defender = $HCF;
            $HitLoc = "Shallow Center";
        } else { //Deep Center CF
            $Defender = $HCF;
            $HitLoc = "Deep Center";
        }

    } else { //Away Defense

        if ($Roll == 1){ //Shallow Center Right, CF
            $Defender = $ACF;
            $HitLoc = "Shallow Center Right";
        } elseif ($Roll == 2) { //Shallow Center Right 2B
            $Defender = $A2B;
            $HitLoc = "Shallow Center Right";
        } elseif ($Roll == 3) { //Shallow Center Left CF
            $Defender = $ACF;
            $HitLoc = "Shallow Center Left";
        } elseif ($Roll == 4) { //Shallow Center Left SS
            $Defender = $ASS;
            $HitLoc = "Shallow Center Left";
        } elseif ($Roll == 5) { //Mid Center CF
            $Defender = $ACF;
            $HitLoc = "Mid Center";
        } elseif ($Roll == 6) { //Shallow Center CF
            $Defender = $ACF;
            $HitLoc = "Shallow Center";
        } else { //Deep Center CF
            $Defender = $ACF;
            $HitLoc = "Deep Center";
        }

    }

} else { //Pull Left//

    //Shallow Left->Center LF
    //Shallow Left->Right (LF/SS)
    //Shallow Left->Left (3B/LF)
    //Mid Left LF
    //Deep Left LF
    //Infield Left 3B (Rare)

    $Roll = mt_rand(1,15);

    if ($Game->InnHalf == 1){ //Home Defense

        if ($Roll <= 2){ //Shallow Left, LF
            $Defender = $HLF;
            $HitLoc = "Shallow Left";
        } elseif ($Roll <= 4) { //Shallow Left->Right SS
            $Defender = $HSS;
            $HitLoc = "Shallow Left Right";
        } elseif ($Roll <= 6) { //Shallow Left->Right LF
            $Defender = $HLF;
            $HitLoc = "Shallow Left Right";
        } elseif ($Roll <= 8) { //Shallow Left->Left 3B
            $Defender = $H3B;
            $HitLoc = "Shallow Left Left";
        } elseif ($Roll <= 10) { //Shallow Left->Left LF
            $Defender = $HLF;
            $HitLoc = "Shallow Left Left";
        } elseif ($Roll <= 12) { //Mid Left LF
            $Defender = $HLF;
            $HitLoc = "Mid Left";
        } elseif ($Roll <= 14) { //Deep Left LF
            $Defender = $HLF;
            $HitLoc = "Deep Left";
        } else { //Infield Left 3B
            $Defender = $H3B;
            $HitLoc = "Infield Left";
        }

    } else {

        if ($Roll <= 2){ //Shallow Left, LF
            $Defender = $ALF;
            $HitLoc = "Shallow Left";
        } elseif ($Roll <= 4) { //Shallow Left->Right SS
            $Defender = $ASS;
            $HitLoc = "Shallow Left Right";
        } elseif ($Roll <= 6) { //Shallow Left->Right LF
            $Defender = $ALF;
            $HitLoc = "Shallow Left Right";
        } elseif ($Roll <= 8) { //Shallow Left->Left 3B
            $Defender = $A3B;
            $HitLoc = "Shallow Left Left";
        } elseif ($Roll <= 10) { //Shallow Left->Left LF
            $Defender = $ALF;
            $HitLoc = "Shallow Left Left";
        } elseif ($Roll <= 12) { //Mid Left LF
            $Defender = $ALF;
            $HitLoc = "Mid Left";
        } elseif ($Roll <= 14) { //Deep Left LF
            $Defender = $ALF;
            $HitLoc = "Deep Left";
        } else { //Infield Left 3B
            $Defender = $A3B;
            $HitLoc = "Infield Left";
        }

    }

}