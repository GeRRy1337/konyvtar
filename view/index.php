<table>   
        <?php

        if ($bookIds) {
            $sor = 0;
            foreach($bookIds as $row) {
                $tanulo->set_user($row, $conn);
                if($tanulo->get_sor() != $sor) {
                    if($sor != 0) echo '</tr>';
                    echo '<tr>';
                    $sor = $tanulo->get_sor();
                }
                if(!$tanulo->get_nev()) echo '<td class="empty"></td>';
                else {
                    $plusz = '';
                    if(in_array($row, $hianyzok)) $plusz .=  ' class="missing"';
                    if($row == $en) $plusz .=  ' id="me"';
                    if($row == $tanar) $plusz .=  ' colspan="2"';
                    echo "<td".$plusz.">" . $tanulo->get_nev();
                    if(!empty($_SESSION["id"])) {
                        if(in_array($_SESSION["id"], $adminok)) {
                            if(in_array($row, $hianyzok)) echo '<br><a href="index.php?page=ulesrend&nem_hianyzo='.$row.'">Nem hiányzó</a>';
                        }
                    }
                    echo "</td>";
                }
            }
        } 
        else {
            echo "0 results";
        }
        $conn->close();

        ?>
</table>