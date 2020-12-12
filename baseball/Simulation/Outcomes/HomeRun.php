<?php

//Init Variables//
$Runs = 1;
$EarnedRuns = 0;
$RBI = 1;

#echo "<br>$Batter->Name Hits a Home Run";

if ($Game->ErrorAfter2 == 0){
    $EarnedRuns = 1;
}

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

if ($OnFirst->ID != 0){

    $Runs = $Runs + 1;
    $RBI = $RBI + 1;

    #echo "<br>$OnFirst->Name Scores From 1st";

    if ($Game->ErrorAfter2 == 0 AND $OnFirst->ER != 0){ //Earned Run
        $EarnedRuns = $EarnedRuns + 1;
    }

    $OnFirst->Runs = $OnFirst->Runs + 1;

    //Reset Base//
    $OnFirst = $Zero;

}

//Stats//
$Batter->PA = $Batter->PA + 1;
$Batter->AB = $Batter->AB + 1;
$Batter->HR = $Batter->HR + 1;
$Batter->RBI = $Batter->RBI + $RBI;
$Batter->Runs = $Batter->Runs + 1;

$Pitcher->Batters = $Pitcher->Batters + 1;
$Pitcher->HitsAgainst = $Pitcher->HitsAgainst + 1;
$Pitcher->HRAgainst = $Pitcher->HRAgainst + 1;
$Pitcher->Runs = $Pitcher->Runs + $Runs;
$Pitcher->ER = $Pitcher->ER + $EarnedRuns;

//Score Update//
include 'ScoreUpdate.php';

//Next Batter//
include 'NextBatter.php';

if ($EarnedRuns > 0){
    #echo "<br>$Pitcher->Name +$EarnedRuns";
}