<?php

  class User { #todos os campos do banco de dados, para montar o usuario 
    
    public $id;
    public $name;
    public $lastname;
    public $email;
    public $password;
    public $image;
    public $bio;
    public $token;

    public function getFullName($user) {
      return $user->name . " " . $user->lastname;
    }

    public function generateToken() {
      return bin2hex(random_bytes(50));
    }
    public function generatePassword($password) {
      return password_hash($password, PASSWORD_DEFAULT);

    }
    public function imageGenerateName() {
      return bin2hex(random_bytes(60)) . ".jpg";
    }
  }

  interface UserDAOInterface { #metodos do DAO

    public function buildUser($data); 
    public function create(User $user, $authUser = false);
    public function update(User $user, $redirect = true);
    public function verifyToken($protected = false);
    public function setTokenToSession($token, $redirect = true); #redirecionar o usuario para alguma pagina especifica
    public function authenticateUser($email, $password);
    public function findByEmail($email); #encontrar o usuario pelo email
    public function findById($id); #encontrar o usuario pelo id
    public function findByToken($token);
    public function destroyToken();
    public function changePassword(User $user);

  }