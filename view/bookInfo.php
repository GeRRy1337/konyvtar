<div class="bookContainer">
    <img id="infoImg" src=<?php echo 'bookCovers/'.$selectedBook->get_id().'.png';?>>
    <h1><?php echo $selectedBook->get_name();?></h1>
    <p><?php echo $selectedBook->get_description();?></p>
    <hr>
    <p><?php echo 'Írta: '.$author->get_name().' ('.$author->get_birth().')' ?></p>
    <p><?php echo $author->get_description();?></p>
</div>
