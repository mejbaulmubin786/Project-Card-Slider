<?php
session_start();

include "config.php";


session_unset(); //variables value removed

session_destroy();

header("Location:{$hostname}/admin/"); //go to index.php

?>
