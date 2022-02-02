<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav mr-auto">
      <?php
        foreach($menu as $key => $value) {
          $active = '';
          if($_SERVER['REQUEST_URI'] == '/konyvtar/'.$key) $active = ' active';
          if($key == 'userControl') $key.='&action='.$action;
          if($key=='index'){
            ?>
              <li class="nav-item<?php echo $active; ?>">
                  <a class="nav-link" href="index.php?page=<?php echo $key; ?>&search=false"><?php echo $value; ?></a>
              </li>
            <?php
          }elseif($key!='userProfile' and $key!='favorites'){ 
      ?>
            <li class="nav-item<?php echo $active; ?>">
                <a class="nav-link" href="index.php?page=<?php echo $key; ?>"><?php echo $value; ?></a>
            </li>
      <?php
          }else{
            if(!empty($_SESSION['id'])){
              ?>
              <li class="nav-item<?php echo $active; ?>">
                  <a class="nav-link" href="index.php?page=<?php echo $key; ?>"><?php echo $value; ?></a>
              </li>
              <?php
            }
          }
        }
      ?>
    </ul>
    <?php 
    if(isset($_REQUEST['page'])) {
      if($_REQUEST['page']=='index'){
    ?>
      <form action="index.php?page=index" method="post" class="form-inline my-2 my-lg-0">
        <button class="btn btn-primary my-2 my-sm-0" type="submit" name="backward"><</button>
        <?php 
          for($i=0;$i<5;$i++){
            if($_SESSION['indexPage']-2>0){
              echo '<button class="btn ';if($_SESSION['indexPage']-2+$i==$_SESSION['indexPage']) echo 'btn-success'; else echo 'btn-info'; echo ' my-2 my-sm-0" type="submit" name="switchPage" value='.($_SESSION['indexPage']-2+$i).'>'.($_SESSION['indexPage']-2+$i).'</button>';
            }elseif($_SESSION['indexPage']-1>0){
              echo '<button class="btn ';if($_SESSION['indexPage']-1+$i==$_SESSION['indexPage']) echo 'btn-success'; else echo 'btn-info'; echo ' my-2 my-sm-0" type="submit" name="switchPage" value='.($_SESSION['indexPage']-1+$i).'>'.($_SESSION['indexPage']-1+$i).'</button>';
            }else {
              echo '<button class="btn ';if($_SESSION['indexPage']+$i==$_SESSION['indexPage']) echo 'btn-success'; else echo 'btn-info'; echo ' my-2 my-sm-0" type="submit" name="switchPage" value='.($_SESSION['indexPage']+$i).'>'.($_SESSION['indexPage']+$i).'</button>';
            }
          }

        ?>
        <button class="btn btn-primary my-2 my-sm-0" type="submit" name="forward">></button>
      </form>
    <?php
      }
    ?>
    <form action="index.php?page=index" method="post" class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" name="search" placeholder="Keresés" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Keresés</button>
    </form>
    <?php
      
    }
    ?>
  </div>
</nav>