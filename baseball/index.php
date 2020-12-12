<?php
require "connect.php";
?>

<!DOCTYPE html>
<html>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="CSS/Global.css" rel="stylesheet" type="text/css" />

    <title>Collegebaseballsim.com Baseball Simulation</title>
    <meta name="description" content="Description Here" />
    <meta name="keywords" content="Keywords Here" />

</head>

<body>

<?php

//Check to see if Form was clicked//

if (isset($_POST['RunGame'])){

    //Escape String//s
    $HomeTeam = mysqli_real_escape_string($DB,$_POST['HomeTeam']);
    $AwayTeam = mysqli_real_escape_string($DB,$_POST['AwayTeam']);

    //Init Game
    $RunGame = 1;

} else {

    //Set Default Home/Away
    $HomeTeam = 1;
    $AwayTeam = 2;

    $RunGame = 0;

}
?>

<div class="TeamSelect" style="margin-left: auto; margin-right: auto;">

    <form action="index.php" method="post">

        <label>Away Team</label>
        <select name="AwayTeam" id="AwayTeam">

            <?php

            //Loop through Teams//
            $GetTeams = mysqli_query($DB,"SELECT ID, Team FROM teams") or die(mysqli_error($DB));
            while ($Team = mysqli_fetch_row($GetTeams)){

                if ($Team[0] == $AwayTeam){
                    echo "<option value='$Team[0]' selected='selected'>$Team[1]</option>";
                } else {
                    echo "<option value='$Team[0]'>$Team[1]</option>";
                }

            }

            ?>

        </select>

        <br><br>

        <label>Home Team</label>

        <select name="HomeTeam" id="HomeTeam">

            <?php

            //Loop through Teams//
            $GetTeams = mysqli_query($DB,"SELECT ID, Team FROM teams") or die(mysqli_error($DB));
            while ($Team = mysqli_fetch_row($GetTeams)){

                if ($Team[0] == $HomeTeam){
                    echo "<option value='$Team[0]' selected='selected'>$Team[1]</option>";
                } else {
                    echo "<option value='$Team[0]'>$Team[1]</option>";
                }

            }

            ?>

        </select>

        <br> <br>

        <input type="submit" name="RunGame" value="Simulate" />

    </form>

</div>

<div class="SimResult">

    <?php

    //Simulate Game if RunGame is set to 1//

    if ($RunGame == 1){

        include "Simulation/Setup.php";


    }

    ?>

</div>



</body>
