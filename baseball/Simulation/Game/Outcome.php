<?php

$Walk = Walk($Pitcher,$Catcher,$Batter);

$Roll = mt_rand(1,1000);

if ($Roll <= $Walk){

    $Outcome = 'Walk';

} else {

    $StrikeOut = NewStrikeout($Pitcher,$Batter,$Catcher);

    #echo "<br>SO: $StrikeOut";

    $CatcherSO = CatcherStrikeout($Catcher);

    $StrikeOut = $StrikeOut + ($StrikeOut * ($CatcherSO / 1000));

    $StrikeOut = $StrikeOut * 10;

    #echo " CatcherSO: $CatcherSO TotalSO: $StrikeOut";

    $Roll = mt_rand(1,10000);

    if ($Roll <= $StrikeOut){
        $Outcome = 'StrikeOut';
    } else {
        $Outcome = 'Other';
    }

}


