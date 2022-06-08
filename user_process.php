<?php

require_once("globals.php");
require_once("db.php");
require_once("models/User.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");

$message = new Message($BASE_URL);

$userDao = new UserDAO($conn, $BASE_URL);

//resgatar o tipo do form
$type = filter_input(INPUT_POST, "type");

//Atualizar usuario
if ($type === "update") {

    //reasgata dados do usuario   
    $userData = $userDao->verifyToken();

    //receber dados do post
    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $email = filter_input(INPUT_POST, "email");
    $bio = filter_input(INPUT_POST, "bio");

    //criar novo objeto de usuario
    $user = new User();

    //prencher dados do usuario
    $userData->name = $name;
    $userData->lastname = $lastname;
    $userData->email = $email;
    $userData->bio = $bio;

    // Upload da imagem
    if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

        $image = $_FILES["image"];
        $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
        $jpgArray = ["image/jpeg", "image/jpg"];

        // Checagem de tipo de imagem
        if (in_array($image["type"], $imageTypes)) {

            // Checar se jpg
            if (in_array($image, $jpgArray)) {

                $imageFile = imagecreatefromjpeg($image["tmp_name"]);

                // Imagem é png
            } else {

                $imageFile = imagecreatefrompng($image["tmp_name"]);
            }

            $imageName = $user->imageGenerateName();

            imagejpeg($imageFile, "./img/users/" . $imageName, 100);

            $userData->image = $imageName;
        } else {

            $message->setMessage("Tipo inválido de imagem, insira png ou jpg!", "error", "back");
        }
    }

    $userDao->update($userData);
  
    //ataulizar senha do usuario    
} else if ($type === "changepassword") {
     //receber dados do post
     $password = filter_input(INPUT_POST, "password");
     $confirmpassword = filter_input(INPUT_POST, "confirmpassword");
     
    $userData = $userDao->verifyToken();
    
    $id = $userData->id;

     if($password == $confirmpassword ) {

      $user = new User();

      $finalPassword = $user->generatePassword($password);

      $user->password = $finalPassword = $finalPassword;
      $user->id = $id;

      $userDao->changePassword($user);



     }else {
        $message->setMessage("As senhas nao sao iguais", "error", "back");
     }

} else {
    $message->setMessage("Informaçoes invalidas", "error", "index.php");
}
