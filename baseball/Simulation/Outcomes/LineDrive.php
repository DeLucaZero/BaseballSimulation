<?php

$Error = 0;
$RBI = 0;
$Runs = 0;
$EarnedRuns = 0;
$ThrowHome = 0;

$Pitcher->Batters = $Pitcher->Batters + 1;
$Batter->PA = $Batter->PA + 1;
$Batter->AB = $Batter->AB + 1;

//67% Line Drives Are Catch Outs//

$Roll = mt_rand(1,100);

if ($Roll <= 55){ //Catch Out

    if ($Pull == "Right") {

        //Infield Right 1B
        //Infield Right Left (2B)
        //Shallow Right RF

        if ($Game->InnHalf == 1){

            $Roll = mt_rand(1,3);

            if ($Roll == 1){
                $HitLoc = "Infield Right";
                $Defender = $H1B;
            } elseif ($Roll == 2){
                $HitLoc = "Infield Right Left";
                $Defender = $H2B;
            } else {
                $HitLoc = "Shallow Right";
                $Defender = $HRF;
            }

        } else {

            $Roll = mt_rand(1,3);

            if ($Roll == 1){
                $HitLoc = "Infield Right";
                $Defender = $A1B;
            } elseif ($Roll == 2){
                $HitLoc = "Infield Right Left";
                $Defender = $A2B;
            } else {
                $HitLoc = "Shallow Right";
                $Defender = $ARF;
            }

        }

    } elseif ($Pull == "Center"){

        //Infield Center Right 2B
        //Infield Center Left SS

        if ($Game->InnHalf == 1){

            $Roll = mt_rand(1,3);

            if ($Roll == 1){
                $HitLoc = "Infield Center Right";
                $Defender = $H2B;
            } elseif ($Roll == 2){
                $HitLoc = "Infield Center Left";
                $Defender = $HSS;
            } else {
                $HitLoc = "Shallow Center";
                $Defender = $HCF;
            }

        } else {
            $Roll = mt_rand(1,3);

            if ($Roll == 1){
                $HitLoc = "Infield Center Right";
                $Defender = $A2B;
            } elseif ($Roll == 2){
                $HitLoc = "Infield Center Left";
                $Defender = $ASS;
            } else {
                $HitLoc = "Shallow Center";
                $Defender = $ACF;
            }

        }

    } else { //Pull Left


        //Infield Left Right SS
        //Infield Left 3B

        if ($Game->InnHalf == 1){

            $Roll = mt_rand(1,3);

            if ($Roll == 1){
                $HitLoc = "Infield Left Right";
                $Defender = $HSS;
            } elseif ($Roll == 2){
                $HitLoc = "Shallow Left";
                $Defender = $HLF;
            } else {
                $HitLoc = "Infield Left";
                $Defender = $H3B;
            }

        } else {
            $Roll = mt_rand(1,3);

            if ($Roll == 1){
                $HitLoc = "Infield Left Right";
                $Defender = $ASS;
            } elseif ($Roll == 2){
                $HitLoc = "Shallow Left";
                $Defender = $ALF;
            } else {
                $HitLoc = "Infield Left";
                $Defender = $A3B;
            }

        }

    }

    //Field Catch//
    $ErrorChance = GloveError($Defender);

    $Roll = mt_rand(1,1000);

    if ($Roll <= $ErrorChance){
        $Error = 1;

        #echo "<br>$Defender->Position $Defender->Name Errors trying to catch the Ball";

        $Defender->TC = $Defender->TC + 1;
        $Defender->Errors = $Defender->Errors + 1;
    }

    if ($Error == 0){

        $Defender->TC = $Defender->TC + 1;
        $Defender->PO = $Defender->PO + 1;
        $Pitcher->Outs = $Pitcher->Outs + 1;
        $Game->Outs = $Game->Outs + 1;

    } else { //Errored->Advance Runners + 1;

        //Update Error//

        if ($Game->Outs == 2){
            $Game->ErrorAfter2 = 1;
        }

        //Runner On Third->Scores->Unearned->No RBI//
        if ($OnThird->ID != 0){

            //Score//
            $OnThird->Runs = $OnThird->Runs + 1;
            $Runs = $Runs + 1;

            $Pitcher->Runs = $Pitcher->Runs + 1;

            #echo "<br>$OnThird->Name Scores from 3rd due to Error";

            //Reset 3rd//
            $OnThird = $Zero;

        }

        //Runner on Second//
        if ($OnSecond->ID != 0){

            //Advance//
            $OnThird = $OnSecond;
            //Reset//
            $OnSecond = $Zero;

            #echo "<br>$OnThird->Name advances to 3rd";

        }

        //Runner on First//
        if ($OnFirst->ID != 0){

            //Advance//
            $OnSecond = $OnFirst;
            //Reset//
            $OnFirst = $Zero;

            #echo "<br>$OnSecond->Name Advances to 2nd";

        }

        //Put Batter on First, Unearned//
        $OnFirst = $Batter;
        $Batter->ER = 0;
        #echo "<br>$Batter->Name takes 1st due to Error";

    }

} else { //Fielded Out

    if ($Pull == "Right") {

        //Infield Right 1B
        //Infield Right Left (2B)
        //Shallow Right RF

        if ($Game->InnHalf == 1){

            $Roll = mt_rand(1,3);

            if ($Roll == 1){
                $HitLoc = "Infield Right";
                $Defender = $H1B;
            } elseif ($Roll == 2){
                $HitLoc = "Infield Right Left";
                $Defender = $H2B;
            } else {
                $HitLoc = "Shallow Right";
                $Defender = $HRF;
            }

        } else {

            $Roll = mt_rand(1,3);

            if ($Roll == 1){
                $HitLoc = "Infield Right";
                $Defender = $A1B;
            } elseif ($Roll == 2){
                $HitLoc = "Infield Right Left";
                $Defender = $A2B;
            } else {
                $HitLoc = "Shallow Right";
                $Defender = $ARF;
            }

        }

    } elseif ($Pull == "Center"){

        //Infield Center Right 2B
        //Infield Center Left SS

        if ($Game->InnHalf == 1){

            $Roll = mt_rand(1,3);

            if ($Roll == 1){
                $HitLoc = "Infield Center Right";
                $Defender = $H2B;
            } elseif ($Roll == 2){
                $HitLoc = "Infield Center Left";
                $Defender = $HSS;
            } else {
                $HitLoc = "Shallow Center";
                $Defender = $HCF;
            }

        } else {
            $Roll = mt_rand(1,3);

            if ($Roll == 1){
                $HitLoc = "Infield Center Right";
                $Defender = $A2B;
            } elseif ($Roll == 2){
                $HitLoc = "Infield Center Left";
                $Defender = $ASS;
            } else {
                $HitLoc = "Shallow Center";
                $Defender = $ACF;
            }

        }

    } else { //Pull Left


        //Infield Left Right SS
        //Infield Left 3B

        if ($Game->InnHalf == 1){

            $Roll = mt_rand(1,2);

            if ($Roll == 1){
                $HitLoc = "Infield Left Right";
                $Defender = $HSS;
            } else {
                $HitLoc = "Infield Left";
                $Defender = $H3B;
            }

        } else {
            $Roll = mt_rand(1,2);

            if ($Roll == 1){
                $HitLoc = "Infield Left Right";
                $Defender = $ASS;
            } else {
                $HitLoc = "Infield Left";
                $Defender = $A3B;
            }

        }

    }

//Echo//
    #echo "<br>$Batter->Name Line Drives to $HitLoc";

//Fielding//
    $ErrorChance = GloveError($Defender);

    $Roll = mt_rand(1,1000);

    if ($Roll <= $ErrorChance){
        $Error = 1;

        #echo "<br>$Defender->Position $Defender->Name Errors trying to field the Ball";

        $Defender->TC = $Defender->TC + 1;
        $Defender->Errors = $Defender->Errors + 1;
    }

    if ($Error == 0) {

        //Fielded Cleanly, Make Sure Throw and Catch Are Error Free//
        #echo "<br>$Defender->Position $Defender->Name Fields it cleanly";

        if ($Defender->Position != "1B"){
            //Throw Error//
            $ErrorChance = ArmError($Defender);

            $Roll = mt_rand(1,1000);

            if ($Roll <= $ErrorChance){
                $Error = 1;

                #echo "<br>$Defender->Position $Defender->Name Errors with a bad throw to 1st";

                $Defender->TC = $Defender->TC + 1;
                $Defender->Errors = $Defender->Errors + 1;
            } else {
                #echo ", and throws it to 1st. ";
            }

            if ($Error == 0){ //Clean Throw, Make Sure 1B Clean Catches//

                //Catch//
                $ErrorChance = GloveError($First);

                $Roll = mt_rand(1,1000);

                if ($Roll <= $ErrorChance){
                    $Error = 1;

                    #echo "<br>$First->Position $First->Name Errors trying to make the catch at 1st";

                    $Defender->TC = $Defender->TC + 1;
                    $Defender->Asst = $Defender->Asst + 1;
                    $First->TC = $First->TC + 1;
                    $First->Errors = $First->Errors + 1;

                } else { //No Error, Clean Out//

                    $Defender->TC = $Defender->TC + 1;
                    $Defender->Asst = $Defender->Asst + 1;
                    $First->TC = $First->TC + 1;
                    $First->PO = $First->PO + 1;
                    $Pitcher->Outs = $Pitcher->Outs + 1;
                    $Game->Outs = $Game->Outs + 1;

                    #echo "<br>$First->Position $First->Name Catches the throw, for the Out";

                }

            }

        } else { //1B Fielded it, and Will Step On The Bag
            $Defender->TC = $Defender->TC + 1;
            $Defender->PO = $Defender->PO + 1;
            $Pitcher->Outs = $Pitcher->Outs + 1;
            $Game->Outs = $Game->Outs + 1;

            #echo "<br>$Defender->Position $Defender->Name Steps on the Bag to record the Out";
        }



    }

    if ($Error == 0 AND $Game->Outs <= 2){ //No Errors, Baserunning//

        //Move Forced Runners//

        //Bases Loaded->Move all runners//
        if ($OnThird->ID != 0 AND $OnSecond->ID != 0 AND $OnFirst->ID != 0){

            ////Third/////

            //Score//
            $OnThird->Runs = $OnThird->Runs + 1;
            $Runs = $Runs + 1;

            if ($Game->ErrorAfter2 == 0 AND $OnThird->ER != 0){
                $EarnedRuns = $EarnedRuns + 1;
            }

            $Pitcher->Runs = $Pitcher->Runs + 1;
            $Pitcher->ER = $Pitcher->ER + 1;
            $Batter->RBI = $Batter->RBI + 1;

            #echo "<br>$OnThird->Name Scores from 3rd";

            //Reset 3rd//
            $OnThird = $Zero;

            ////Second////

            //Advance//
            $OnThird = $OnSecond;
            //Reset//
            $OnSecond = $Zero;

            #echo "<br>$OnThird->Name advances to 3rd";

            ////First////

            //Advance//
            $OnSecond = $OnFirst;
            //Reset//
            $OnFirst = $Zero;

            #echo "<br>$OnSecond->Name Advances to 2nd";

        } elseif ($OnSecond->ID != 0 AND $OnFirst->ID != 0){

            ////Second////

            //Advance//
            $OnThird = $OnSecond;
            //Reset//
            $OnSecond = $Zero;

            #echo "<br>$OnThird->Name advances to 3rd";

            ////First////

            //Advance//
            $OnSecond = $OnFirst;
            //Reset//
            $OnFirst = $Zero;

            #echo "<br>$OnSecond->Name Advances to 2nd";

        } elseif ($OnFirst->ID != 0){

            ////First////

            //Advance//
            $OnSecond = $OnFirst;
            //Reset//
            $OnFirst = $Zero;

            #echo "<br>$OnSecond->Name Advances to 2nd";

        } elseif ($OnThird->ID != 0){

            //Attempt to Score From Third//
            $Extra = RunExtraBase ($OnThird);

            if ($Extra == 1){ //Runner Will Run Home//

                $Success = ScoreFromThird($OnThird,$Defender,$Catcher);

                if ($Success == 1){ //Runner Scores//
                    $Batter->RBI = $Batter->RBI + 1;
                    $OnThird->Runs = $OnThird->Runs + 1;

                    if ($Game->ErrorAfter2 >= 1 OR $OnThird->ER == 0){ //No Earned Runs->Error After 2 Outs//
                        $Runs = $Runs + 1;
                        #echo "<br>$OnThird->Name Scores Unearned 3rd +RBI";
                    } elseif ($OnThird->ER != 0){ //Earned Run
                        $Runs = $Runs + 1;
                        $EarnedRuns = $EarnedRuns + 1;
                        #echo "<br>$OnThird->Name Scores an ER from 3rd +RBI";
                    }


                } else { //Thrown Out//

                    //Defender Arm Error Check//
                    $ThrowHomeError = ArmError($First);

                    $Roll = mt_rand(1,1000);

                    if ($Roll <= $ThrowHomeError){ //Throwing Error->Error Assigned->No Earned Run->No RBI//

                        $First->TC = $First->TC + 1;
                        $First->Errors = $First->Errors + 1;
                        $Runs = $Runs + 1;
                        $OnThird->Runs = $OnThird->Runs + 1;
                        #echo "<br>$OnThird->Name Scores from 3rd due to $First->Name Error";

                        if ($Game->Outs == 2){
                            $Game->ErrorAfter2 = 1;
                        }

                    } else {
                        $Game->Outs = $Game->Outs + 1;
                        $Pitcher->Outs = $Pitcher->Outs + 1;
                        $First->TC = $First->TC + 1;
                        $First->Asst = $First->Asst + 1;
                        $Catcher->PO = $Catcher->PO + 1;
                        $Catcher->TC = $Catcher->TC + 1;
                        #echo "<br>$OnThird->Name gets thrown out at Home by $First->Name";
                    }

                }

                $OnThird = $Zero;

            }

        }

    }

    if ($Error == 1){ //Advance All Runners//

        //Update Error//
        if ($Game->Outs == 2){
            $Game->ErrorAfter2 = 1;
        }

        //Runner On Third->Scores->Unearned->No RBI//
        if ($OnThird->ID != 0){

            //Score//
            $OnThird->Runs = $OnThird->Runs + 1;
            $Runs = $Runs + 1;

            $Pitcher->Runs = $Pitcher->Runs + 1;

            #echo "<br>$OnThird->Name Scores from 3rd";

            //Reset 3rd//
            $OnThird = $Zero;

        }

        //Runner on Second//
        if ($OnSecond->ID != 0){

            //Advance//
            $OnThird = $OnSecond;
            //Reset//
            $OnSecond = $Zero;

            #echo "<br>$OnThird->Name advances to 3rd";

        }

        //Runner on First//
        if ($OnFirst->ID != 0){

            //Advance//
            $OnSecond = $OnFirst;
            //Reset//
            $OnFirst = $Zero;

            #echo "<br>$OnSecond->Name Advances to 2nd";

        }

        //Put Batter on First, Unearned//
        $OnFirst = $Batter;
        $Batter->ER = 0;
        #echo "<br>$Batter->Name takes 1st due to Error";

    }

}

include 'ScoreUpdate.php';

if ($EarnedRuns > 0){
    #echo "<br>$Pitcher->Name +$EarnedRuns";
}