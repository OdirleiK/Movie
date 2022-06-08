<?php 

 require_once("templates/header.php");

 if($userDao) { #verificando se o usuarioe esta logado de fato
    $userDao->destroyToken();

 }