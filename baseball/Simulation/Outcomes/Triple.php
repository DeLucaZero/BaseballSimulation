<?php

//Init Variables//
$Runs = 0;
$EarnedRuns = 0;
$RBI = 0;

#echo "<br>$Batter->Name Hits a Triple";

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

//Move Batter to 3rd//
$OnThird = $Batter;

//Stats//
$Batter->PA = $Batter->PA + 1;
$Batter->AB = $Batter->AB + 1;
$Batter->Trips = $Batter->Trips + 1;
$Batter->RBI = $Batter->RBI + $RBI;

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