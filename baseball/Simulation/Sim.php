<?php

#Initialize Sim Variables#
list ($OnFirst,$OnSecond,$OnThird) = ResetBases($Zero);
$NewBat = 0;
$Fielder = $Zero;
$Catcher = $HC;
$Pitcher = $HP;
$Final = 0;

while ($Final == 0){

    ##Check For Game Ending Scenario##

    ##############Game Ending############

    if ($Game->Inn >= 9 AND $Game->HomeRuns > $Game->AwayRuns AND $Game->InnHalfSwitch == 1 ) { ##Game Ends, HomeWins
        $Final = 1;
        #echo "<h3>End Game 1 A: $Game->AwayRuns H: $Game->HomeRuns</h3>";
    }

    if ($Game->Inn >= 9 AND $Game->InnHalf == 2 AND  $Game->Outs == 3 AND $Game->HomeRuns != $Game->AwayRuns){ ##Game Ends, Away Wins
        $Final = 1;
        #echo "<h3>End Game 2 A: $Game->AwayRuns H: $Game->HomeRuns</h3>";
    }

    //Player Energy Loss//
    include 'Game/EnergyLoss.php';

    if ($Final == 0){ //Continue Game//
        if ($Game->InnSwitch == 1){ ##Reset Inning##

            $Game->InnSwitch = 0;
            $Game->Inn = $Game->Inn + 1;

        }

        if ($Game->InnHalfSwitch == 1){

            $Game->InnHalfSwitch = 0;
            $Game->ErrorAfter2 = 0;

            if ($Game->InnHalf == 1){
                $Game->InnHalf = 2;
            } else {
                $Game->InnHalf = 1;
            }

            $OnFirst = $Zero;
            $OnSecond = $Zero;
            $OnThird = $Zero;
            $Game->Outs = 0;

        }

        //Get The Correct Batter//
        include 'Game/VerifyBatter.php';

        if ($Game->InnHalf == 1){
            $Pitcher = $HP;
            $Catcher = $HC;
            $Second = $H2B;
            $First = $H1B;
            #echo "<br><br>AwayBat: $Game->AwayBat, $Batter->Name";
        } else {
            $Pitcher = $AP;
            $Catcher = $AC;
            $Second = $A2B;
            $First = $A1B;
            #echo "<br><br>HomeBat: $Game->HomeBat, $Batter->Name";
        }

        //Pitching Changes//
        include 'Game/PitcherChange.php';

        //Wild Pitch// Not Implemented Yet
        #include 'Game/WildPitch.php';

        //Pickoff// Not Implemented Yet
        #include 'Game/Pickoff.php';

        //Steal Base//
        include 'Game/Steal.php';

        if ($Game->Outs < 3){ //Continue At Bat

            //Outcome//
            include 'Game/Outcome.php';

            //Walk//
            if ($Outcome == "Walk"){
                include 'Outcomes/Walk.php';
            } elseif ($Outcome == "StrikeOut") {
                include 'Outcomes/Strikeout.php';
            } elseif ($Outcome == "Other") {

                //Bases -> PullSide -> HitType -> Location -> Out/Hit -> Fielding -> Baserunning. -> (If Out, Revert to Single)
                include 'Game/Contact.php';

                #echo "<br>Result: $Result";

                //Location -> Fielding//
                if ($Result == "1B"){
                    include 'Outcomes/Single.php';
                } elseif ($Result == "HR"){
                    include 'Outcomes/HomeRun.php';
                } elseif ($Result == "3B"){
                    include 'Outcomes/Triple.php';
                } elseif ($Result == "2B"){
                    include 'Outcomes/Double.php';
                } elseif ($Result == "Batted Ball"){
                    include 'Outcomes/BattedBall.php';
                }

                //Scoring//

            } else {
                #echo "<br>Some Kinda Fuckup";
            }

            //Batter Energy Loss//
            BatterEnergyLoss($Batter);

        }

        #echo "<br>Outs: $Game->Outs";

        ##Check Outs##
        if ($Game->Outs == 3){ ##Get New Inn Half/Inning

            $Game->InnHalfSwitch = 1;

            if ($Game->InnHalf == 2){
                $Game->InnSwitch = 1;
            }

        }

    }


}

