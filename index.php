<?php
require_once ('config/config.php');

$bdd = new bdd();
$bdd->_connect();

session_start();


if (isset($_POST['new_envoyer'])) {

    $pseudo = htmlspecialchars($_POST['new_pseudo']);
    $password = htmlspecialchars($_POST['new_password']);

    $newUser = new Users();
    $newUser->setPseudo($pseudo);
    $newUser->setPassword(password_hash($password, PASSWORD_ARGON2I));

    $bdd->_addUser($newUser);
}

if(isset($_POST['soumettre'])) {

    $post = ($_POST["txt"]);

    $newPost = new Posts();
    $newPost->setContenu($post);

    $bdd->_addPost($newPost);
    print "YAAAR";

}


$users = $bdd->_getAll();

if (isset($_POST['envoyer'])) {
    if (!empty($_POST['pseudo']) && (!empty($_POST['password']))) {
        $user = $bdd->_userConnect(["pseudo" => $_POST['pseudo'], "password" => $_POST['password']]);
        if ($user) {
            $_SESSION["user"] = $user;
            print "C'EST OKAAAAAAY";
        } else {
            print "Ce n'est pas bon.";
        }
    } else {
        print "Faut envoyer des trucs!";
    }
}

echo "<pre>";
var_dump($users);
echo "</pre>";



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <header class="px-[15%] pb-10 flex justify-center">
        <h1>Salut à toi jeune entrepreneur!</h1>
    </header>
    <main class="px-[15%] flex flex-col justify-center items-center pb-10">
        <section class="pb-10 border-b-4">
            <h2>T'es qui toi?</h2>
            <form action="" method="post">
                <input class="border-solid border-2 border-black" type="text" name="pseudo" placeholder="pseudo">
                <input class="border-solid border-2 border-black" type="password" name="password"
                    placeholder="mot de passe">
                <button class="border-solid border-2 border-black" type="submit" name="envoyer">Envoyer</button>
            </form>
        </section>
        <section>
            <h2>Nouveau dans la street?</h2>
            <form action="" method="post">
                <input class="border-solid border-2 border-black" type="text" name="new_pseudo" placeholder="pseudo">
                <input class="border-solid border-2 border-black" type="password" name="new_password"
                    placeholder="mot de passe">
                <button class="border-solid border-2 border-black" type="submit" name="new_envoyer">Envoyer</button>
            </form>
        </section>
        <section>
            <?php if (isset($_SESSION["user"])) { ?>
                <?php foreach ($bdd->_getAllPosts() as $article) { ?>
                    <article>
                        <a href="#"
                            class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><?php $article["contenu"] ?></h5>
                            <p class="font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology
                                acquisitions of 2021 so far, in reverse chronological order.</p>
                        </a>
                    <?php } ?>
                <?php } ?>
            </article>
            <article>
                <?php if (isset($_SESSION["user"])) { ?>
                    <form action="" method="post" class="w-full max-w-sm">
                        <div class="flex items-center border-b border-teal-500 py-2">
                            <input
                                class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                                type="text" placeholder="Mes vacances aux Seychelles!" name="txt" aria-label="Full name">
                            <button
                                class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded"
                                type="submit" name="soumettre">Soumettre</button>

                            <button
                                class="flex-shrink-0 border-transparent border-4 text-teal-500 hover:text-teal-800 text-sm py-1 px-2 rounded"
                                type="button">Cancel</button>
                        </div>
                    </form>
                <?php } ?>
            </article>
        </section>
    </main>


</body>

</html>