<form action="index.php?page=upload" method="post" enctype="multipart/form-data">
    Cím:<input type="text" name="name"><br>
    Leírás:<input type="text" name="description"><br>
    Kiadás: <input type="date" name="release"><br>
    Író: <select name="iro" id="iro">
        <?php 
            foreach($authorList as $id){
                $author->set_author($id,$conn);
                echo '<option value="'.$id.'">'.$author->get_name().' ('.$author->get_birth().')'.'</option>';
            }
            foreach($authorList as $id){
                echo $id;   
            }
        ?>
    </select><br>
    <input type="file" name="fileToUpload" id="fileToUpload"><br>
    <input type="submit">
</form>