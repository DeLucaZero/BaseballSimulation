<?php

if ($Game->InnHalf == 1){ ##Away At Bat##

    for ($I = 1; $I <= 9; $I++){

        switch ($I){
            case 1:
                $Check = $AC;
                break;
            case 2:
                $Check = $A1B;
                break;
            case 3:
                $Check = $A2B;
                break;
            case 4:
                $Check = $ASS;
                break;
            case 5:
                $Check = $A3B;
                break;
            case 6:
                $Check = $ARF;
                break;
            case 7:
                $Check = $ACF;
                break;
            case 8:
                $Check = $ALF;
                break;
            case 9:
                $Check = $ADH;
                break;
        }

        if ($Check->BatPos == $Game->AwayBat){
            $Batter = $Check;
        }

    }

} else { ##Home Batter

    for ($I = 1; $I <= 9; $I++){

        switch ($I){
            case 1:
                $Check = $HC;
                break;
            case 2:
                $Check = $H1B;
                break;
            case 3:
                $Check = $H2B;
                break;
            case 4:
                $Check = $HSS;
                break;
            case 5:
                $Check = $H3B;
                break;
            case 6:
                $Check = $HRF;
                break;
            case 7:
                $Check = $HCF;
                break;
            case 8:
                $Check = $HLF;
                break;
            case 9:
                $Check = $HDH;
                break;
        }

        if ($Check->BatPos == $Game->HomeBat){
            $Batter = $Check;
        }

    }
}