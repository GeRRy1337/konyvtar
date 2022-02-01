<div class="container bg-light">
    <div class="row">
        <div class="bookContainer">
            <img id="infoImg" src=<?php echo $BookVar->get_ImageUrlL();?>>
            <h1><?php echo $BookVar->get_BookTitle();?></h1>
            <hr>
            <p><?php echo 'Írta: '.$BookVar->get_BookAuthor()?></p>
            <?php  
                if (isset($_SESSION['id'])){
            ?>
                <form action="index.php?page=bookInfo&bookId=<?php echo $BookVar->get_id();?>" method="POST">
                    Kedvencekhez adás:<input type="submit" value="" <?php if($BookVar->isFav($conn,$_SESSION['id'])) echo 'id="favButtonOn" name="favButtonOn"'; else echo 'id="favButtonOff" name="favButtonOff"';?> >
                </form>
            <?php
                }
            ?>
            <hr>
            <h2>Könyvek száma:<?php echo $BookVar->inStock($conn);?></h2>
        </div>
    </div>
    <?php
        $borrowedList=$BookVar->borrowedList($conn);
        if(sizeof($borrowedList)>0){
    ?>
    <div class="row justify-content-center">
        <div class="col-12">
        <h3>Kikölcsönzött könyvek</h3>
        <table class="table table-dark table-bordered w-100">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Könyvtári szám</th>
                    <th>Határidő</th>
                </tr>
            </thead>
            <tbody>
        <?php

            $index=1;
            foreach($borrowedList as $book){
                echo '<tr>';
                    echo '<td>'.($index++).'</td>';
                    echo '<td>'.$book[0].'</td>';
                    echo '<td>'.$book[1].'</td>';
                echo '</tr>';
            }
        ?>
            </tbody>
        </table>
        </div>
    </div>
    <?php
        }
    ?>
</div>
