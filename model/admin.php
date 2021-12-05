<?php

    require_once 'userSelect.php';

    class Admin extends userSelect {
        
        function __construct() {
            $this->table = 'admins';
        }
    }

?>