<?php
function ResetBases($Blank){
    return array($Blank,$Blank,$Blank);
}

function Walk($Pitcher, $Catcher, $Batter){

    ##echo "PWalk: $PWalk<br>";
    ##echo "BWalk: $BWalk<br>";

    $Walk = round((PitcherWalk($Pitcher) + BatterWalk($Batter,$Pitcher)) / 2);

    return $Walk;


}

function ProjHR($Pitcher, $Batter){

    if ($Pitcher->Hand == 'R'){
        $Slug = (($Batter->ConR * .1) + ($Batter->SlugR * .9)) * ($Batter->Effectiveness / 1000);
    } else {
        $Slug = (($Batter->ConL * .1) + ($Batter->SlugL * .9)) * ($Batter->Effectiveness / 1000);
    }

    //1 - 0.1
    //10 - 1
    //20 - 1.5
    //30 - 2
    //40   4
    //50   8
    //60 - 12
    //70 - 18
    //80 - 22
    //90 - 26
    //100 - 28
    //110 - 30

    if ($Slug <= 1){
        $Chance = 1;
    } elseif ($Slug <= 10){
        $Chance = 1 + (($Slug - 1));
    } elseif ($Slug <= 20){
        $Chance = 15 + (($Slug - 10) * 2.5);
    } elseif ($Slug <= 30){
        $Chance = 40 + (($Slug - 20) * 1);
    } elseif ($Slug <= 40){
        $Chance = 50 + (($Slug - 30) * 1);
    } elseif ($Slug <= 50){
        $Chance = 60 + (($Slug - 40) * 1);
    } elseif ($Slug <= 60){
        $Chance = 80 + (($Slug - 50) * 2);
    } elseif ($Slug <= 70){
        $Chance = 120 + (($Slug - 60) * 4);
    } elseif ($Slug <= 80){
        $Chance = 160 + (($Slug - 70) * 4);
    } elseif ($Slug <= 90){
        $Chance = 180 + (($Slug - 80) * 2);
    } elseif ($Slug <= 100){
        $Chance = 230 + (($Slug - 90) * 5);
    } elseif ($Slug <= 150){
        $Chance = 280 + (($Slug - 100) * 5);
    }

    return $Chance;

}

function Proj3B($Pitcher, $Batter){

    if ($Pitcher->Hand == 'R'){
        $Triple = (($Batter->Spd * .8) + ($Batter->SlugR * .2)) * ($Batter->Effectiveness / 1000);
    } else {
        $Triple = (($Batter->Spd * .8) + ($Batter->SlugL * .2)) * ($Batter->Effectiveness / 1000);
    }

    //1 - 0
    //10 - 1
    //20 - 3
    //30 - 5
    //40 - 10
    //50 - 20
    //60 - 33
    //70 - 60
    //80 - 80
    //90 - 100
    //100 - 120
    //110 - 150

    if ($Triple <= 1){
        $Chance = 0;
    } elseif ($Triple <= 10){
        $Chance = 0 + (($Triple - 1) * .11);
    } elseif ($Triple <= 20){
        $Chance = 1 + (($Triple - 10) * .2);
    } elseif ($Triple <= 30){
        $Chance = 3 + (($Triple - 20) * .2);
    } elseif ($Triple <= 40){
        $Chance = 5 + (($Triple - 30) * .5);
    } elseif ($Triple <= 50){
        $Chance = 10 + (($Triple - 40) * 1);
    } elseif ($Triple <= 60){
        $Chance = 20 + (($Triple - 50) * 1.3);
    } elseif ($Triple <= 70){
        $Chance = 33 + (($Triple - 60) * 2.7);
    } elseif ($Triple <= 80){
        $Chance = 60 + (($Triple - 70) * 2);
    } elseif ($Triple <= 90){
        $Chance = 80 + (($Triple - 80) * 2);
    } elseif ($Triple <= 100){
        $Chance = 100 + (($Triple - 90) * 2);
    } elseif ($Triple <= 110){
        $Chance = 120 + (($Triple - 100) * 3);
    }

    return $Chance;

}

function Proj2B($Pitcher, $Batter){

    if ($Pitcher->Hand == 'R'){
        $SlugDouble = ($Batter->Spd * .25) + ($Batter->SlugR * .75);
        $SpdDouble = ($Batter->Spd * .75) + ($Batter->SlugR * .25);
    } else {
        $SlugDouble = ($Batter->Spd * .25) + ($Batter->SlugL * .75);
        $SpdDouble = ($Batter->Spd * .75) + ($Batter->SlugL * .25);
    }

    if ($SlugDouble >= $SpdDouble){
        $Double = $SlugDouble;
    } else {
        $Double = $SpdDouble;
    }

    //1 - 0.1
    //10 - 2
    //20 - 4
    //30 - 8
    //40   10
    //50   14
    //60 - 18
    //70 - 22
    //80 - 26
    //90 - 30
    //100 - 35

    if ($Double <= 1){
        $Chance = 1;
    } elseif ($Double <= 10){
        $Chance = 1 + (($Double - 1) * 3.9);
    } elseif ($Double <= 20){
        $Chance = 40 + (($Double - 10) * 5);
    } elseif ($Double <= 30){
        $Chance = 90 + (($Double - 20) * 2);
    } elseif ($Double <= 40){
        $Chance = 110 + (($Double - 30) * 2);
    } elseif ($Double <= 50){
        $Chance = 130 + (($Double - 40) * 2);
    } elseif ($Double <= 60){
        $Chance = 150 + (($Double - 50) * 3);
    } elseif ($Double <= 70){
        $Chance = 180 + (($Double - 60) * 3);
    } elseif ($Double <= 80){
        $Chance = 230 + (($Double - 70) * 5);
    } elseif ($Double <= 90){
        $Chance = 270 + (($Double - 80) * 4);
    } elseif ($Double <= 100){
        $Chance = 300 + (($Double - 90) * 3);
    } elseif ($Double <= 150){
        $Chance = 350 + (($Double - 100) * 5);
    }

    return $Chance;

}

function GloveError ($Defender){

    //1 - 120
    //10 - 100
    //20 - 75
    //30 - 50
    //40 - 40
    //50 - 35
    //60 - 30
    //70 - 25
    //80 - 20
    //90 - 15
    //100 - 10


    $Glv = $Defender->Glv * ($Defender->Effectiveness / 1000);


    if ($Glv <= 1){
        $Chance = 120;
    } elseif ($Glv <= 10){
        $Chance = 120 - (($Glv - 1) * 2.22);
    } elseif ($Glv <= 20){
        $Chance = 100 - (($Glv - 10) * 2);
    } elseif ($Glv <= 30){
        $Chance = 75 - (($Glv - 20) * 2.5);
    } elseif ($Glv <= 40){
        $Chance = 50 - (($Glv - 30) * 2.5);
    } elseif ($Glv <= 50){
        $Chance = 40 - (($Glv - 40) * 1);
    } elseif ($Glv <= 60){
        $Chance = 35 - (($Glv - 50) * .5);
    } elseif ($Glv <= 70){
        $Chance = 30 - (($Glv - 60) * .5);
    } elseif ($Glv <= 80){
        $Chance = 25 - (($Glv - 70) * .5);
    } elseif ($Glv <= 90){
        $Chance = 20 - (($Glv - 80) * .5);
    } else {
        $Chance = 15 - (($Glv - 90) * .5);
    }

    return $Chance;
}

function ArmError ($Defender){

    //1 - 120
    //10 - 100
    //20 - 75
    //30 - 50
    //40 - 40
    //50 - 35
    //60 - 30
    //70 - 25
    //80 - 20
    //90 - 15
    //100 - 10


    $Arm = $Defender->Arm * ($Defender->Effectiveness / 1000);


    if ($Arm <= 1){
        $Chance = 120;
    } elseif ($Arm <= 10){
        $Chance = 120 - (($Arm - 1) * 2.22);
    } elseif ($Arm <= 20){
        $Chance = 100 - (($Arm - 10) * 2);
    } elseif ($Arm <= 30){
        $Chance = 75 - (($Arm - 20) * 2.5);
    } elseif ($Arm <= 40){
        $Chance = 50 - (($Arm - 30) * 2.5);
    } elseif ($Arm <= 50){
        $Chance = 40 - (($Arm - 40) * 1);
    } elseif ($Arm <= 60){
        $Chance = 35 - (($Arm - 50) * .5);
    } elseif ($Arm <= 70){
        $Chance = 30 - (($Arm - 60) * .5);
    } elseif ($Arm <= 80){
        $Chance = 25 - (($Arm - 70) * .5);
    } elseif ($Arm <= 90){
        $Chance = 20 - (($Arm - 80) * .5);
    } else {
        $Chance = 15 - (($Arm - 90) * .5);
    }

    return $Chance;
}

function NewProjAvg($Pitcher, $Batter){

    //1 - .05
    //10 - 120
    //20 - 170
    //30 - 220
    //40   270
    //50   300
    //60 - 330
    //70 - 360
    //80 - 380
    //90 - 400
    //100 - 420

    if ($Pitcher->Hand == 'R'){
        $Hit = (($Batter->BatR * .75) + ($Batter->DiscR * .25)) * ($Batter->Effectiveness / 1000);
    } else {
        $Hit = (($Batter->BatL * .75) + ($Batter->DiscL * .25)) * ($Batter->Effectiveness / 1000);
    }

    if ($Hit <= 1){
        $Avg = 50;
    } elseif ($Hit <= 10){
        $Avg = 50 + (($Hit - 1) * 14);
    } elseif ($Hit <= 20){
        $Avg = 190 + (($Hit - 10) * 9);
    } elseif ($Hit <= 30){
        $Avg = 280 + (($Hit - 20) * 9);
    } elseif ($Hit <= 40){
        $Avg = 300 + (($Hit - 30) * 2);
    } elseif ($Hit <= 50){
        $Avg = 320 + (($Hit - 40) * 2);
    } elseif ($Hit <= 60){
        $Avg = 340 + (($Hit - 50) * 2);
    } elseif ($Hit <= 70){
        $Avg = 360 + (($Hit - 60) * 2);
    } elseif ($Hit <= 80){
        $Avg = 380 + (($Hit - 70) * 2);
    } elseif ($Hit <= 90){
        $Avg = 400 + (($Hit - 80) * 2);
    } elseif ($Hit <= 100){
        $Avg = 420 + (($Hit - 90) * 2);
    } elseif ($Hit <= 150){
        $Avg = 440 + (($Hit - 100) * 2);
    }

    return $Avg;

}

function PitcherStrikeout($Pitcher){

    //Strikeout Chance//

    //1 - 10
    //10 - 70
    //20 - 130
    //30 - 170
    //40   200
    //50   230
    //60 - 270
    //70 - 310
    //80 - 360
    //90 - 400
    //100 - 450

    $Arm = (($Pitcher->Arm + $Pitcher->Ctrl) / 2) * ($Pitcher->Effectiveness / 1000);

    if ($Arm <= 1){
        $SO = 10;
    } elseif ($Arm <= 10){
        $SO = 10 + (($Arm - 1) * 6.66);
    } elseif ($Arm <= 20){
        $SO = 70 + (($Arm - 10) * 6);
    } elseif ($Arm <= 30){
        $SO = 130 + (($Arm - 20) * 4);
    } elseif ($Arm <= 40){
        $SO = 170 + (($Arm - 30) * 3);
    } elseif ($Arm <= 50){
        $SO = 200 + (($Arm - 40) * 3);
    } elseif ($Arm <= 60){
        $SO = 230 + (($Arm - 50) * 4);
    } elseif ($Arm <= 70){
        $SO = 270 + (($Arm - 60) * 3);
    } elseif ($Arm <= 80){
        $SO = 310 + (($Arm - 70) * 4);
    } elseif ($Arm <= 90){
        $SO = 360 + (($Arm - 80) * 5);
    } elseif ($Arm <= 100){
        $SO = 400 + (($Arm - 90) * 4);
    } elseif ($Arm <= 110){
        $SO = 450 + (($Arm - 100) * 4);
    }

    return $SO;

}

function BatterStrikeOut($Pitcher,$Batter){

    if ($Pitcher->Hand == 'R'){ ##RHP
        $B = ($Batter->DiscR * ($Batter->Effectiveness / 1000) * .6) + ($Batter->ConR * ($Batter->Effectiveness / 1000) * .4);
    } else { ##LHP
        $B = ($Batter->DiscL * ($Batter->Effectiveness / 1000) * .6) + ($Batter->ConL * ($Batter->Effectiveness / 1000) * .4);
    }


    //Strikeout Chance//

    //1 - 600
    //10 - 350
    //20 - 270
    //30 - 230
    //40   170
    //50   140
    //60 - 100
    //70 - 70
    //80 - 50
    //90 - 40
    //100 - 30

    if ($B <= 1){
        $SO = 600;
    } elseif ($B <= 10){
        $SO = 600 - (($B - 1) * 27.77);
    } elseif ($B <= 20){
        $SO = 350 - (($B - 10) * 10);
    } elseif ($B <= 30){
        $SO = 270 - (($B - 20) * 4);
    } elseif ($B <= 40){
        $SO = 230 - (($B - 30) * 5);
    } elseif ($B <= 50){
        $SO = 170 - (($B - 40) * 3);
    } elseif ($B <= 60){
        $SO = 140 - (($B - 50) * 4);
    } elseif ($B <= 70){
        $SO = 100 - (($B - 60) * 3);
    } elseif ($B <= 80){
        $SO = 70 - (($B - 70) * 2);
    } elseif ($B <= 90){
        $SO = 50 - (($B - 80) * 2);
    } elseif ($B <= 100){
        $SO = 40 - (($B - 90) * 1);
    } elseif ($B <= 110){
        $SO = 30 - (($B - 100) * 1);
    }

    return $SO;



}

function NewStrikeout($Pitcher,$Batter,$Catcher){

    $Strikeout = round ((PitcherStrikeout($Pitcher) + BatterStrikeOut($Pitcher,$Batter)) / 2);

    //Catcher Strikeout Influence//


    $Walk = Walk($Pitcher, $Catcher, $Batter);

    $AtBats = round (270 - (270 * ($Walk / 1000)));
    $ExpSO = 270 * ($Strikeout / 1000);

    ##echo "AB $AtBats ExpSO $ExpSO<br>";

    $Strikeout = round ($ExpSO / $AtBats * 1000);

    return $Strikeout;
}

function PitcherWalk($Pitcher){

    //Walk Chance//

    //1 - 600
    //10 - 550
    //20 - 450
    //30 - 380
    //40   280
    //50   200
    //60 - 180
    //70 - 140
    //80 - 100
    //90 - 80
    //100 - 60

    $P = $Pitcher->Ctrl * ($Pitcher->Effectiveness / 1000);

    ##echo "<br>Ctrl: $P Tru $Pitcher->Ctrl, Eff $Pitcher->Effectiveness";

    if ($P <= 1){
        $Walk = 250;
    } elseif ($P <= 10){
        $Walk = 250 - (($P - 1) * 10);
    } elseif ($P <= 20){
        $Walk = 150 - (($P - 10) * 5);
    } elseif ($P <= 30){
        $Walk = 100 - (($P - 20) * 1);
    } elseif ($P <= 40){
        $Walk = 90 - (($P - 30) * 1);
    } elseif ($P <= 50){
        $Walk = 80 - (($P - 40) * 1);
    } elseif ($P <= 60){
        $Walk = 70 - (($P - 50) * 1);
    } elseif ($P <= 70){
        $Walk = 60 - (($P - 60) * 1);
    } elseif ($P <= 80){
        $Walk = 50 - (($P - 70) * 1);
    } elseif ($P <= 90){
        $Walk = 40 - (($P - 80) * 1);
    } elseif ($P <= 100){
        $Walk = 30 - (($P - 90) * 1.5);
    } elseif ($P <= 110){
        $Walk = 15 - (($P - 100) * .5);
    }

    return $Walk;

}

function BatterWalk($Batter,$Pitcher){

    //Walk Chance//

    //1 - 20
    //10 - 35
    //20 - 50
    //30 - 70
    //40 - 90
    //50 - 120
    //60 - 150
    //70 - 180
    //80 - 210
    //90 - 230
    //100 - 240

    if ($Pitcher->Hand == 'R'){ ##RHP Formula
        $H = $Batter->DiscR * ($Batter->Effectiveness / 1000);
    } else { ##LHP Formula
        $H = $Batter->DiscL * ($Batter->Effectiveness / 1000);
    }

    if ($H <= 1){
        $Walk = 20;
    } elseif ($H <= 10){
        $Walk = 20 + (($H - 1) * 1.66);
    } elseif ($H <= 20){
        $Walk = 35 + (($H - 10) * 1.5);
    } elseif ($H <= 30){
        $Walk = 50 + (($H - 20) * 2);
    } elseif ($H <= 40){
        $Walk = 70 + (($H - 30) * 2);
    } elseif ($H <= 50){
        $Walk = 90 + (($H - 40) * 3);
    } elseif ($H <= 60){
        $Walk = 120 + (($H - 50) * 3);
    } elseif ($H <= 70){
        $Walk = 150 + (($H - 60) * 3);
    } elseif ($H <= 80){
        $Walk = 180 + (($H - 70) * 3);
    } elseif ($H <= 90){
        $Walk = 210 + (($H - 80) * 2);
    } elseif ($H <= 100){
        $Walk = 230 + (($H - 90) * 1);
    } elseif ($H <= 110){
        $Walk = 240 + (($H - 100) * 1);
    }

    return $Walk;

}

function PitcherAvg($Pitcher){

    //1 - +30%
    //10 - +20
    //20 - +10
    //30 - +5
    //40 - 0
    //50 - -4
    //60 - -8
    //70 - -12
    //80 - -16
    //90 - -22
    //100 - -28%

    $Stuff = $Pitcher->Stuff * ($Pitcher->Effectiveness / 1000);

    if ($Stuff <= 1){
        $Avg = 300;
    } elseif ($Stuff <= 10){
        $Avg = 300 - (($Stuff - 1) * 11.11);
    } elseif ($Stuff <= 20){
        $Avg = 200 - (($Stuff - 10) * 10);
    } elseif ($Stuff <= 30){
        $Avg = 100 - (($Stuff - 20) * 10);
    } elseif ($Stuff <= 40){
        $Avg = 50 - (($Stuff - 30) * 5);
    } elseif ($Stuff <= 50){
        $Avg = 0 - (($Stuff - 40) * 5);
    } elseif ($Stuff <= 60){
        $Avg = -40 - (($Stuff - 50) * 4);
    } elseif ($Stuff <= 70){
        $Avg = -80 - (($Stuff - 60) * 4);
    } elseif ($Stuff <= 80){
        $Avg = -120 - (($Stuff - 70) * 4);
    } elseif ($Stuff <= 90){
        $Avg = -160 - (($Stuff - 80) * 4);
    } elseif ($Stuff <= 100){
        $Avg = -220 - (($Stuff - 90) * 6);
    } elseif ($Stuff <= 110){
        $Avg = -280 - (($Stuff - 100) * 6);
    }

    return $Avg;

}

function AttemptSteal($Runner){

    $Attempt = 0;

    //Cycle Through Advanced Settings//
    if ($Runner->StealSetting == 0){ //Advanced//

        //Query and Cycle Through All User Made Game Situations//

    } else { //Basic Settings//

        switch ($Runner->StealSetting){
            case 1: //Never
                $Chance = 0;
                break;
            case 2: //Rare
                $Chance = mt_rand(0,50);
                break;
            case 3: //Normal
                $Chance = mt_rand(50,250);
                break;
            case 4: //Aggressive
                $Chance = mt_rand(500,750);
                break;
            case 5: //Always
                $Chance = 1000;
                break;
        }

        $Roll = mt_rand(0,1000);



        if ($Roll <= $Chance){ //Attempt to Steal//
            $Attempt = 1;
        }

        //#echo "<br>Steal Roll: $Roll, Chance: $Chance,  Attempt: $Attempt";

    }

    return $Attempt;
}

function StealSuccessPct($Runner){

    //Success Chance//

    //1 - 10
    //10 - 20
    //20 - 30
    //30 - 40
    //40 - 60
    //50 - 68
    //60 - 71
    //70 - 74
    //80 - 77
    //90 - 80
    //100 - 85
    //110 - 90
    //120 - 93


    $Spd = $Runner->Spd * ($Runner->Effectiveness / 1000);


    if ($Spd <= 1){
        $Success = 100;
    } elseif ($Spd <= 10){
        $Success = 100 + (($Spd - 1) * 11.11);
    } elseif ($Spd <= 20){
        $Success = 200 + (($Spd - 10) * 10);
    } elseif ($Spd <= 30){
        $Success = 300 + (($Spd - 20) * 10);
    } elseif ($Spd <= 40){
        $Success = 400 + (($Spd - 30) * 10);
    } elseif ($Spd <= 50){
        $Success = 600 + (($Spd - 40) * 20);
    } elseif ($Spd <= 60){
        $Success = 680 + (($Spd - 50) * 8);
    } elseif ($Spd <= 70){
        $Success = 710 + (($Spd - 60) * 3);
    } elseif ($Spd <= 80){
        $Success = 740 + (($Spd - 70) * 3);
    } elseif ($Spd <= 90){
        $Success = 770 + (($Spd - 80) * 3);
    } elseif ($Spd <= 100){
        $Success = 800 + (($Spd - 90) * 3);
    } elseif ($Spd <= 110){
        $Success = 850 + (($Spd - 100) * 5);
    }

    return $Success;

}

function CatchStealer($Catcher){

    //Success Chance//

    //1 - 36
    //10 - 30
    //20 - 24
    //30 - 12
    //40 - 0
    //50 - -5
    //60 - -10
    //70 - -20
    //80 - -30
    //90 - -40
    //100 - -50
    //110 - -55
    //120 - -60


    $Arm = $Catcher->CArm * ($Catcher->Effectiveness / 1000);


    if ($Arm <= 1){
        $Success = 360;
    } elseif ($Arm <= 10){
        $Success = 360 - (($Arm - 1) * 6.66);
    } elseif ($Arm <= 20){
        $Success = 300 - (($Arm - 10) * 6);
    } elseif ($Arm <= 30){
        $Success = 240 - (($Arm - 20) * 6);
    } elseif ($Arm <= 40){
        $Success = 120 - (($Arm - 30) * 12);
    } elseif ($Arm <= 50){
        $Success = 0 + (($Arm - 40) * 12);
    } elseif ($Arm <= 60){
        $Success = -50 - (($Arm - 50) * 5);
    } elseif ($Arm <= 70){
        $Success = -100 - (($Arm - 60) * 5);
    } elseif ($Arm <= 80){
        $Success = -200 - (($Arm - 70) * 10);
    } elseif ($Arm <= 90){
        $Success = -300 - (($Arm - 80) * 10);
    } elseif ($Arm <= 100){
        $Success = -400 - (($Arm - 90) * 10);
    } elseif ($Arm <= 110){
        $Success = -500 - (($Arm - 100) * 5);
    }

    return $Success;

}

function FieldingTier($B1,$B2,$B3,$SS,$LF,$CF,$RF){

    //10 Tiers of Fielding//
    //Each Tier will influence the Batter's Avg Up or Down Based On Tier//
    //Tier 1 - -8%
    //Tier 2 - -6%
    //Tier 3 - -4%
    //Tier 4 - -2%
    //Tier 5 - 0
    //Tier 6 - 2%
    //Tier 7 - 4%
    //Tier 8 - 6%
    //Tier 9 - 8%
    //Tier 10 - 10%

    //Update This Function//SS,2B,CF need to have higher weight, while 3B/1B/RF less weight.

    $Glove = 0;
    $Range = 0;

    $Glove = $Glove + $B1->Glv * ($B1->Effectiveness / 1000);
    $Range = $Range + $B1->Rng * ($B1->Effectiveness / 1000);

    $Glove = $Glove + $B2->Glv * ($B2->Effectiveness / 1000);
    $Range = $Range + $B2->Rng * ($B2->Effectiveness / 1000);

    $Glove = $Glove + $B3->Glv * ($B3->Effectiveness / 1000);
    $Range = $Range + $B3->Rng * ($B3->Effectiveness / 1000);

    $Glove = $Glove + $SS->Glv * ($SS->Effectiveness / 1000);
    $Range = $Range + $SS->Rng * ($SS->Effectiveness / 1000);

    $Glove = $Glove + $LF->Arm * ($LF->Effectiveness / 1000);
    $Range = $Range + $LF->Rng * ($LF->Effectiveness / 1000);

    $Glove = $Glove + $CF->Arm * ($CF->Effectiveness / 1000);
    $Range = $Range + $CF->Rng * ($CF->Effectiveness / 1000);

    $Glove = $Glove + $RF->Arm * ($RF->Effectiveness / 1000);
    $Range = $Range + $RF->Rng * ($RF->Effectiveness / 1000);

    $Glove = $Glove / 7;
    $Range = $Range / 7;

    $Avg = round (($Glove + $Range) / 2 * 10);

    //#echo "<br>FieldAvg $Avg";

    if ($Avg <= 100) {
        $Pct = 100;
    } elseif ($Avg <= 200) {
        $Pct = 80;
    } elseif ($Avg <= 250) {
        $Pct = 60;
    } elseif ($Avg <= 300) {
        $Pct = 40;
    } elseif ($Avg <= 350) {
        $Pct = 20;
    } elseif ($Avg <= 400) {
        $Pct = 0;
    } elseif ($Avg <= 450) {
        $Pct = -20;
    } elseif ($Avg <= 500) {
        $Pct = -40;
    } elseif ($Avg <= 550) {
        $Pct = -60;
    } else {
        $Pct = -80;
    }

    return $Pct;

}

function PitcherExtraBases($Pitcher){

    //2B/3B Pct Influence//

    //1 - 30
    //10 - 20
    //20 - 10
    //30 - 5
    //40   0
    //50   -2.5
    //60 - -5
    //70 - -10
    //80 - -15
    //90 - -20
    //100 - -25
    //110 - -30

    $P = (($Pitcher->Mv + $Pitcher->Arm) / 2) * ($Pitcher->Effectiveness / 1000);

    if ($P <= 1) {
        $Pct = 300;
    } elseif ($P <= 10) {
        $Pct = 300 - (($P - 1) * 11.11);
    } elseif ($P <= 20) {
        $Pct = 200 - (($P - 10) * 10);
    } elseif ($P <= 30) {
        $Pct = 100 - (($P - 20) * 10);
    } elseif ($P <= 40) {
        $Pct = 50 - (($P - 30) * 5);
    } elseif ($P <= 50) {
        $Pct = 0 - (($P - 40) * 2.5);
    } elseif ($P <= 60) {
        $Pct = -25 - (($P - 50) * 2.5);
    } elseif ($P <= 70) {
        $Pct = -50 - (($P - 60) * 2.5);
    } elseif ($P <= 80) {
        $Pct = -100 - (($P - 70) * 5);
    } elseif ($P <= 90) {
        $Pct = -150 - (($P - 80) * 5);
    } elseif ($P <= 100) {
        $Pct = -200 - (($P - 90) * 5);
    } elseif ($P <= 110) {
        $Pct = -250 - (($P - 100) * 5);
    }

    return $Pct;

}

function PitcherHR($Pitcher){

    //HR Pct Influence//

    //1 - 30
    //10 - 20
    //20 - 10
    //30 - 5
    //40   0
    //50   -2.5
    //60 - -5
    //70 - -10
    //80 - -15
    //90 - -20
    //100 - -25
    //110 - -30

    $P = $Pitcher->Stuff * ($Pitcher->Effectiveness / 1000);

    if ($P <= 1) {
        $Pct = 300;
    } elseif ($P <= 10) {
        $Pct = 300 - (($P - 1) * 11.11);
    } elseif ($P <= 20) {
        $Pct = 200 - (($P - 10) * 10);
    } elseif ($P <= 30) {
        $Pct = 100 - (($P - 20) * 10);
    } elseif ($P <= 40) {
        $Pct = 50 - (($P - 30) * 5);
    } elseif ($P <= 50) {
        $Pct = 0 - (($P - 40) * 2.5);
    } elseif ($P <= 60) {
        $Pct = -25 - (($P - 50) * 2.5);
    } elseif ($P <= 70) {
        $Pct = -50 - (($P - 60) * 2.5);
    } elseif ($P <= 80) {
        $Pct = -100 - (($P - 70) * 5);
    } elseif ($P <= 90) {
        $Pct = -150 - (($P - 80) * 5);
    } elseif ($P <= 100) {
        $Pct = -200 - (($P - 90) * 5);
    } elseif ($P <= 110) {
        $Pct = -250 - (($P - 100) * 5);
    }

    return $Pct;

}

function CatcherStrikeout($Catcher){

    //Catcher Influence on Strikeouts "Pitch Calling and Glove Placement"//
    //1 - -18%
    //10 - -15
    //20 - -10
    //30 - -5
    //40 - 0
    //50 - 2
    //60 - 4
    //70 - 6
    //80 - 8
    //90 - 10%
    //100 - 12%
    //110 - 14%

    $Stuff = $Catcher->CAbility * ($Catcher->Effectiveness / 1000);

    if ($Stuff <= 1){
        $Avg = -180;
    } elseif ($Stuff <= 10){
        $Avg = -180 + (($Stuff - 1) * 3.33);
    } elseif ($Stuff <= 20){
        $Avg = -150 + (($Stuff - 10) * 5);
    } elseif ($Stuff <= 30){
        $Avg = -100 + (($Stuff - 20) * 5);
    } elseif ($Stuff <= 40){
        $Avg = -50 + (($Stuff - 30) * 5);
    } elseif ($Stuff <= 50){
        $Avg = 0 + (($Stuff - 40) * 2);
    } elseif ($Stuff <= 60){
        $Avg = 20 + (($Stuff - 50) * 2);
    } elseif ($Stuff <= 70){
        $Avg = 40 + (($Stuff - 60) * 2);
    } elseif ($Stuff <= 80){
        $Avg = 60 + (($Stuff - 70) * 2);
    } elseif ($Stuff <= 90){
        $Avg = 80 + (($Stuff - 80) * 2);
    } elseif ($Stuff <= 100){
        $Avg = 100 + (($Stuff - 90) * 2);
    } elseif ($Stuff <= 110){
        $Avg = 120 + (($Stuff - 100) * 2);
    }

    return $Avg;

}

function ThirdHome($Runner){
//Success Chance//

    //1 - 50
    //10 - 55
    //20 - 60
    //30 - 68
    //40 - 75
    //50 - 80
    //60 - 82
    //70 - 84
    //80 - 86
    //90 - 88
    //100 - 90
    //110 - 92
    //120 - 95


    $Spd = $Runner->Spd * ($Runner->Effectiveness / 1000);


    if ($Spd <= 1){
        $Success = 500;
    } elseif ($Spd <= 10){
        $Success = 500 + (($Spd - 1) * 5.55);
    } elseif ($Spd <= 20){
        $Success = 550 + (($Spd - 10) * 5);
    } elseif ($Spd <= 30){
        $Success = 600 + (($Spd - 20) * 8);
    } elseif ($Spd <= 40){
        $Success = 680 + (($Spd - 30) * 7);
    } elseif ($Spd <= 50){
        $Success = 750 + (($Spd - 40) * 5);
    } elseif ($Spd <= 60){
        $Success = 800 + (($Spd - 50) * 2);
    } elseif ($Spd <= 70){
        $Success = 820 + (($Spd - 60) * 2);
    } elseif ($Spd <= 80){
        $Success = 840 + (($Spd - 70) * 2);
    } elseif ($Spd <= 90){
        $Success = 860 + (($Spd - 80) * 2);
    } elseif ($Spd <= 100){
        $Success = 880 + (($Spd - 90) * 2);
    } elseif ($Spd <= 110){
        $Success = 900 + (($Spd - 100) * 2);
    }

    return $Success;
}

function ThrowOut($Defender){
    //Success Chance//

    //1 - 36
    //10 - 30
    //20 - 24
    //30 - 12
    //40 - 0
    //50 - -5
    //60 - -10
    //70 - -20
    //80 - -30
    //90 - -40
    //100 - -50
    //110 - -55
    //120 - -60


    $Arm = $Defender->Arm * ($Defender->Effectiveness / 1000);

    if ($Arm <= 1){
        $Success = 360;
    } elseif ($Arm <= 10){
        $Success = 360 - (($Arm - 1) * 6.66);
    } elseif ($Arm <= 20){
        $Success = 300 - (($Arm - 10) * 6);
    } elseif ($Arm <= 30){
        $Success = 240 - (($Arm - 20) * 6);
    } elseif ($Arm <= 40){
        $Success = 120 - (($Arm - 30) * 12);
    } elseif ($Arm <= 50){
        $Success = 0 + (($Arm - 40) * 12);
    } elseif ($Arm <= 60){
        $Success = -50 - (($Arm - 50) * 5);
    } elseif ($Arm <= 70){
        $Success = -100 - (($Arm - 60) * 5);
    } elseif ($Arm <= 80){
        $Success = -200 - (($Arm - 70) * 10);
    } elseif ($Arm <= 90){
        $Success = -300 - (($Arm - 80) * 10);
    } elseif ($Arm <= 100){
        $Success = -400 - (($Arm - 90) * 10);
    } elseif ($Arm <= 110){
        $Success = -500 - (($Arm - 100) * 5);
    }

    return $Success;
}

function ScoreFromThird($Runner,$Defender,$Catcher){

    $Chance = ThirdHome($Runner);
    $ThrowOut = ThrowOut($Defender);

    $Chance = $Chance + ($Chance * ($ThrowOut / 1000));

    $Roll = mt_rand(1,1000);

    if ($Roll <= $Chance){
        $Success = 1;
    } else {
        $Success = 0;
    }

    return $Success;

}

function RunExtraBase($Runner){
//Success Chance//

    //1 - 10
    //10 - 20
    //20 - 30
    //30 - 40
    //40 - 50
    //50 - 60
    //60 - 70
    //70 - 80
    //80 - 85
    //90 - 90
    //100 - 100


    $Spd = $Runner->Spd * ($Runner->Effectiveness / 1000);


    if ($Spd <= 1){
        $Chance = 100;
    } elseif ($Spd <= 10){
        $Chance = 100 + (($Spd - 1) * 11.11);
    } elseif ($Spd <= 20){
        $Chance = 200 + (($Spd - 10) * 10);
    } elseif ($Spd <= 30){
        $Chance = 300 + (($Spd - 20) * 10);
    } elseif ($Spd <= 40){
        $Chance = 400 + (($Spd - 30) * 10);
    } elseif ($Spd <= 50){
        $Chance = 500 + (($Spd - 40) * 10);
    } elseif ($Spd <= 60){
        $Chance = 600 + (($Spd - 50) * 10);
    } elseif ($Spd <= 70){
        $Chance = 700 + (($Spd - 60) * 10);
    } elseif ($Spd <= 80){
        $Chance = 800 + (($Spd - 70) * 5);
    } elseif ($Spd <= 90){
        $Chance = 850 + (($Spd - 80) * 5);
    } else {
        $Chance = 1000;
    }

    $Roll = mt_rand(1,1000);

    if ($Roll <= $Chance){
        $Success = 1;
    } else {
        $Success = 0;
    }

    return $Success;
}

function BatterEnergyLoss($Batter){

    if ($Batter->Stamina <= 70){
        $Loss = mt_rand(14,18);
    } elseif ($Batter->Stamina <= 90){
        $Loss = mt_rand(11,13);
    } elseif ($Batter->Stamina <= 100){
        $Loss = mt_rand(8,10);
    } else{
        $Loss = mt_rand(5,7);
    }

    $Batter->Energy = $Batter->Energy - $Loss;

    if ($Batter->Energy >= 620 AND $Batter->Energy <= 740){
        $Batter->Effectiveness = 900;
    } elseif ($Batter->Energy >= 500 AND $Batter->Energy <= 610){
        $Batter->Effectiveness = 750;
    } elseif ($Batter->Energy >= 250 AND $Batter->Energy <= 500){
        $Batter->Effectiveness = 500;
    } elseif ($Batter->Energy <= 250){
        $Batter->Effectiveness = 250;
    }

}
