<?php
class Pitcher{
    public $Name;
    public $HitsAgainst;
    public $HRAgainst;
    public $Runs;
    public $ER;
    public $BB;
    public $SO;
    public $Batters;
    public $Outs;
    public $Arm;
    public $Stuff;
    public $Ctrl;
    public $Mv;
    public $Stamina;
    public $Energy;
    public $Ovr;
    public $Effectiveness;



    public function __construct($Pow,$Stuff,$Ctrl,$Mv){

        $this->Name = "Pitcher";

        ###Stats
        $this->HitsAgainst = 0;
        $this->HRAgainst = 0;
        $this->Runs = 0;
        $this->ER = 0;
        $this->BB = 0;
        $this->SO = 0;
        $this->Batters = 0;
        $this->Outs = 0;

        ###Attributes
        $this->Arm = $Pow;
        $this->Stuff = $Stuff;
        $this->Ctrl = $Ctrl;
        $this->Mv = $Mv;
        $this->Effectiveness = 100;

        $this->Hand = 'R';

        $this->Ovr = round(($this->Arm + $this->Stuff + $this->Ctrl + $this->Mv) / 3.2);
    }
}

class Batter{
    public $Name;
    public $Effectiveness;
    public $BatR;
    public $BatL;
    public $SlugR;
    public $SlugL;
    public $DiscR;
    public $DiscL;
    public $ConR;
    public $ConL;
    public $Spd;
    public $PA; #Plate Appearances
    public $AB; #At Bats
    public $Hits;
    public $Dubs;
    public $Trips;
    public $HR;
    public $BB;
    public $SO;

    public function __construct($Slg,$Bat,$Disc,$Spd,$Con){

        $this->Name = "Batter";

        #Stats
        $this->PA = 0;
        $this->AB = 0;
        $this->Hits = 0;
        $this->Dubs = 0;
        $this->Trips = 0;
        $this->HR = 0;
        $this->BB = 0;
        $this->SO = 0;

        #Skills
        $this->BatR = $Bat;
        $this->BatL = $Bat;
        $this->SlugR = $Slg;
        $this->SlugL = $Slg;
        $this->ConR = $Con;
        $this->ConL = $Con;
        $this->DiscR = $Disc;
        $this->DiscL = $Disc;
        $this->Spd = $Spd;
        $this->Effectiveness = 100;

    }
}

class Catcher{

    public $CAbility;
    public $Effectiveness;

    public function __construct($CAbility){

        $this->CAbility = $CAbility;
        $this->Effectiveness = 100;

    }

}
