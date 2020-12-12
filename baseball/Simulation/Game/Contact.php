<?php

// Bases -> PullSide -> HitType -> Location -> Hit/Out -> Fielding -> Baserunning. -> (If Out, Revert to Single)


//PullSide// 40% Pull, 35% Center, 25% Opposite

if ($Batter->Hand == "R"){

    $R = 40;
    $C = 35;
    $L = 25;

} else {

    $R = 25;
    $C = 35;
    $L = 40;

}

$Roll = mt_rand(1,100);

if ($Roll <= $R){
    $Pull = "Right";
} elseif ($Roll <= $R + $C){
    $Pull = "Center";
} else {
    $Pull = "Left";
}


//Determine Fielding Tier//
if ($Game->InnHalf == 1) { //Away At Bat
    $FielderAvg = FieldingTier($H1B,$H2B,$H3B,$HSS,$HLF,$HCF,$HRF);
} else {
    $FielderAvg = FieldingTier($A1B,$A2B,$A3B,$ASS,$ALF,$ACF,$ARF);
}

//Pitcher Avg

$PitcherAvg = PitcherAvg($Pitcher);

$AvgInfluence = $PitcherAvg + $FielderAvg;

//Batter Avg

$BatterAvg = NewProjAvg($Pitcher,$Batter);

$Avg = $BatterAvg + ($BatterAvg * ($AvgInfluence / 1000));

$Roll = mt_rand(1,1000);

if ($Roll <= $Avg){ //Hit//

    //Bases//
    $PE = PitcherExtraBases($Pitcher);

    $Double = Proj2B($Pitcher, $Batter);
    $Double = $Double + ($Double * ($PE / 1000));

    $Triple = Proj3B($Pitcher, $Batter);
    $Triple = $Triple + ($Triple * ($PE / 1000));

    $HR = ProjHR($Pitcher, $Batter);
    $PHR = PitcherHR($Pitcher);
    $HR = $HR + ($HR * ($PHR / 1000));

    $Walk = Walk($Pitcher,$Catcher,$Batter);

    #cho "<br>Walk $Walk";

    $ExpBB = 270 * ($Walk / 1000);

    #echo "<br>ExpBB $ExpBB";
    $Chances = (270  - $ExpBB);

    #echo "Avg: $Avg";

    $Chances = round($Chances * ($Avg / 1000)) * 10;

    #echo "<br>Chances $Chances";

    $Roll = mt_rand(1,$Chances);

    #echo "<br>HR: $HR, 3B: $Triple, 2B $Double";

    if ($Roll <= $Double){ //2B
        $Result = "2B";
    } elseif ($Roll <= $Double + $Triple){ //3B
        $Result = "3B";
    } elseif ($Roll <= $Double + $Triple + $HR){ //HR
        $Result = "HR";
    } else { //Single
        $Result = "1B";
    }



} else { //Contact Out//

    //Hits all Considered Singles, Regardless of previous Roll//

    //Hit Type//

    //Fielding//

    //Advance Runners -> Tag Up based on Hit Type//

    $Result = "Batted Ball";

}