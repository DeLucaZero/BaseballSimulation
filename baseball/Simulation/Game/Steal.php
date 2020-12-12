<?php

$StealAttempt = 0;

//Check if Runner in Position For 2nd Base Steal//

if ($OnFirst->ID != 0 AND $OnSecond->ID == 0){

    //Runner is in Position to Steal//

    $StealAttempt = AttemptSteal($OnFirst);

    if ($StealAttempt == 1){

        $StealSuccessChance = StealSuccessPct($OnFirst);

        #echo "<br>Steal Success: $StealSuccessChance";

        $CatchStealPct = CatchStealer($Catcher);

        #echo " CatchRunner $CatchStealPct";

        $StealSuccessChance = $StealSuccessChance + ($StealSuccessChance * ($CatchStealPct / 1000));

        #echo " Chance $StealSuccessChance";

        $Roll = mt_rand(1,1000);

        if ($Roll > $StealSuccessChance){ //Runner Caught

            //ADD Glove Error Check// --------------------
            $Catcher->TC = $Catcher->TC + 1;
            $Catcher->Asst = $Catcher->Asst + 1;
            $Catcher->CatchSteal = $Catcher->CatchSteal + 1;
            $OnFirst->CS = $OnFirst->CS + 1;
            $Second->TC = $Second->TC + 1;
            $Second->PO = $Second->PO + 1;
            $Pitcher->Outs = $Pitcher->Outs + 1;

            #echo "<br>$OnFirst->Name Tries to steal 2nd, but gets thrown out by $Catcher->Name";

            $Game->Outs = $Game->Outs + 1;
            $OnFirst = $Zero;


        } else { //Successful Steal//

            $OnSecond = $OnFirst;
            $OnFirst = $Zero;

            $OnSecond->Steals = $OnSecond->Steals + 1;
            $Catcher->CSA = $Catcher->CSA + 1;

            #echo "<br>$OnSecond->Name Successfully steals 2nd";

        }

    }


} elseif ($OnSecond->ID != 0 AND $OnThird->ID == 0){ //Runner in position for 2nd->3rd Steal

}

