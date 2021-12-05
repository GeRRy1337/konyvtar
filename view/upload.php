<form action="index.php/?page=feltoltes" method="post">
    Név:<input type="text" name="name"><br>
    Leírás:<input type="text" name="description"><br>
    Kiadás: <input type="date" name="release"><br>
    Író: <select name="iro" id="iro">
        <?php 
            foreach($authorList as $id){
                $author->set_author($id,$conn);
                echo '<option value"'.$id.'">'.$author->get_name().' ('.$author->get_birth().')'.'</option>';
            }
        ?>
    </select>
    <input type="submit">
</form>