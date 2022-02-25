<nav class="navbar fixed-top navbar-expand-lg navbar-light menubg">
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
                <a class="nav-link color-dark" href="index.php?page=<?php echo $key; ?>&search=false"><?php echo $value; ?></a>
              </li>
            <?php
          }elseif($key!='userProfile' and $key!='favorites'){ 
      ?>
            <li class="nav-item<?php echo $active; ?>">
                <a class="nav-link color-dark" href="index.php?page=<?php echo $key; ?>"><?php echo $value; ?></a>
            </li>
      <?php
          }else{
            if(!empty($_SESSION['id'])){
              ?>
              <li class="nav-item<?php echo $active; ?>">
                  <a class="nav-link color-dark" href="index.php?page=<?php echo $key; ?>"><?php echo $value; ?></a>
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
      <form method="post" class="form-inline my-2 my-lg-0">
        <button class="btn btn-primary my-2 my-sm-0" type="submit" name="backward"><</button>
        <?php
          for($i=0;$i<5;$i++){
              if($_SESSION['indexPage']==$BookVar->getMax($conn)-1){
                if($_SESSION['indexPage']-3+$i>0){
                  echo '<button class="btn '.($_SESSION['indexPage']+$i==$_SESSION['indexPage']+3?'btn-success':'btn-info').' my-2 my-sm-0" type="submit" name="switchPage" value='.($_SESSION['indexPage']-3+$i).'>'.($_SESSION['indexPage']-3+$i).'</button>';
                }
              }elseif($_SESSION['indexPage']==$BookVar->getMax($conn)){
                if($_SESSION['indexPage']-4+$i>0){
                  echo '<button class="btn '.($_SESSION['indexPage']+$i==$_SESSION['indexPage']+4?'btn-success':'btn-info').' my-2 my-sm-0" type="submit" name="switchPage" value='.($_SESSION['indexPage']-4+$i).'>'.($_SESSION['indexPage']-4+$i).'</button>';
                }
              }elseif($_SESSION['indexPage']-2>0){
                echo '<button class="btn '.($_SESSION['indexPage']-2+$i==$_SESSION['indexPage']?'btn-success':'btn-info').' my-2 my-sm-0" type="submit" name="switchPage" value='.($_SESSION['indexPage']-2+$i).'>'.($_SESSION['indexPage']-2+$i).'</button>';
              }elseif($_SESSION['indexPage']-1>0){
                echo '<button class="btn '.($_SESSION['indexPage']-1+$i==$_SESSION['indexPage']?'btn-success':'btn-info').' my-2 my-sm-0" type="submit" name="switchPage" value='.($_SESSION['indexPage']-1+$i).'>'.($_SESSION['indexPage']-1+$i).'</button>';
              }elseif($_SESSION['indexPage']>0){
                echo '<button class="btn '.($_SESSION['indexPage']+$i==$_SESSION['indexPage']?'btn-success':'btn-info').' my-2 my-sm-0" type="submit" name="switchPage" value='.($_SESSION['indexPage']+$i).'>'.($_SESSION['indexPage']+$i).'</button>';
              }
          }
        ?>
        <button class="btn btn-primary my-2 my-sm-0" type="submit" name="forward">></button>
      </form>
    <form method="post" class="form-inline my-2 my-lg-0" name="searchForm">
      <input class="form-control mr-sm-2" type="search" name="search" placeholder="Keresés" aria-label="Search">
      <button class="btn btn-secondary my-2 my-sm-0" type="submit"><span class="bi bi-search"></span> Keresés</button>
    </form>
    <?php
      }
    }
    ?>
  </div>
</nav>

