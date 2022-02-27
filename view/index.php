<?php
    if(isset($_SESSION['categories']) and count($_SESSION['categories'])>0){
        echo '<div class="categories">';
        $categories="";
        foreach($_SESSION['categories'] as $category){
            $categories.=intval($category).",";
        }
        $categories=substr($categories,0,strlen($categories)-1);
        if($result=$conn->query("Select category_name,category_id from categories where category_id in (".$categories.")"))
            if($result->num_rows>0)
                while($row=$result->fetch_assoc()){
                    echo '<span class="category">'.$row['category_name'].'<a href=?removeCat='.$row['category_id'].'> X'.'</a></span>';
                }
        echo "</div>";
    }
?>
<div class="bookTable">
        <?php
        if(!isset($_SESSION['indexPage'])){
            $_SESSION['indexPage']=1;
        }
        if ($bookIds) {
            foreach($bookIds as $bookId) {
                $BookVar->set_book($bookId,$conn);
                echo ' <span class="bookItem"><a href="index.php?page=bookInfo&bookId='.$bookId.'"><img src="'.$BookVar->get_ImageUrlL().'"></a><br>'. $BookVar->get_BookTitle() .' ('.$BookVar->get_YearOfPublication().')' .'</span>';
            }
        }
        else {
            echo $langArr["noResult"];
        }

        ?>
</div>