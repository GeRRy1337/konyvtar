<nav class="navbar fixed-top navbar-expand-lg navbar-light menubg">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <span class="lang mr-2"><span class="bi bi-translate"></span><?php echo $langArr['lang']; ?>:
      <select class="mr-2" name="langSelect" id="langSelect" onchange='{
            const d = new Date();
            d.setTime(d.getTime() + (30*24*60*60*1000));
            let expires = "expires="+ d.toUTCString();
            document.cookie = "lang" + "=" + this.value + ";" + expires + ";path=../";
            location.reload();
            }
        '>
        <option value="hu" <?php if ($_COOKIE['lang'] == "hu") echo "selected"; ?>>HU</option>
        <option value="en" <?php if ($_COOKIE['lang'] == "en") echo "selected"; ?>>EN</option>
      </select></span>

    <ul class="navbar-nav nav-pills mr-auto">
      <?php
      foreach ($menu as $key => $value) {
        $active = '';
        if (isset($_REQUEST['page']) and $_REQUEST['page'] == $key) $active = ' active';
        if ($key == 'userControl') $key .= '&action=' . $action;
        if ($key == 'index') {
      ?>
          <li class="nav-item">
            <a class="nav-link color-dark <?php echo $active; ?>" href="index.php?page=<?php echo $key; ?>&search=false"><?php echo $value; ?></a>
          </li>
        <?php
        } elseif ($key != 'userProfile' and $key != 'favorites') {
        ?>
          <li class="nav-item">
            <a class="nav-link color-dark <?php echo $active; ?>" href="index.php?page=<?php echo $key; ?>"><?php echo $value; ?></a>
          </li>
          <?php
        } else {
          if (!empty($_SESSION['id'])) {
          ?>
            <li class="nav-item">
              <a class="nav-link color-dark <?php echo $active; ?>" href="index.php?page=<?php echo $key; ?>"><?php echo $value; ?></a>
            </li>
      <?php
          }
        }
      }
      ?>
    </ul>
    <?php
    if (isset($_REQUEST['page'])) {
      if ($_REQUEST['page'] == 'index') {
    ?>
        <form method="post" class="form-inline my-2 my-lg-0">
          <button class="btn btn-primary my-2 my-sm-0" type="submit" name="backward">
            << /button>
              <?php
              for ($i = 0; $i < 5; $i++) {
                if ($_SESSION['indexPage'] == Book::getMax($conn) - 1) {
                  if ($_SESSION['indexPage'] - 3 + $i > 0) {
                    echo '<button class="btn ' . ($_SESSION['indexPage'] + $i == $_SESSION['indexPage'] + 3 ? 'btn-success' : 'btn-info') . ' my-2 my-sm-0" type="submit" name="switchPage" value=' . ($_SESSION['indexPage'] - 3 + $i) . '>' . ($_SESSION['indexPage'] - 3 + $i) . '</button>';
                  }
                } elseif ($_SESSION['indexPage'] == Book::getMax($conn)) {
                  if ($_SESSION['indexPage'] - 4 + $i > 0) {
                    echo '<button class="btn ' . ($_SESSION['indexPage'] + $i == $_SESSION['indexPage'] + 4 ? 'btn-success' : 'btn-info') . ' my-2 my-sm-0" type="submit" name="switchPage" value=' . ($_SESSION['indexPage'] - 4 + $i) . '>' . ($_SESSION['indexPage'] - 4 + $i) . '</button>';
                  }
                } elseif ($_SESSION['indexPage'] - 2 > 0) {
                  echo '<button class="btn ' . ($_SESSION['indexPage'] - 2 + $i == $_SESSION['indexPage'] ? 'btn-success' : 'btn-info') . ' my-2 my-sm-0" type="submit" name="switchPage" value=' . ($_SESSION['indexPage'] - 2 + $i) . '>' . ($_SESSION['indexPage'] - 2 + $i) . '</button>';
                } elseif ($_SESSION['indexPage'] - 1 > 0) {
                  echo '<button class="btn ' . ($_SESSION['indexPage'] - 1 + $i == $_SESSION['indexPage'] ? 'btn-success' : 'btn-info') . ' my-2 my-sm-0" type="submit" name="switchPage" value=' . ($_SESSION['indexPage'] - 1 + $i) . '>' . ($_SESSION['indexPage'] - 1 + $i) . '</button>';
                } elseif ($_SESSION['indexPage'] > 0) {
                  echo '<button class="btn ' . ($_SESSION['indexPage'] + $i == $_SESSION['indexPage'] ? 'btn-success' : 'btn-info') . ' my-2 my-sm-0" type="submit" name="switchPage" value=' . ($_SESSION['indexPage'] + $i) . '>' . ($_SESSION['indexPage'] + $i) . '</button>';
                }
              }
              ?>
              <button class="btn btn-primary my-2 my-sm-0" type="submit" name="forward">></button>
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle color-dark" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo $langArr['categories']; ?>
                  </a>
                  <ul class="dropdown-menu menu-scroll" aria-labelledby="navbarDropdown">
                    <?php
                    if ($result = $conn->query("Select category_name,category_id from categories"))
                      if ($result->num_rows > 0)
                        while ($row = $result->fetch_assoc()) {
                          echo '<li><a href="' . $_SERVER['PHP_SELF'] . "?" . 'category=' . $row['category_id'] . '" class="dropdown-item">' . $row['category_name'] . '</a></li>';
                        }
                    ?>
                  </ul>
                </li>
              </ul>
        </form>
        <form method="post" class="form-inline my-2 my-lg-0" name="searchForm">
          <input class="form-control mr-sm-2" type="search" name="search" placeholder="<?php echo $langArr['search']; ?>" aria-label="Search">
          <button class="btn btn-secondary my-2 my-sm-0" type="submit"><span class="bi bi-search"></span> <?php echo $langArr['search']; ?></button>
        </form>
    <?php
      }
    }
    ?>
  </div>
</nav>