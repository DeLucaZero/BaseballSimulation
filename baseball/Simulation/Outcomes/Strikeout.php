<?php

#echo "<br>$Pitcher->Name Strikes Out $Batter->Name";

//Update Stats//
$Batter->PA = $Batter->PA + 1;
$Batter->AB = $Batter->AB + 1;
$Batter->SO = $Batter->SO + 1;
$Pitcher->SO = $Pitcher->SO + 1;
$Pitcher->Outs = $Pitcher->Outs + 1;
$Pitcher->Batters = $Pitcher->Batters + 1;
$Catcher->PO = $Catcher->PO + 1;
$Catcher->TC = $Catcher->TC + 1;

//Update Outs//
$Game->Outs = $Game->Outs + 1;

//Next Batter//
include 'NextBatter.php';