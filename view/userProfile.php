<?php 
    echo 'Üdvözöllek '.$_SESSION['username']. '!';
?>
<div class="container">
    <?php 
    $user->set_user($_SESSION['id'],$conn);
    $userBorrowedList=$user->userBorrowed($conn);
    if(sizeof($userBorrowedList)>0){
    ?>
    <div class="row justify-content-center">
        <div class="col-12">
        <h3>Kikölcsönzött könyvek</h3>
        <table class="table table-dark table-bordered w-100">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Cím</th>
                    <th>Könyvtári szám</th>
                    <th>Határidő</th>
                </tr>
            </thead>
            <tbody>
        <?php

            $index=1;
            foreach($userBorrowedList as $book){
                echo '<tr>';
                    echo '<td>'.($index++).'</td>';
                    foreach($book as $element){
                        echo '<td>'.$element.'</td>';
                    }
                echo '</tr>';
            }
        ?>
            </tbody>
        </table>
        </div>
    </div>
    <?php 
    }else{
    ?>

    <p>Nincs nálad kikölcsönzött könyv.</p>

    <?php
    }
    ?>
</div>