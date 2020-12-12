<?php

$Winner = 0;
$Loser = 0;
$Save = 0;
$BlownSave = 0;

if ($Game->HomeRuns > $Game->AwayRuns){ ##Home Team Wins
    
    if ($Home->StarterFull == 1){ ##Starter has enough innings

        if ($Home->LastLeadGain == $Home->Starter){ ##Win for Starter

            if ($Home->Save == 1){ ##Save For Last Pitcher

                $Winner = $Home->Starter;
                $Save = $Home->LastPitcher;
                ##

            } else { ##No Save, just a win.

                $Winner = $Home->Starter;

            }

        } else { ##Find who got the last lead, give them win.

            if ($Home->Save == 1){ ##Save For Last Pitcher

                $Winner = $Home->LastLeadGain; ##Pitcher who got the lead
                $Save = $Home->LastPitcher;
                ##

            } else { ##No Save, just a win.

                $Winner = $Home->LastLeadGain;

            }


        }

    } else { ##Starter didn't play enough

        $Winner = $Home->LastLeadGain;

        if ($Home->Save == 1){ ##Save For Last Pitcher

            $Save = $Home->LastPitcher;
            ##

        }


    }


    if ($Away->StarterFull == 1){

        if ($Away->LastLeadLoss == $Away->Starter){ ##Starter lost the game

            $Loser = $Away->Starter;

        } else { ##Find who lost the game, and if blown save.

            if ($Away->Save == 1){ #Some douche blew the lead

                $Loser = $Away->LastPitcher;
                $BlownSave = $Away->LastPitcher;

            } else { #Not Blown Save, just a loss for last lead loser

                $Loser = $Away->LastLeadLoss;
            }

        }

    } else {

        if ($Away->Save == 1){ #Some douche blew the lead

            $Loser = $Away->LastPitcher;
            $BlownSave = $Away->LastPitcher;

        } else { #Not Blown Save, just a loss for last lead loser

            $Loser = $Away->LastLeadLoss;
        }

    }

} else { ###Away Team Won the Game

    if ($Away->StarterFull == 1){ ##Starter has enough innings

        if ($Away->LastLeadGain == $Away->Starter){ ##Win for Starter

            if ($Away->Save == 1){ ##Save For Last Pitcher

                $Winner = $Away->Starter;
                $Save = $Away->LastPitcher;
                ##

            } else { ##No Save, just a win.

                $Winner = $Away->Starter;

            }

        } else { ##Find who got the last lead, give them win.

            if ($Away->Save == 1){ ##Save For Last Pitcher

                $Winner = $Away->LastLeadGain; ##Pitcher who got the lead
                $Save = $Away->LastPitcher;
                ##

            } else { ##No Save, just a win.

                $Winner = $Away->LastLeadGain;

            }


        }

    } else { ##Starter didn't play enough

        $Winner = $Away->LastLeadGain;

        if ($Away->Save == 1){ ##Save For Last Pitcher

            $Save = $Away->LastPitcher;
            ##

        }


    }


    if ($Home->StarterFull == 1){

        if ($Home->LastLeadLoss == $Home->Starter){ ##Starter lost the game

            $Loser = $Home->Starter;

        } else { ##Find who lost the game, and if blown save.

            if ($Home->Save == 1){ #Some douche blew the lead

                $Loser = $Home->LastPitcher;
                $BlownSave = $Home->LastPitcher;

            } else { #Not Blown Save, just a loss for last lead loser

                $Loser = $Home->LastLeadLoss;
            }

        }

    } else {

        if ($Home->Save == 1){ #Some douche blew the lead

            $Loser = $Home->LastPitcher;
            $BlownSave = $Home->LastPitcher;

        } else { #Not Blown Save, just a loss for last lead loser

            $Loser = $Home->LastLeadLoss;
        }

    }

}

#echo "<h3>$Winner</h3>";

if ($Winner == 0){
    #echo "<h3>HomeLoss: $Home->LastLeadLoss HomeWin: $Home->LastLeadGain</h3>";
    #echo "<h3>AwayLoss: $Away->LastLeadLoss AwayWin: $Away->LastLeadGain</h3>";
}

if ($Winner == $Save){
    $Save = 0;
}

if ($Winner != 0){
    mysqli_query($DB,"UPDATE `stats_pitching_game` SET `Result`='Win' WHERE `ID`='$Winner' AND `GameID`='$GameID'") or die(mysqli_error($DB));
    mysqli_query($DB,"UPDATE `stats_pitching_career` SET `Wins`=`Wins`+1 WHERE `ID`='$Winner'") or die(mysqli_error($DB));
}

if ($Loser != 0){
    mysqli_query($DB,"UPDATE `stats_pitching_game` SET `Result`='Loss' WHERE `ID`='$Loser' AND `GameID`='$GameID'") or die(mysqli_error($DB));
    mysqli_query($DB,"UPDATE `stats_pitching_career` SET `Loss`=`Loss`+1 WHERE `ID`='$Loser'") or die(mysqli_error($DB));
}

if ($Save != 0){
    mysqli_query($DB,"UPDATE `stats_pitching_game` SET `Result`='Save' WHERE `ID`='$Save' AND `GameID`='$GameID'") or die(mysqli_error($DB));
    mysqli_query($DB,"UPDATE `stats_pitching_career` SET `Sv`=`Sv`+1 WHERE `ID`='$Save'") or die(mysqli_error($DB));
}

if ($BlownSave != 0){

    if ($Loser == $BlownSave){
        mysqli_query($DB,"UPDATE `stats_pitching_game` SET `Result`='Loss/BSv' WHERE `ID`='$BlownSave' AND `GameID`='$GameID'") or die(mysqli_error($DB));
    } else {
        mysqli_query($DB,"UPDATE `stats_pitching_game` SET `Result`='BSv' WHERE `ID`='$BlownSave' AND `GameID`='$GameID'") or die(mysqli_error($DB));
    }

    mysqli_query($DB,"UPDATE `stats_pitching_career` SET `BSv`=`BSv`+1 WHERE `ID`='$BlownSave'") or die(mysqli_error($DB));
}