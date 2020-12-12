<?php
include_once 'Includes/Classes.php';
include_once 'Includes/SimFunctions.php';

//Insert Game Into DB and Pull GameID//
mysqli_query($DB,"INSERT INTO games(HomeID,AwayID)VALUES ('$HomeTeam','$AwayTeam')") or die(mysqli_error($DB));

$FindGameID = mysqli_query($DB,"SELECT * FROM games WHERE Status=0 AND HomeID='$HomeTeam' AND AwayID='$AwayTeam' ORDER BY ID DESC") or die(mysqli_error($DB));
$GameInfo = mysqli_fetch_array($FindGameID);

$GameID = $GameInfo['ID'];


######### Home Team #########

$Home = new Team($DB,$HomeTeam); //Class for Home Team

// Pitching Lineup //
$GetHomePLineup = mysqli_query($DB,"SELECT * FROM `depth_chart_pitchers` WHERE `TeamID`='$HomeTeam'") or die(mysqli_error($DB));
$HomePLineup = mysqli_fetch_array($GetHomePLineup);

$HP = new Pitcher($DB, $HomeTeam, $HomePLineup['SP1'], "Home", "SP");

// Field/Batting Lineup //

$GetHomeLineup = mysqli_query($DB,"SELECT * FROM `depth_chart` WHERE `TeamID`='$HomeTeam'") or die(mysqli_error($DB));
$HomeLineup = mysqli_fetch_array($GetHomeLineup);

// Batting Order //
$GetHomeBatOrder = mysqli_query($DB,"SELECT * FROM `depth_chart_batting_order` WHERE `TeamID`='$HomeTeam'") or die(mysqli_error($DB));
$HomeOrder = mysqli_fetch_array($GetHomeBatOrder);

$H1B = new Batter($DB, $HomeTeam, $HomeLineup['1B1'], "1B1", "Home", $HomeOrder);
$H2B = new Batter($DB, $HomeTeam, $HomeLineup['2B1'], "2B1", "Home", $HomeOrder);
$H3B = new Batter($DB, $HomeTeam, $HomeLineup['3B1'], "3B1", "Home", $HomeOrder);
$HSS = new Batter($DB, $HomeTeam, $HomeLineup['SS1'], "SS1", "Home", $HomeOrder);
$HRF = new Batter($DB, $HomeTeam, $HomeLineup['RF1'], "RF1", "Home", $HomeOrder);
$HCF = new Batter($DB, $HomeTeam, $HomeLineup['CF1'], "CF1", "Home", $HomeOrder);
$HLF = new Batter($DB, $HomeTeam, $HomeLineup['LF1'], "LF1", "Home", $HomeOrder);
$HC = new Batter($DB, $HomeTeam, $HomeLineup['C1'], "C1", "Home", $HomeOrder);
$HDH = new Batter($DB, $HomeTeam, $HomeLineup['DH1'], "DH1", "Home", $HomeOrder);


######### Away Team #######

$Away = new Team($DB,$AwayTeam);

// Pitching Lineup //
$GetAwayPLineup = mysqli_query($DB,"SELECT * FROM `depth_chart_pitchers` WHERE `TeamID`='$AwayTeam'") or die(mysqli_error($DB));
$AwayPLineup = mysqli_fetch_array($GetAwayPLineup);

$AP = new Pitcher($DB, $HomeTeam, $AwayPLineup['SP1'], "Away", "SP");

// Field/Batting Lineup //

$GetAwayLineup = mysqli_query($DB,"SELECT * FROM `depth_chart` WHERE `TeamID`='$AwayTeam'") or die(mysqli_error($DB));
$AwayLineup = mysqli_fetch_array($GetAwayLineup);

// Batting Order //
$GetAwayBatOrder = mysqli_query($DB,"SELECT * FROM `depth_chart_batting_order` WHERE `TeamID`='$AwayTeam'") or die(mysqli_error($DB));
$AwayOrder = mysqli_fetch_array($GetAwayBatOrder);

$A1B = new Batter($DB, $AwayTeam, $AwayLineup['1B1'], "1B1", "Away", $AwayOrder);
$A2B = new Batter($DB, $AwayTeam, $AwayLineup['2B1'], "2B1", "Away", $AwayOrder);
$A3B = new Batter($DB, $AwayTeam, $AwayLineup['3B1'], "3B1", "Away", $AwayOrder);
$ASS = new Batter($DB, $AwayTeam, $AwayLineup['SS1'], "SS1", "Away", $AwayOrder);
$ARF = new Batter($DB, $AwayTeam, $AwayLineup['RF1'], "RF1", "Away", $AwayOrder);
$ACF = new Batter($DB, $AwayTeam, $AwayLineup['CF1'], "CF1", "Away", $AwayOrder);
$ALF = new Batter($DB, $AwayTeam, $AwayLineup['LF1'], "LF1", "Away", $AwayOrder);
$AC = new Batter($DB, $AwayTeam, $AwayLineup['C1'], "C1", "Away", $AwayOrder);
$ADH = new Batter($DB, $AwayTeam, $AwayLineup['DH1'], "DH1", "Home", $AwayOrder);


#### Init Game ####
$Game = new Game(); //Keeps Track of Game Stats
$Zero = new Blank(); //Blank Class

//Test to make sure players initialized correctly//
#echo "<br>HomeP: $HP->Name, PArm: $HP->PArm";
#echo "<br>Away1B: $A1B->Name, SlugR: $A1B->SlugR, BatPos $A1B->BatPos";

### Run the Simulation ###
include 'Sim.php';

### Insert Game Stats ###
include 'Includes/Stats.php';

### Update Pitching Outcome ###
include 'Game/PitchingOutcome.php';

## Update GameState ##
mysqli_query($DB,"UPDATE `games` SET `Status`=2, `HomeScore`='$Game->HomeRuns', `AwayScore`='$Game->AwayRuns' WHERE `ID`='$GameID'") or die(mysqli_error($DB));

### Echo BoxScore ####
include 'Includes/Result.php';

## Update Team Games Played in Stats (Used for Stat Qualification Purposes) ##
mysqli_query($DB,"UPDATE `stats_pitching_career` SET `TeamGP`=`TeamGP`+1 WHERE `TeamID`='$Home->ID' OR `TeamID`='$Away->ID'") or die(mysqli_error($DB));
mysqli_query($DB,"UPDATE `stats_batting_career` SET `TeamGP`=`TeamGP`+1 WHERE `TeamID`='$Home->ID' OR `TeamID`='$Away->ID'") or die(mysqli_error($DB));