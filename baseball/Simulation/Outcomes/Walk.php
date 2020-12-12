<?php
#echo "<br>$Pitcher->Name Walks $Batter->Name";

//Update Stats//
$Batter->PA = $Batter->PA + 1;
$Batter->BB = $Batter->BB + 1;
$Batter->ER = 1; ##Earned Runner
$Pitcher->BB = $Pitcher->BB + 1;
$Pitcher->Batters = $Pitcher->Batters + 1;

//Check for Bases Loaded//
if ($OnFirst->ID != 0 AND $OnSecond->ID != 0 AND $OnThird->ID != 0){ ##Bases Are Loaded

    ##Update Stats##
    $Pitcher->Runs = $Pitcher->Runs + 1;

    if ($Game->ErrorAfter2 == 0 AND $OnThird->ER != 0){
        $Pitcher->ER = $Pitcher->ER + 1;
    }

    $OnThird->Runs = $OnThird->Runs + 1;
    $Batter->RBI = $Batter->RBI + 1;

    #echo "<br>$OnThird->Name Scores due to Walk +RBI +1";

    ##Update Bases##
    $OnThird = $OnSecond;
    $OnSecond = $OnFirst;
    $OnFirst = $Zero;

    ##Update Score##
    $Runs = 1;

    include 'ScoreUpdate.php';

} else {

    ##Update Bases##
    $OnThird = $OnSecond;
    $OnSecond = $OnFirst;
    $OnFirst = $Zero;

}

##Put Batter on First##
$OnFirst = $Batter;

//Next Batter//
include 'NextBatter.php';
