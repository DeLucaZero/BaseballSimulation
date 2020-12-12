<?php

if ($Game->InnHalf == 1){ ##Update Away Score##

    if ($Game->AwayRuns <= $Game->HomeRuns) {##Home Has Lead

        if ($Game->AwayRuns + $Runs > $Game->HomeRuns){ #Lead Change#

            $Home->LastLeadLoss = $Pitcher->ID;
            $Away->LastLeadGain = $AP->ID;

        }

    }

    if ($Game->Inn <= 9){
        $Inn = "A".$Game->Inn."R";
    } else {
        $Inn = "A10R";
    }

    $Game->AwayRuns = $Game->AwayRuns + $Runs;
    $Game->$Inn = $Game->$Inn + $Runs;

} else {

    if ($Game->Inn <= 9){
        $Inn = "H".$Game->Inn."R";
    } else {
        $Inn = "H10R";
    }

    if ($Game->HomeRuns <= $Game->AwayRuns) {##Away Has Lead

        if ($Game->HomeRuns + $Runs > $Game->AwayRuns){ #Lead Change#

            $Away->LastLeadLoss = $Pitcher->ID;
            $Home->LastLeadGain = $HP->ID;

        }

    }

    $Game->HomeRuns = $Game->HomeRuns + $Runs;
    $Game->$Inn = $Game->$Inn + $Runs;

}

$Runs = 0;