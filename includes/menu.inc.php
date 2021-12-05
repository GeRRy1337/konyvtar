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
          if(!in_array($key,$prohibited)){ 
      ?>
            <li class="nav-item<?php echo $active; ?>">
                <a class="nav-link" href="index.php?page=<?php echo $key; ?>"><?php echo $value; ?></a>
            </li>
      <?php
          }else{
            if(!empty($_SESSION['id'])){
              if(in_array($_SESSION['id'],$adminList)){
                ?>
                  <li class="nav-item<?php echo $active; ?>">
                    <a class="nav-link" href="index.php?page=<?php echo $key; ?>"><?php echo $value; ?></a>
                  </li>
                <?php
              }
            }
          }
        }
      ?>
    </ul>
    <form action="index.php?page=index" method="post" class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" name="search" placeholder="Keresés" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Keresés</button>
    </form>
  </div>
</nav>