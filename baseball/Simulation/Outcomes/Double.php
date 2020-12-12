<?php

//Init Variables//
$Runs = 0;
$EarnedRuns = 0;
$RBI = 0;
$Error = 0;

include 'DoubleLoc.php';

#echo "<br>$Batter->Name Doubles to $HitLoc";


////Runner On Third////

if ($OnThird->ID != 0){

    $Runs = $Runs + 1;
    $RBI = $RBI + 1;

    #echo "<br>$OnThird->Name Scores From 3rd";

    if ($Game->ErrorAfter2 == 0 AND $OnThird->ER != 0){ //Earned Run
        $EarnedRuns = $EarnedRuns + 1;
    }

    $OnThird->Runs = $OnThird->Runs + 1;

    //Reset Base//
    $OnThird = $Zero;

}

////Runner On Second////

if ($OnSecond->ID != 0){

    $Runs = $Runs + 1;
    $RBI = $RBI + 1;

    #echo "<br>$OnSecond->Name Scores From 2nd";

    if ($Game->ErrorAfter2 == 0 AND $OnSecond->ER != 0){ //Earned Run
        $EarnedRuns = $EarnedRuns + 1;
    }

    $OnSecond->Runs = $OnSecond->Runs + 1;

    //Reset Base//
    $OnSecond = $Zero;

}


//Runner on First//

if ($OnFirst->ID != 0){

    //Move Runner to 3rd//
    $OnThird = $OnFirst;

    //Reset 1B//
    $OnFirst = $Zero;

    //Fielding//
    $ErrorChance = GloveError($Defender);

    $Roll = mt_rand(1,1000);

    if ($Roll <= $ErrorChance){
        $Error = 1; //Doesn't Count As Actual Error Unless Runner is able to advance.

        #echo "<br>$Defender->Name Has Trouble Fielding The Ball";
    }

    if ($Error == 1){

        if ($HitLoc == "Deep Left" OR $HitLoc == "Deep Center" OR $HitLoc == "Deep Right"){ //Uncontested, Error Given//

            #echo "<br>$OnThird->Name Scores Uncontested due to $Defender->Name's Error +RBI +ER (May Have Scored Anyway)";
            $Runs = $Runs + 1;
            $RBI = $RBI + 1;

            if ($Game->ErrorAfter2 == 0 AND $OnThird->ER != 0){
                $EarnedRuns = $EarnedRuns + 1;
            }

            $Defender->TC = $Defender->TC + 1;
            $Defender->Errors = $Defender->Errors + 1;
            $OnThird->Runs = $OnThird->Runs + 1;

        } else { //Check to see if Runner will try and Advance Home//

            //Roll for Run Home//
            $Extra = RunExtraBase ($OnThird);

            if ($Extra == 1){

                #echo ", And Attempts To Score";

                $Success = ScoreFromThird($OnThird,$Defender,$Catcher);

                if ($Success == 1){ //Runner Scores//
                    $RBI = $RBI + 1;
                    $OnThird->Runs = $OnThird->Runs + 1;

                    if ($Game->ErrorAfter2 >= 1 OR $OnThird->ER == 0){ //No Earned Runs->Error After 2 Outs//
                        $Runs = $Runs + 1;
                        #echo "<br>$OnThird->Name Scores Unearned from 1st +RBI";
                    } elseif ($OnThird->ER != 0){ //Earned Run
                        $Runs = $Runs + 1;
                        $EarnedRuns = $EarnedRuns + 1;
                        #echo "<br>$OnThird->Name Scores an ER from 1st +RBI";
                    }


                } else { //Thrown Out//

                    //Defender Arm Error Check//
                    $ThrowHomeError = ArmError($Defender);

                    $Roll = mt_rand(1,1000);

                    if ($Roll <= $ThrowHomeError){ //Throwing Error->Error Assigned->No Earned Run->No RBI//

                        $Defender->TC = $Defender->TC + 1;
                        $Defender->Errors = $Defender->Errors + 1;
                        $Runs = $Runs + 1;
                        $OnThird->Runs = $OnThird->Runs + 1;
                        #echo "<br>$OnThird->Name Scores from 1st due to $Defender->Name Error";

                        if ($Game->Outs == 2){
                            $Game->ErrorAfter2 = 1;
                        }

                    } else {
                        $Game->Outs = $Game->Outs + 1;
                        $Pitcher->Outs = $Pitcher->Outs + 1;
                        $Defender->TC = $Defender->TC + 1;
                        $Defender->Asst = $Defender->Asst + 1;
                        $Catcher->PO = $Catcher->PO + 1;
                        $Catcher->TC = $Catcher->TC + 1;
                        #echo "<br>$OnThird->Name gets thrown out at Home by $Defender->Name";
                    }

                }

            }

        }

    } else {

        if ($HitLoc == "Deep Left" OR $HitLoc == "Deep Center" OR $HitLoc == "Deep Right"){ //Possible Attempt Home//

            //Roll for Run Home//
            $Extra = RunExtraBase ($OnThird);

            if ($Extra == 1){

                #echo ", And Attempts To Score";

                $Success = ScoreFromThird($OnThird,$Defender,$Catcher);

                if ($Success == 1){ //Runner Scores//
                    $RBI = $RBI + 1;
                    $OnThird->Runs = $OnThird->Runs + 1;

                    if ($Game->ErrorAfter2 >= 1 OR $OnThird->ER == 0){ //No Earned Runs->Error After 2 Outs//
                        $Runs = $Runs + 1;
                        #echo "<br>$OnThird->Name Scores Unearned from 1st +RBI";
                    } elseif ($OnThird->ER != 0){ //Earned Run
                        $Runs = $Runs + 1;
                        $EarnedRuns = $EarnedRuns + 1;
                        #echo "<br>$OnThird->Name Scores an ER from 1st +RBI";
                    }


                } else { //Thrown Out//

                    //Defender Arm Error Check//
                    $ThrowHomeError = ArmError($Defender);

                    $Roll = mt_rand(1,1000);

                    if ($Roll <= $ThrowHomeError){ //Throwing Error->Error Assigned->No Earned Run->No RBI//

                        $Defender->TC = $Defender->TC + 1;
                        $Defender->Errors = $Defender->Errors + 1;
                        $Runs = $Runs + 1;
                        $OnThird->Runs = $OnThird->Runs + 1;
                        #echo "<br>$OnThird->Name Scores from 1st due to $Defender->Name Error";

                        if ($Game->Outs == 2){
                            $Game->ErrorAfter2 = 1;
                        }

                    } else {
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

            }

        }

    }

}

//Move Batter To 2nd//
$OnSecond = $Batter;

//Stats//
$Batter->PA = $Batter->PA + 1;
$Batter->AB = $Batter->AB + 1;
$Batter->Dubs = $Batter->Dubs + 1;
$Batter->RBI = $Batter->RBI + $RBI;

$Pitcher->Batters = $Pitcher->Batters + 1;
$Pitcher->HitsAgainst = $Pitcher->HitsAgainst + 1;
$Pitcher->Runs = $Pitcher->Runs + $Runs;
$Pitcher->ER = $Pitcher->ER + $EarnedRuns;

//Score Update//
include 'ScoreUpdate.php';

//Next Batter//
include 'NextBatter.php';
