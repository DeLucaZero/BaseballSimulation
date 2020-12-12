<?php
##Insert BoxScore##
mysqli_query($DB,"INSERT INTO `boxscores`VALUES ('$GameID','$HomeTeam','$AwayTeam','$Game->H1R','$Game->H2R','$Game->H3R','$Game->H4R','$Game->H5R','$Game->H6R','$Game->H7R','$Game->H8R','$Game->H9R','$Game->H10R','$Game->HomeRuns','$Game->A1R','$Game->A2R','$Game->A3R','$Game->A4R','$Game->A5R','$Game->A6R','$Game->A7R','$Game->A8R','$Game->A9R','$Game->A10R','$Game->AwayRuns')") or die(mysqli_error($DB));

#Batting Stats##
for ($P = 1; $P <= 18; $P++){

    switch ($P){
        case 1:
            $Player = $HC;
            break;
        case 2:
            $Player = $H1B;
            break;
        case 3:
            $Player = $H2B;
            break;
        case 4:
            $Player = $HSS;
            break;
        case 5:
            $Player = $H3B;
            break;
        case 6:
            $Player = $HRF;
            break;
        case 7:
            $Player = $HCF;
            break;
        case 8:
            $Player = $HLF;
            break;
        case 9:
            $Player = $HDH;
            break;
        case 10:
            $Player = $AC;
            break;
        case 11:
            $Player = $A1B;
            break;
        case 12:
            $Player = $A2B;
            break;
        case 13:
            $Player = $ASS;
            break;
        case 14:
            $Player = $A3B;
            break;
        case 15:
            $Player = $ARF;
            break;
        case 16:
            $Player = $ACF;
            break;
        case 17:
            $Player = $ALF;
            break;
        case 18:
            $Player = $ADH;
            break;
    }

    #echo "<h2>P: $P ID: $Player->ID</h2>";

    if ($Player->AB > 0){
        $Avg = round(($Player->Hits + $Player->Dubs + $Player->Trips + $Player->HR) / $Player->AB,3);
        $OBP = round(($Player->Hits + $Player->Dubs + $Player->Trips + $Player->HR + $Player->BB) / ($Player->AB + $Player->BB),3);
        $Slg = round(($Player->Hits + ($Player->Dubs * 2) + ($Player->Trips * 3) + ($Player->HR * 4)) / ($Player->AB),3);
    } elseif ($Player->AB + $Player->BB > 0) {
        $Avg = 0;
        $OBP = round(($Player->Hits + $Player->Dubs + $Player->Trips + $Player->HR + $Player->BB) / ($Player->AB + $Player->BB),3);
        $Slg = 0;
    } else {
        $Avg = 0;
        $OBP = 0;
        $Slg = 0;
    }


    if ($Player->TC > 0){
        $FPct = round (($Player->PO + $Player->Asst) / $Player->TC,3);
    } else {
        $FPct = 000;
    }

    ##Game Statline##
    mysqli_query($DB,"INSERT INTO `stats_batting_game`(`GameID`,`TeamID`,`ID`,`Pos`,`PA`,`AB`,`Hits`,`2B`,`3B`,`HR`,`RBI`,`SO`,`BB`,`Runs`,`SB`,`CS`,`Avg`,`OBP`,`Slg`,`TC`,`PO`,`Asst`,`Errors`,`FPct`)VALUES('$GameID','$Player->TeamID','$Player->ID','$Player->Position','$Player->PA','$Player->AB','$Player->Hits','$Player->Dubs','$Player->Trips','$Player->HR','$Player->RBI','$Player->SO','$Player->BB','$Player->Runs','$Player->Steals','$Player->CS','$Avg','$OBP','$Slg','$Player->TC','$Player->PO','$Player->Asst','$Player->Errors','$FPct')") or die(mysqli_error($DB));

    if ($Player->TC > 0){
        #Season/Career StatLine#
        mysqli_query($DB,"UPDATE `stats_batting_career` SET `G`=`G`+1, `PA`=`PA`+'$Player->PA', `AB`=`AB`+'$Player->AB', `Hits`=`Hits`+'$Player->Hits', `2B`=`2B`+'$Player->Dubs', `3B`=`3B`+'$Player->Trips', `HR`=`HR`+'$Player->HR', `RBI`=`RBI`+'$Player->RBI', `SO`=`SO`+'$Player->SO', `BB`=`BB`+'$Player->BB', `Runs`=`Runs`+'$Player->Runs', `SB`=`SB`+'$Player->Steals', `CS`=`CS`+'$Player->CS', `TC`=`TC`+'$Player->TC', `PO`=`PO`+'$Player->PO', `Asst`=`Asst`+'$Player->Asst', `Errors`=`Errors`+'$Player->Errors', `Avg`=round((`Hits` + `2B` + `3B` + `HR`) / `AB`,3), `OBP`= round((`Hits` + `2B` + `3B` + `HR` + `BB`) / (`AB` + `BB`),3), `Slg`= round((`Hits` + (`2B` * 2) + (`3B` * 3) + (`HR` * 4)) / (`AB`),3), `FPct`= round((`PO`+`Asst`) / `TC`,3) WHERE `ID`='$Player->ID' ");
    } else {
        #Season/Career StatLine# (No Fielding Update, Player had no Chances)
        mysqli_query($DB,"UPDATE `stats_batting_career` SET `G`=`G`+1, `PA`=`PA`+'$Player->PA', `AB`=`AB`+'$Player->AB', `Hits`=`Hits`+'$Player->Hits', `2B`=`2B`+'$Player->Dubs', `3B`=`3B`+'$Player->Trips', `HR`=`HR`+'$Player->HR', `RBI`=`RBI`+'$Player->RBI', `SO`=`SO`+'$Player->SO', `BB`=`BB`+'$Player->BB', `Runs`=`Runs`+'$Player->Runs', `SB`=`SB`+'$Player->Steals', `CS`=`CS`+'$Player->CS', `TC`=`TC`+'$Player->TC', `PO`=`PO`+'$Player->PO', `Asst`=`Asst`+'$Player->Asst', `Errors`=`Errors`+'$Player->Errors', `Avg`=round((`Hits` + `2B` + `3B` + `HR`) / `AB`,3), `OBP`= round((`Hits` + `2B` + `3B` + `HR` + `BB`) / (`AB` + `BB`),3), `Slg`= round((`Hits` + (`2B` * 2) + (`3B` * 3) + (`HR` * 4)) / (`AB`),3) WHERE `ID`='$Player->ID' ");
    }

}

#Pitching Stats#

for ($P = 1; $P <= 2; $P++){

    switch ($P){
        case 1:
            $Player = $HP;
            break;
        case 2:
            $Player = $AP;
            break;
    }

    $IP = round($Player->Outs / 3,2);

    #echo "<h3>$Player->Outs</h3>";

    if ($IP > 0){
        $Whip = round(($Player->HitsAgainst + $Player->BB) / $IP,2);
        $ERA = round(($Player->ER * 9) / $IP,2);

        #echo "<br>ERA $ERA ($Player->ER) * 9 / $IP";
    } else {
        $Whip = 0;
        $ERA = 0;
    }

    ##Game Stats##
    mysqli_query($DB,"INSERT INTO `stats_pitching_game`(`GameID`,`TeamID`,`ID`,`Pos`,`AB`,`Outs`,`Hits`,`HR`,`Runs`,`ER`,`BB`,`SO`,`Whip`,`ERA`,`Result`) VALUES('$GameID','$Player->TeamID','$Player->ID','$Player->Position','$Player->Batters','$Player->Outs','$Player->HitsAgainst','$Player->HRAgainst','$Player->Runs','$Player->ER','$Player->BB','$Player->SO','$Whip','$ERA','')") or die(mysqli_error($DB));

    ##Season/Career Stats##
    mysqli_query($DB,"UPDATE `stats_pitching_career` SET `GP`=`GP`+1, `GS`=`GS`+'$Player->Start', `AB`=`AB`+'$Player->Batters', `Outs`=`Outs`+'$Player->Outs', `Hits`=`Hits`+'$Player->HitsAgainst', `HR`=`HR`+'$Player->HRAgainst', `Runs`=`Runs`+'$Player->Runs', `ER`=`ER`+'$Player->ER', `BB`=`BB`+'$Player->BB', `SO`=`SO`+'$Player->SO', `Whip`= round((`Hits`+`BB`) / (`Outs`/3),2), `ERA`= round((`ER`*9) / (`Outs`/3),2) WHERE `ID`='$Player->ID'");


}

if ($Game->HomeRuns > $Game->AwayRuns){ //Home Wins

    mysqli_query($DB,"UPDATE `teams` SET `Wins`=`Wins`+1, `HWins`=`HWins`+1 WHERE `ID`='$HomeTeam'")or die (mysqli_error($DB));
    mysqli_query($DB,"UPDATE `teams` SET `Loss`=`Loss`+1, `ALoss`=`ALoss`+1 WHERE `ID`='$AwayTeam'")or die (mysqli_error($DB));

} else {

    mysqli_query($DB,"UPDATE `teams` SET `Wins`=`Wins`+1, `AWins`=`AWins`+1 WHERE `ID`='$AwayTeam'")or die (mysqli_error($DB));
    mysqli_query($DB,"UPDATE `teams` SET `Loss`=`Loss`+1, `HLoss`=`HLoss`+1 WHERE `ID`='$HomeTeam'")or die (mysqli_error($DB));

}


?>

