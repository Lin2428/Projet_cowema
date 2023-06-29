<?php

require 'functions.php';

require 'head/header.php';



if (isset($_GET["read"]) || empty($_GET)) {
    require 'liste.php';
} elseif (isset($_GET["update"])) {
    require 'update.php';
} elseif(isset($_GET['create'])) {
    require 'create.php';
}

//Inclusion du code html footer
require 'foot/footer.php';
