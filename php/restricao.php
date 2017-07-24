<?php
    session_start();
    if(empty($_SESSION['email']) or empty($_SESSION['id'])){
        echo 0;
    }else{
        echo 1;
    }