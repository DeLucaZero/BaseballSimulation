<?php
##Pitcher Loss## Energy Doesn't Drop Until After Effective Batters Reached

if ($Pitcher->Batters > $Pitcher->EffectiveBatters){ ##Start Fatigue

    #1.5 Energy Loss Per At Bat
    $Pitcher->Energy = $Pitcher->Energy - 15;

    ##Reset Effectiveness
    if ($Pitcher->Energy <= 79){
        $Pitcher->Effectiveness = 1000 - (1000 - $Pitcher->Energy);
    }

}