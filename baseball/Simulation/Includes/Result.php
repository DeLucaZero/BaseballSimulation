<br><br><br>

<div style="float: left; width: 400px;">
    <table border="1" align="left" width="20%">
        <tr>
            <td>
                <?php
                echo $Away->Name;
                ?>
            </td>
            <td>
                <?php
                echo $Game->AwayRuns;
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php
                echo $Home->Name;
                ?>
            </td>
            <td>
                <?php
                echo $Game->HomeRuns;
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <?php
                if ($Game->Inn > 10){
                    echo "Final OT";
                } else {
                    echo "Final";
                }
                ?>
            </td>
        </tr>


    </table>

</div>

<br><br><br>