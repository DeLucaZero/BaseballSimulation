<?php

//Init Variables//
$Error = 0;
$Runs = 0;
$EarnedRuns = 0;
$RBI = 0;
$ThrowHomeError = 0;
$ThrowHome = 0;

//Hit Location//
include 'SingleLoc.php';

#echo "<br>$Batter->Name Singles to $HitLoc";

//Fielding//
$ErrorChance = GloveError($Defender);

$Roll = mt_rand(1,1000);

if ($Roll <= $ErrorChance){
    $Error = 1; //Doesn't Count As Actual Error Unless Runner is able to advance.

    #echo "<br>$Defender->Name Has Trouble Fielding The Ball";
} else {
    $Error = 0;
}

//BaseRunning
if ($OnFirst->ID != 0 OR $OnSecond->ID != 0 OR $OnThird->ID != 0) {

    ////Third Base Runner////

    if ($OnThird->ID != 0){ //Runner On Third.

        if ($Error == 1){ //Didn't field Correctly->Error not charged due to already being in scoring position//

            $OnThird->Runs = $OnThird->Runs + 1;

            //Team Runs, Pitcher Runs//
            if ($Game->ErrorAfter2 >= 1 OR $OnThird->ER == 0){ //No Earned Runs->Error After 2 Outs//
                $Runs = $Runs + 1;
                $RBI = 1;
                #echo "<br>$OnThird->Name Scores Unearned from 3rd +RBI";
            } elseif ($OnThird->ER != 0){ //Earned Run
                $Runs = $Runs + 1;
                $RBI = $RBI + 1;
                $EarnedRuns = $EarnedRuns + 1;
                #echo "<br>$OnThird->Name Scores an ER from 3rd +RBI";
            }

        } else {

            if ($HitLoc == "Shallow Left" OR $HitLoc == "Shallow Left Left" OR $HitLoc == "Shallow Left Right" OR $HitLoc = "Shallow Center Left" OR $HitLoc = "Shallow Center Right" OR $HitLoc = "Shallow Center"){ //Chance to throw out at Home.//

                $Success = ScoreFromThird($OnThird,$Defender,$Catcher);
                $ThrowHome = 1;

                if ($Success == 1){ //Runner Scores//
                    $RBI = $RBI + 1;
                    $OnThird->Runs = $OnThird->Runs + 1;

                    if ($Game->ErrorAfter2 >= 1 OR $OnThird->ER == 0){ //No Earned Runs->Error After 2 Outs//
                        $Runs = $Runs + 1;
                        #echo "<br>$OnThird->Name Scores Unearned from 3rd +RBI";
                    } elseif ($OnThird->ER != 0){ //Earned Run
                        $Runs = $Runs + 1;
                        $EarnedRuns = $EarnedRuns + 1;
                        #echo "<br>$OnThird->Name Scores an ER from 3rd +RBI";
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
                        #echo "<br>$OnThird->Name Scores from 3rd due to $Defender->Name Error";

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

            } elseif ($HitLoc != "Infield Left") { //Runner Scores//

                //Team Runs, Pitcher Runs//
                if ($Game->ErrorAfter2 >= 1 OR $OnThird->ER == 0){ //No Earned Runs->Error After 2 Outs//
                    $Runs = $Runs + 1;
                    $RBI = $RBI + 1;
                    #echo "<br>$OnThird->Name Scores from 3rd Unearned and Uncontested +RBI";
                } elseif ($OnThird->ER != 0){ //Earned Run
                    $Runs = $Runs + 1;
                    $RBI = $RBI + 1;
                    $EarnedRuns = $EarnedRuns + 1;
                    #echo "<br>$OnThird->Name Scores from 3rd ER and Uncontested +RBI";
                }

            }

        }

        $OnThird = $Zero;

    }

    ////Second Base Runner////

    if ($Game->Outs <= 2 AND $OnSecond->ID != 0){ //Runner on Second//

        //Move to Third//
        $OnThird = $OnSecond;
        #echo "<br>$OnThird->Name Reaches 3rd";

        ////Extra Bases////

        if ($ThrowHome == 0){ //Ball Still In Play, Go For Extra//

            if ($Error == 1){ //Possible Scoring Chance Based On Location//

                //Mid Locations, Chance To Score//
                if ($HitLoc == "Mid Right" OR $HitLoc == "Mid Center" OR $HitLoc == "Mid Left"){ //Mid OutField Hit Location, Chance to Stay At Third or Attempt Home/ThrowOut//

                    //Check To See If Runner Attempts Extra Base->Based on Speed//
                    $Extra = RunExtraBase ($OnThird);

                    if ($Extra == 1){ //Runner Will Try For Home//

                        $Success = ScoreFromThird($OnThird,$Defender,$Catcher);

                        if ($Success == 1){ //Runner Scores->Fielder Gets An Error->Unearned Run//
                            $RBI = $RBI + 1;
                            $OnThird->Runs = $OnThird->Runs + 1;
                            $Runs = $Runs + 1;

                            $Defender->TC = $Defender->TC + 1;
                            $Defender->Errors = $Defender->Errors + 1;

                            #echo "Resulting in an Error, as $Batter->Name Reaches 2B";
                            #echo "<br>$OnThird->Name Scores Unearned from 2nd +RBI";



                        } else { //Thrown Out//

                            //Defender Arm Error Check//
                            $ThrowHomeError = ArmError($Defender);

                            $Roll = mt_rand(1,1000);

                            if ($Roll <= $ThrowHomeError){ //Throwing Error->Error Assigned->No Earned Run->No RBI//

                                $Defender->TC = $Defender->TC + 1;
                                $Defender->Errors = $Defender->Errors + 1;
                                $Runs = $Runs + 1;
                                $OnThird->Runs = $OnThird->Runs + 1;
                                #echo "<br>$OnThird->Name Scores from 2nd due to $Defender->Name Error";

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

                //Deep Hit Locations->Automatic Score//
                if ($HitLoc == "Deep Right" OR $HitLoc == "Deep Center" OR $HitLoc == "Deep Left"){ //Runner Scores//

                    //Team Runs, Pitcher Runs//
                    if ($Game->ErrorAfter2 >= 1 OR $OnThird->ER == 0){ //No Earned Runs->Error After 2 Outs//
                        $Runs = $Runs + 1;
                        $RBI = $RBI + 1;
                        $OnThird->Runs = $OnThird->Runs + 1;
                        #echo "<br>$OnThird->Name Scores from 2nd Unearned and Uncontested +RBI";
                    } elseif ($OnThird->ER != 0){ //Earned Run
                        $Runs = $Runs + 1;
                        $RBI = $RBI + 1;
                        $EarnedRuns = $EarnedRuns + 1;
                        $OnThird->Runs = $OnThird->Runs + 1;
                        #echo "<br>$OnThird->Name Scores from 2nd ER and Uncontested +RBI";
                    }

                } elseif ($HitLoc == "Mid Right" OR $HitLoc == "Mid Center" OR $HitLoc == "Mid Left"){ //Mid OutField Hit Location, Chance to Stay At Third or Attempt Home/ThrowOut//

                    //Check To See If Runner Attempts Extra Base->Based on Speed//
                    $Extra = RunExtraBase ($OnThird);

                    if ($Extra == 1){ //Runner Will Try For Home//

                        $Success = ScoreFromThird($OnThird,$Defender,$Catcher);

                        if ($Success == 1){ //Runner Scores//
                            $RBI = $RBI + 1;
                            $OnThird->Runs = $OnThird->Runs + 1;

                            if ($Game->ErrorAfter2 >= 1 OR $OnThird->ER == 0){ //No Earned Runs->Error After 2 Outs//
                                $Runs = $Runs + 1;
                                #echo "<br>$OnThird->Name Scores Unearned from 2nd +RBI";
                            } elseif ($OnThird->ER != 0){ //Earned Run
                                $Runs = $Runs + 1;
                                $EarnedRuns = $EarnedRuns + 1;
                                #echo "<br>$OnThird->Name Scores an ER from 2nd +RBI";
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
                                #echo "<br>$OnThird->Name Scores from 2nd due to $Defender->Name Error";

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

                        $OnThird = $Zero;

                    }

                }



            }

        }

        //Reset Base//
        $OnSecond = $Zero;

    }

    ////First Base Runner////

    if ($Game->Outs <= 2 AND $OnFirst->ID != 0){

        //Move To Second//
        $OnSecond = $OnFirst;
        #echo "<br>$OnSecond->Name reaches 2B";
        //Reset//
        $OnFirst = $Zero;

        //Extra Bases//
        if ($ThrowHome == 0 AND $OnThird->ID == 0){

            if ($Error == 1){

                //See if Runner Rolls For Extra Base//
                $Extra = RunExtraBase ($OnSecond);

                if ($Extra == 1){

                    //Move to Third//
                    $OnThird = $OnSecond;

                    //Reset Second//
                    $OnSecond = $Zero;

                    //Roll for Run Home//
                    $Extra = RunExtraBase ($OnThird);

                    if ($Extra == 1){ //Throw Home//

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

            } else {

                //Mid/Deep Center and Mid/Deep Right and Deep Left Chance for Extra Base//
                if ($HitLoc == "Mid Center" OR $HitLoc == "Deep Center" OR $HitLoc == "Mid Right" OR $HitLoc == "Deep Right" OR $HitLoc == "Deep Left"){

                    //Check To See If Runner Attempts Extra Base->Based on Speed//
                    $Extra = RunExtraBase ($OnSecond);

                    if ($Extra == 1){ //Advance Runner//

                        $OnThird = $OnSecond;
                        $OnSecond = $Zero;
                        #echo " And Continues to 3rd";

                        //Check for 2nd Extra Base//
                        if ($HitLoc == "Deep Center" OR $HitLoc == "Deep Right"){

                            $Extra = RunExtraBase ($OnThird);

                            if ($Extra == 1){ //Throw Home//

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

                                $OnThird = $Zero;

                            }

                        }

                    }

                }


            }

        }

    }

    if ($Game->Outs <= 2){
        $OnFirst = $Batter;
    }

} else { //Bases Empty, Advance Runner To First//

    $OnFirst = $Batter;

    if ($Error == 1){ //Fielder Didn't field it cleanly, check for chance to advance.

        if ($HitLoc == "Deep Right" OR $HitLoc == "Deep Left"){ //Chance to Advance a base//

            //Speed Check//
            $Chance = RunExtraBase($Batter);

            $Roll = mt_rand(1,1000);

            if ($Roll <= $Chance){ //Advance runner, Error Given.

                //Error//
                $Defender->Errors = $Defender->Errors + 1;
                #echo "Resulting in an Error, as $Batter->Name Reaches 2B";

                //Move Runner//
                $OnSecond = $Batter;
                $OnFirst = $Zero;

            }

        }

    }

}

//Stats//
$Batter->PA = $Batter->PA + 1;
$Batter->AB = $Batter->AB + 1;
$Batter->Hits = $Batter->Hits + 1;
$Batter->RBI = $Batter->RBI + $RBI;
$Batter->ER = $Pitcher->ID;
$Pitcher->Batters = $Pitcher->Batters + 1;
$Pitcher->HitsAgainst = $Pitcher->HitsAgainst + 1;
$Pitcher->Runs = $Pitcher->Runs + $Runs;
$Pitcher->ER = $Pitcher->ER + $EarnedRuns;

//Score Update//
include 'ScoreUpdate.php';

//Next Batter//
include 'NextBatter.php';

if ($EarnedRuns > 0){
    #echo "<br>$Pitcher->Name +$EarnedRuns";
}