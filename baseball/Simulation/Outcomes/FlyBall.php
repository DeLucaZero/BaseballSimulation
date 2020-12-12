<?php

$Error = 0;
$RBI = 0;
$Runs = 0;
$EarnedRuns = 0;
$ThrowHome = 0;

$Pitcher->Batters = $Pitcher->Batters + 1;

$Roll = mt_rand(1,100);

$SacFly = 0;

if ($Roll <= 11){ //Infield Fly->No Batter Advancement->Automatic PO

    if ($Pull == "Right") {

        //Infield Right 1B
        //Infield Right Left (2B)

        if ($Game->InnHalf == 1){

            $Roll = mt_rand(1,2);

            if ($Roll == 1){
                $HitLoc = "Infield Right";
                $Defender = $H1B;
            } else {
                $HitLoc = "Infield Right Left";
                $Defender = $H2B;
            }

        } else {
            $Roll = mt_rand(1,2);

            if ($Roll == 1){
                $HitLoc = "Infield Right";
                $Defender = $A1B;
            } else {
                $HitLoc = "Infield Right Left";
                $Defender = $A2B;
            }

        }

    } elseif ($Pull == "Center"){

        //Infield Center Right 2B
        //Infield Center Left SS

        if ($Game->InnHalf == 1){

            $Roll = mt_rand(1,2);

            if ($Roll == 1){
                $HitLoc = "Infield Center Right";
                $Defender = $H2B;
            } else {
                $HitLoc = "Infield Center Left";
                $Defender = $HSS;
            }

        } else {
            $Roll = mt_rand(1,2);

            if ($Roll == 1){
                $HitLoc = "Infield Center Right";
                $Defender = $A2B;
            } else {
                $HitLoc = "Infield Center Left";
                $Defender = $ASS;
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
    #echo "<br>$Batter->Name Pops up to $HitLoc, and is PO by $Defender->Position $Defender->Name";

    $Defender->TC = $Defender->TC + 1;
    $Defender->PO = $Defender->PO + 1;
    $Pitcher->Outs = $Pitcher->Outs + 1;

    $Game->Outs = $Game->Outs + 1;

} else {

    if ($Pull == "Right") {

        //Shallow Right RF
        //Mid Right
        //Deep Right

        if ($Game->InnHalf == 1){
            $Defender = $HRF;
        } else {
            $Defender = $ARF;
        }

        $Roll = mt_rand(1,3);

        if ($Roll == 1){
            $HitLoc = "Shallow Right";
        } elseif ($Roll == 2) {
            $HitLoc = "Mid Right";
        } else {
            $HitLoc = "Deep Right";
        }

    } elseif ($Pull == "Center"){

        if ($Game->InnHalf == 1){
            $Defender = $HCF;
        } else {
            $Defender = $ACF;
        }

        $Roll = mt_rand(1,3);

        if ($Roll == 1){
            $HitLoc = "Shallow Center";
        } elseif ($Roll == 2) {
            $HitLoc = "Mid Center";
        } else {
            $HitLoc = "Deep Center";
        }

    } else { //Pull Left


        if ($Game->InnHalf == 1){
            $Defender = $HLF;
        } else {
            $Defender = $ALF;
        }

        $Roll = mt_rand(1,3);

        if ($Roll == 1){
            $HitLoc = "Shallow Left";
        } elseif ($Roll == 2) {
            $HitLoc = "Mid Left";
        } else {
            $HitLoc = "Deep Left";
        }

    }

    //Echo//
    #echo "<br>$Batter->Name Pops up to $HitLoc";
    //Fielding//
    $ErrorChance = GloveError($Defender);

    $Roll = mt_rand(1,1000);

    if ($Roll <= $ErrorChance){
        $Error = 1; //Doesn't Count As Actual Error Unless Runner is able to advance.
        #echo "<br>$Defender->Name Drops the Fly Ball in an Error";
    }

    if ($Error == 1){

        //Defense Stats//
        $Defender->TC = $Defender->TC + 1;
        $Defender->Errors = $Defender->Errors + 1;

        if ($Game->Outs == 2){
            $Game->ErrorAfter2 = 1;
        }

        //See if Any Base Movement Possible//
        if ($HitLoc == "Deep Right" OR $HitLoc == "Deep Center" OR $HitLoc == "Deep Left"){

            if ($OnThird->ID != 0){ //Free Run Home//

                //Unearned, No RBI//
                $Runs = $Runs + 1;
                $Pitcher->Runs = $Pitcher->Runs + 1;
                $OnThird->Runs = $OnThird->Runs + 1;

                #echo "<br>$OnThird->Name Scores Due To $Defender->Position $Defender->Name Error";
                //Reset 3rd//
                $OnThird = $Zero;

                include 'ScoreUpdate.php';

            }

            if ($OnSecond->ID != 0){ //Free Base//

                //Move And Reset
                $OnThird = $OnSecond;
                $OnSecond = $Zero;

                #echo "<br>$OnThird->Name Moves to 3rd due to $Defender->Position $Defender->Name Error";

            }

            if ($OnFirst->ID != 0){ //Free Base//

                //Move And Reset
                $OnSecond = $OnFirst;
                $OnFirst = $Zero;

                #echo "<br>$OnSecond->Name Moves to 2nd due to $Defender->Position $Defender->Name Error";

            }

        }

        $OnFirst = $Batter;
        $Batter->ER = 0;

        #echo "<br>$Batter->Name reaches first on Error";

    } else {

        //Defense Stats//
        $Defender->TC = $Defender->TC + 1;
        $Defender->PO = $Defender->PO + 1;
        $Pitcher->Outs = $Pitcher->Outs + 1;

        #echo ", and is PO by $Defender->Position $Defender->Name";

        $Game->Outs = $Game->Outs + 1;

        if ($Game->Outs <= 2){

            //Check for Possible SacFly//

            if ($HitLoc == "Deep Right" OR $HitLoc == "Deep Center" OR $HitLoc == "Deep Left"){ //Possible Tag Up//

                //Runner on Third//
                if ($OnThird->ID != 0){

                    //See if Runner Rolls For Extra Base//
                    $Extra = RunExtraBase ($OnThird);

                    if ($Extra == 1){ //On Third Will Attempt Home//

                        #echo "<br>$OnThird->Name Tags Up and Attempts to Score";

                        $Success = ScoreFromThird($OnThird,$Defender,$Catcher);

                        if ($Success == 1){ //Runner Scores//
                            $RBI = $RBI + 1;
                            $OnThird->Runs = $OnThird->Runs + 1;

                            if ($Game->ErrorAfter2 >= 1 OR $OnThird->ER == 0){ //No Earned Runs->Error After 2 Outs//
                                $Runs = $Runs + 1;
                                #echo "<br>$OnThird->Name Scores Unearned 3rd +RBI";
                            } elseif ($OnThird->ER != 0){ //Earned Run
                                $Runs = $Runs + 1;
                                $EarnedRuns = $EarnedRuns + 1;
                                #echo "<br>$OnThird->Name Scores an ER from 3rd +RBI";
                            }

                            //Successful Sac Fly/

                            //Batter Stats//
                            $Batter->RBI = $Batter->RBI + 1;
                            $SacFly = 1;
                            //Pitcher Stats//
                            $Pitcher->ER = $Pitcher->ER + $EarnedRuns;
                            $Pitcher->Runs = $Pitcher->Runs + 1;

                            #echo "<br>$Batter->Name is Successful on the SacFly";


                        } else { //Thrown Out//

                            //Defender Arm Error Check//
                            $ThrowHomeError = ArmError($Defender);

                            $Roll = mt_rand(1,1000);

                            if ($Roll <= $ThrowHomeError){ //Throwing Error->Error Assigned->No Earned Run->No RBI//

                                $Defender->TC = $Defender->TC + 1;
                                $Defender->Errors = $Defender->Errors + 1;
                                $Runs = $Runs + 1;
                                $OnThird->Runs = $OnThird->Runs + 1;
                                #echo "<br>$OnThird->Name Scores from 3rd due to $Defender->Name Error";

                                if ($Game->Outs == 2){
                                    $Game->ErrorAfter2 = 1;
                                }


                            } else { //Successful Throw Out//
                                $Game->Outs = $Game->Outs + 1;
                                $Pitcher->Outs = $Pitcher->Outs + 1;
                                $Defender->TC = $Defender->TC + 1;
                                $Defender->Asst = $Defender->Asst + 1;
                                $Catcher->PO = $Catcher->PO + 1;
                                $Catcher->TC = $Catcher->TC + 1;
                                #echo "<br>$OnThird->Name gets thrown out at Home by $Defender->Name";

                            }

                        }

                        //Reset Third//
                        $OnThird = $Zero;

                        include 'ScoreUpdate.php';

                    }

                }

                //Runner on Second//
                if ($Game->Outs <= 2 AND $OnThird->ID == 0 AND $OnSecond->ID != 0){

                    //See if Runner Will Attempt To Move//
                    $Extra = RunExtraBase ($OnSecond);

                    if ($Extra == 1 OR $ThrowHome == 1){

                        //Player Tags Up And Moves To 3rd//
                        $OnThird = $OnSecond;
                        $OnSecond = $Zero;

                        #echo "<br>$OnThird->Name Tags Up on 2nd and Makes it to 3rd";

                    }

                }

                //Runner on 1st//
                if ($Game->Outs <= 2 AND $OnSecond->ID == 0 AND $OnFirst->ID != 0){

                    //See if Runner Will Attempt To Move//
                    $Extra = RunExtraBase ($OnFirst);

                    if ($Extra == 1 OR $ThrowHome == 1){

                        //Player Tags Up And Moves To 3rd//
                        $OnSecond = $OnFirst;
                        $OnFirst = $Zero;

                        #echo "<br>$OnSecond->Name Tags Up on 1st and Makes it to 2nd";

                    }

                }

            }

        }




    }

}

if ($SacFly == 0){
    $Batter->AB = $Batter->AB + 1;
}

$Batter->PA = $Batter->PA + 1;

if ($EarnedRuns > 0){
    #echo "<br>$Pitcher->Name +$EarnedRuns";
}