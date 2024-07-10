<?php

include ('users.php');
include ('posts.php');

class bdd
{

    private $bdd;

    public function _connect()
    {
        try {
            $this->bdd = new PDO("mysql:host=localhost;dbname=btest", "root", '');
            return $this->bdd;

        } catch (PDOException $e) {

            $error = fopen("error.log", "w");
            $txt = $e . "\n";
            fwrite($error, $txt);

            throw new Exception("Non nounours!");

        }
    }

    public function _getAll()
    {

        $sql = "SELECT * FROM users";

        $done = $this->bdd->query($sql);

        return $done->fetchAll(PDO::FETCH_ASSOC);
    }

    public function _addUser(Users $user)
    {
        $pseudo = $user->getPseudo();
        $password = $user->getPassword();


        $sql = $this->bdd->prepare("INSERT INTO users (pseudo, password) VALUES (:pseudo, :password)");
        $sql->bindParam(":pseudo", $pseudo);
        $sql->bindParam(":password", $password);
        $sql->execute();
    }

    public function _addPost(Posts $posts)
    {
        $post = $posts->getContenu();

        $sql = $this->bdd->prepare("INSERT INTO posts (contenu) VALUES (:contenu)");
        $sql->bindParam(":contenu", $post);
        $sql->execute();
    }

    public function _userConnect($param = []){

        $users = $this->_getAll();

        foreach ($users as $user) {
            if (($param["pseudo"] == $user["pseudo"]) && password_verify($param["password"], $user["password"])) {
                return $user;
        }
        }
    }

    public function _getAllPosts()
    {

        $sql = "SELECT * FROM posts";

        $done = $this->bdd->query($sql);

        return $done->fetchAll(PDO::FETCH_ASSOC);
    }




}