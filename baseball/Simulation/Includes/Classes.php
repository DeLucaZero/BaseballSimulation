<?php

class Pitcher{

    //Make Public Variables to use with the Class//
    public $Name;
    public $ID;
    public $Position;
    public $IP;
    public $HitsAgainst;
    public $HRAgainst;
    public $Runs;
    public $ER;
    public $BB;
    public $SO;
    public $Batters;
    public $Outs;
    public $Rng;
    public $Glv;
    public $Arm;
    public $PArm;
    public $Stuff;
    public $Ctrl;
    public $Mv;
    public $Stamina;
    public $Energy;
    public $TC;
    public $PO;
    public $Errors;
    public $Asst;
    public $Ovr;
    public $Effectiveness;
    public $EffectiveBatters;
    public $Hand;
    public $TeamID;
    public $Year;
    public $Start;
    public $HookEnergy; ##When Player Is Hooked due to Energy## DEFAULT 65 For Now
    public $DoNotHook; ##If Pitcher will be Hooked while Perfect/No Hitter; Default 1 (1 = Stay In)
    public $HookPerformance;



    public function __construct($DB, $TeamID, $ID, $Location, $Position){

        #echo "<br>PitcherID: $ID";

        ### Query Player Info ###
        $GetPlayer = mysqli_query($DB,"SELECT * FROM `players` WHERE `ID`='$ID'") or die(mysqli_error($DB));
        $P = mysqli_fetch_array($GetPlayer);

        ### Player Info
        $this->ID = $P['ID'];
        $this->Name = $P['Name'];
        $this->TeamID = $TeamID;
        $this->Ovr = $P['POvr'];
        $this->Effectiveness = 1000;
        $this->Energy = $P['Energy'];
        $this->Hand = $P['Hand'];
        $this->Position = $Position;


        ### Pitching Stats
        $this->IP = 0;
        $this->HitsAgainst = 0;
        $this->HRAgainst = 0;
        $this->Runs = 0;
        $this->ER = 0;
        $this->BB = 0;
        $this->SO = 0;
        $this->Batters = 0;
        $this->Outs = 0;

        ### Fielding Stats
        $this->TC = 0;
        $this->PO = 0;
        $this->Asst = 0;
        $this->Errors = 0;

        ### Player Skills
        $this->PArm = $P['Arm'];
        $this->Stuff = $P['Stuff'];
        $this->Ctrl = $P['Ctrl'];
        $this->Mv = $P['Mv'];
        $this->Stamina = $P['Stamina'];
        $this->Arm = $P['INFArm'];
        $this->Glv = $P['INFGlv'];
        $this->Rng = $P['INFRng'];

        ### Home Field Bonus ###

        if ($Location == "Home"){

            $this->PArm += 3;
            $this->Stuff += 3;
            $this->Ctrl += 3;
            $this->Mv += 3;
            $this->Stamina += 3;
            $this->Arm += 3;
            $this->Glv += 3;
            $this->Rng += 3;

        } else {

            $this->PArm -= 3;
            $this->Stuff -= 3;
            $this->Ctrl -= 3;
            $this->Mv -= 3;
            $this->Stamina -= 3;
            $this->Arm -= 3;
            $this->Glv -= 3;
            $this->Rng -= 3;

        }

        #Switch Effectiveness to Batters instead of innings#
        if ($this->Stamina >= 100){
            $this->EffectiveBatters = 24;
        } elseif ($this->Stamina >= 85){
            $this->EffectiveBatters = 20;
        } elseif ($this->Stamina >= 75){
            $this->EffectiveBatters = 15;
        } elseif ($this->Stamina >= 65){
            $this->EffectiveBatters = 8;
        } else {
            $this->EffectiveBatters = 1;
        }
        
        ### Hook Settings ###
        $this->HookEnergy = 700; //Default is 700
        $this->DoNotHook = 1;

    }
}

class Batter{
    public $Name;
    public $ID;
    public $TeamID;
    public $Energy;
    public $Effectiveness;
    public $Stamina;
    public $BatR;
    public $BatL;
    public $SlugR;
    public $SlugL;
    public $DiscR;
    public $DiscL;
    public $ConR;
    public $ConL;
    public $Spd;
    public $Bunt;
    public $Rng;
    public $Glv;
    public $Arm;
    public $CAbility;
    public $CArm;
    public $PA; #Plate Appearances
    public $AB; #At Bats
    public $Hits;
    public $Dubs;
    public $Trips;
    public $HR;
    public $BB;
    public $SO;
    public $Runs;
    public $RBI;
    public $Steals;
    public $CS;
    public $CatchSteal;
    public $CSA; //Catch Steal Attempts
    public $ER; #Earned Runner
    public $Errors;
    public $Asst;
    public $TC; #Total Chances
    public $PO; #Put Outs
    public $StealSetting;
    public $Position;
    public $Hand;
    public $BatSlot;
    public $BatPos;


    public function __construct($DB, $TeamID, $ID, $Pos, $Location, $BatOrder){

        //Query Player Info//
        $GetPlayer = mysqli_query($DB,"SELECT * FROM `players` WHERE `ID`='$ID'") or die(mysqli_error($DB));
        $P = mysqli_fetch_array($GetPlayer);

        //Player Info//
        $this->TeamID = $P['TeamID'];
        $this->ID = $P['ID'];
        $this->Name = $P['Name'];
        $this->Energy = $P['Energy'];
        $this->Effectiveness = 1000;
        $this->Hand = $P['Hand'];

        //Batting Stats//
        $this->PA = 0;
        $this->AB = 0;
        $this->Hits = 0;
        $this->Dubs = 0;
        $this->Trips = 0;
        $this->HR = 0;
        $this->BB = 0;
        $this->SO = 0;
        $this->Runs = 0;
        $this->RBI = 0;
        $this->Steals = 0;
        $this->CS = 0;
        $this->CatchSteal = 0;
        $this->CSA = 0;

        //Fielding Stats//
        $this->Errors = 0;
        $this->TC = 0;
        $this->PO = 0;
        $this->Asst = 0;
        $this->ER = 1;

        //Position//
        $this->Position = substr($Pos, 0, -1);

        //Batting Skills//
        $this->BatR = $P['BatR'];
        $this->BatL = $P['BatL'];
        $this->SlugR = $P['SlugR'];
        $this->SlugL = $P['SlugL'];
        $this->DiscR = $P['DiscR'];
        $this->DiscL = $P['DiscL'];
        $this->ConR = $P['ConR'];
        $this->ConL = $P['ConL'];
        $this->Spd = $P['Spd'];
        $this->Bunt = $P['Bunt'];

        //Position Specific Skills//
        if ($this->Position == 'C'){
            $this->CAbility = $P['CAbility'];
            $this->CArm = $P['CArm'];
        } elseif ($this->Position == 'RF' OR $this->Position == 'CF' OR $this->Position == 'LF'){
            $this->Arm = $P['OFArm'];
            $this->Glv = $P['OFGlv'];
            $this->Rng = $P['OFRng'];
        } else {
            $this->Arm = $P['INFArm'];
            $this->Glv = $P['INFGlv'];
            $this->Rng = $P['INFRng'];
        }

        //Home Field Advantage//

        if ($Location == "Home"){
            $this->BatR = $this->BatR + 3;
            $this->BatL = $this->BatL + 3;
            $this->SlugR = $this->SlugR + 3;
            $this->SlugL = $this->SlugL + 3;
            $this->DiscR = $this->DiscR + 3;
            $this->DiscL = $this->DiscL + 3;
            $this->ConR = $this->ConR + 3;
            $this->ConL = $this->ConL + 3;
            $this->Spd = $this->Spd + 3;
            $this->Bunt = $this->Bunt + 3;
            $this->CAbility = $this->CAbility + 3;
            $this->CArm = $this->CArm + 3;
            $this->Arm = $this->Arm + 3;
            $this->Glv = $this->Glv + 3;
            $this->Rng = $this->Rng + 3;
        } elseif ($Location == "Away") {
            $this->BatR = $this->BatR - 3;
            $this->BatL = $this->BatL - 3;
            $this->SlugR = $this->SlugR - 3;
            $this->SlugL = $this->SlugL - 3;
            $this->DiscR = $this->DiscR - 3;
            $this->DiscL = $this->DiscL - 3;
            $this->ConR = $this->ConR - 3;
            $this->ConL = $this->ConL - 3;
            $this->Spd = $this->Spd - 3;
            $this->Bunt = $this->Bunt - 3;
            $this->CAbility = $this->CAbility - 3;
            $this->CArm = $this->CArm - 3;
            $this->Arm = $this->Arm - 3;
            $this->Glv = $this->Glv - 3;
            $this->Rng = $this->Rng - 3;
        }

        //Player Energy and Effectiveness. Skill = Skill * (Effectiveness/100)//

        if ($this->Energy >= 620 AND $this->Energy <= 740){
            $this->Effectiveness = 900;
        } elseif ($this->Energy >= 500 AND $this->Energy <= 610){
            $this->Effectiveness = 750;
        } elseif ($this->Energy >= 250 AND $this->Energy <= 500){
            $this->Effectiveness = 500;
        } elseif ($this->Energy <= 250){
            $this->Effectiveness = 250;
        }

        //Stealing Settings WIP//

        if ($this->Spd <= 25){
            $this->StealSetting = 1;
        } elseif ($this->Spd <= 35) {
            $this->StealSetting = 2;
        } elseif ($this->Spd <= 45) {
            $this->StealSetting = 3;
        } elseif ($this->Spd <= 75) {
            $this->StealSetting = 4;
        } else {
            $this->StealSetting = 5;
        }

        ##Find Batting Position##

        $F = 0;
        $this->BatPos = 1;

        //Loop through the Batting Order for a Match//
        while ($F == 0 AND $this->BatPos <= 9){

            //Exit Due to Error//
            if ($this->BatPos > 10){
                echo "<br>Error Finding Player in Batting Order -> Position: $this->Position, PlayerID: $this->ID";
                exit;
            }

            if ($BatOrder[$this->BatPos] == $this->ID){
                $F = 1;
            } else {
                $this->BatPos = $this->BatPos + 1;

                #echo "<br>BatPos $this->BatPos, ID: $this->ID, Check: " . $BatOrder[$this->BatPos];
            }

        }

    }
}

class Team{
    public $Name;
    public $ID;
    public $Pitcher;
    public $OTSwap; ##Swap out closer in OT, if a pitcher is available## Default = 1 (True)
    public $UseCL; ##Always use Closer in Save Situation, Default 1 (True)
    public $CloserSwitch; ##IF the team used closer already, Default = 0;
    public $Save; ##Save Opportunity## Default 0
    public $LastLeadLoss; ##Last Pitcher to lose the lead.
    public $LastLeadGain; ##Last Pitcher during lead Gain.
    public $LastPitcher; ##ID of Last Pitcher
    public $Starter; ##ID of SP;
    public $StarterFull; ##If Starter Has Pitch Enough INN For W/L


    public function __construct($DB,$TeamID){
        $GetTeam = mysqli_query($DB,"SELECT * FROM `teams` WHERE `ID`='$TeamID'");
        $Team = mysqli_fetch_array($GetTeam);

        $this->Name = $Team['Team'] . " " . $Team['Name'];
        $this->ID = $TeamID;

        $this->Pitcher = 1;
        $this->OTSwap;
        $this->UseCL = 1;
        $this->CloserSwitch = 0;
        $this->Save = 0;
        $this->LastLeadLoss = 0;
        $this->LastLeadGain = 0;
        $this->LastPitcher = 0;
        $this->Starter = 0;
        $this->StarterFull = 0;

    }
}

class Game{
    public $Inn;
    public $Outs;
    public $InnHalf;
    public $HomeRuns;
    public $AwayRuns;
    public $HomeBat; //Track Which Home Batter is Up
    public $AwayBat; //Track Which Away Batter is Up
    public $H1R; //Home Team Runs In 1st//
    public $H2R;
    public $H3R;
    public $H4R;
    public $H5R;
    public $H6R;
    public $H7R;
    public $H8R;
    public $H9R;
    public $H10R;
    public $A1R; //Away Team Runs in 1st//
    public $A2R;
    public $A3R;
    public $A4R;
    public $A5R;
    public $A6R;
    public $A7R;
    public $A8R;
    public $A9R;
    public $A10R;
    public $InnSwitch;
    public $InnHalfSwitch;
    public $ErrorAfter2; //If a fielder errors on 2 outs, Pitcher no longer gets any Earned Runs that inning//

    public function __construct(){
        $this->Inn = 1;
        $this->Outs = 0;
        $this->InnHalf = 1;
        $this->HomeRuns = 0;
        $this->AwayRuns = 0;
        $this->HomeBat = 1;
        $this->AwayBat = 1;

        $this->H1R = 0;
        $this->H2R = 0;
        $this->H3R = 0;
        $this->H4R = 0;
        $this->H5R = 0;
        $this->H6R = 0;
        $this->H7R = 0;
        $this->H8R = 0;
        $this->H9R = 0;
        $this->H10R = 0;

        $this->A1R = 0;
        $this->A2R = 0;
        $this->A3R = 0;
        $this->A4R = 0;
        $this->A5R = 0;
        $this->A6R = 0;
        $this->A7R = 0;
        $this->A8R = 0;
        $this->A9R = 0;
        $this->A10R = 0;

        $this->InnSwitch = 0;
        $this->InnHalfSwitch = 0;

        $this->ErrorAfter2 = 0;
    }
}

class Blank{
    public $ID;
    public $Name;

    public function __construct(){
        $this->ID = 0;
        $this->Name = "";
    }
}
