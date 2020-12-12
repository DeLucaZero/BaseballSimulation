<?php

$Switch = 0;
$NewPos = '';
$CLSwap = 0;
$NormalSwap = 0; ##Progress through Bullpen
$OTSwap = 0; ##Swap out CL in Extra Innings - IF RP is still available

if ($Game->InnHalf == 1){
    $Team = $Home;
    $Runs = $Game->HomeRuns;
    $OppRuns = $Game->AwayRuns;
} else {
    $Team = $Away;
    $Runs = $Game->AwayRuns;
    $OppRuns = $Game->HomeRuns;
}


##Energy Hook Swap##
if ($Pitcher->HookEnergy > $Pitcher->Energy){ ##Swap
    $Switch = 1;
    #echo "<br>Pitcher hooked based on Energy";
}

##CL Swap for Save##
if ($Game->Inn >= 9 AND $Team->UseCL == 1 AND $Runs > $OppRuns AND ($OppRuns + 3) >= $Runs AND $Team->CloserSwitch == 0 ){

    $Team->Save = 1; ##SaveOpportunity
    $CLSwap = 1;
    $Switch = 1;
    #echo "<br>Pitcher hooked for CL Save";

}

if ($Team->Save == 0 AND $Game->Inn >= 10 AND $Team->OTSwap == 1 AND $Team->Pitcher <= 3){
    $OTSwap = 1;
    $Switch = 1;

    #echo "<br>Pitcher hooked for OT Reliever";
}

if ($Pitcher->Position == "SP" AND $Pitcher->HitsAgainst == 0 OR $Pitcher->Position != "SP" AND $Pitcher->Runs == 0){
    $Switch = 0;
}


if ($Team->Pitcher == 5){ ##No Available Pitchers, Can't Switch
    $Switch = 0;
}

if ($Switch == 1){ ##Pitcher is being swapped out

    if ($CLSwap == 0 AND $OTSwap == 0){
        $NormalSwap = 1;
    }

    if ($CLSwap == 1){ #Swap to CL For Save Situation#

        $NewPos = 'CL1';
        $Team->CloserSwitch = 1;

    } elseif ($NormalSwap == 1) {

        switch ($Team->Pitcher){
            case 1: #First Reliever#
                $NewPos = 'RP1';
                break;
            case 2:
                $NewPos = 'RP2';
                break;
            Case 3:
                $NewPos = 'RP3';
                break;
            case 4:
                $NewPos = 'CL1';
                break;
        }

        $Team->Pitcher = $Team->Pitcher + 1;

    } elseif ($OTSwap == 1) {

        if ($Team->Pitcher <= 3){ ##Pitcher Available##

            switch ($Team->Pitcher){
                case 1: #First Reliever#
                    $NewPos = 'RP1';
                    break;
                case 2:
                    $NewPos = 'RP2';
                    break;
                Case 3:
                    $NewPos = 'RP3';
                    break;
            }

            $Team->Pitcher = $Team->Pitcher + 1;

        }

    }

    $IP = round($Pitcher->Outs / 3,2);

    if ($IP > 0){
        $Whip = round(($Pitcher->HitsAgainst + $Pitcher->BB) / $IP,2);
        $ERA = round(($Pitcher->ER * 9) / $IP,2);
    } else {
        $Whip = 0;
        $ERA = 0;
    }

    if ($Team->Starter == $Pitcher->ID){
        if ($IP >= 5){
            $Team->StarterFull = 1;
        }
    }
    
    ##Game Stats##
    $Player = $Pitcher;
    mysqli_query($DB,"INSERT INTO `stats_pitching_game`(`GameID`,`TeamID`,`ID`,`Pos`,`AB`,`Outs`,`Hits`,`HR`,`Runs`,`ER`,`BB`,`SO`,`Whip`,`ERA`,`Result`) VALUES('$GameID','$Player->TeamID','$Player->ID','$Player->Position','$Player->Batters','$Player->Outs','$Player->HitsAgainst','$Player->HRAgainst','$Player->Runs','$Player->ER','$Player->BB','$Player->SO','$Whip','$ERA','')") or die(mysqli_error($DB));
    ##Season/Career Stats##
    mysqli_query($DB,"UPDATE `stats_pitching_career` SET `GP`=`GP`+1, `GS`=`GS`+'$Pitcher->Start', `AB`=`AB`+'$Pitcher->Batters', `Outs`=`Outs`+'$Pitcher->Outs', `Hits`=`Hits`+'$Pitcher->HitsAgainst', `HR`=`HR`+'$Pitcher->HRAgainst', `Runs`=`Runs`+'$Pitcher->Runs', `ER`=`ER`+'$Pitcher->ER', `BB`=`BB`+'$Pitcher->BB', `SO`=`SO`+'$Pitcher->SO', `Whip`= round((`Hits`+`BB`) / (`Outs`/3),2), `ERA`= round((`ER`*9) / (`Outs`/3),2) WHERE `ID`='$Pitcher->ID'");

    $PitcherPos = substr($NewPos, 0, -1);

    if ($Game->InnHalf == 1) { #New Home Pitcher#
        $HP = new Pitcher($DB, $HomeTeam, $HomePLineup[$NewPos], "Home", $PitcherPos);
        $Home->LastPitcher = $HP->ID;
        $Pitcher = $HP;
    } else {
        $AP = new Pitcher($DB, $AwayTeam, $AwayPLineup[$NewPos], "Away", $PitcherPos);
        $Away->LastPitcher = $AP->ID;
        $Pitcher = $AP;
    }

}