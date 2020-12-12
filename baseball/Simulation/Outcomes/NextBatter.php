<?php

if ($Game->InnHalf == 1){ ##Next Away Batter

    if ($Game->AwayBat == 9){#Reset Order
        $Game->AwayBat = 1;
    } else {
        $Game->AwayBat = $Game->AwayBat + 1;
    }

} else { #Update Home Batter#

    if ($Game->HomeBat == 9){
        $Game->HomeBat = 1;
    } else {
        $Game->HomeBat = $Game->HomeBat + 1;
    }

}