<?php
require 'partials/sessionlogin.php';
require 'partials/connect.php';
require 'views/header.php';

if (isset($_GET['action'])) {

    // ----------------------------

    if ($_GET['action'] == 'register') {
        $statement = $pdo->prepare(
            "INSERT INTO users (username, password)
             VALUES (:username, :password)"
        );
        $statement->execute([
            ":username" => $_POST['username'],
            ":password" => password_hash($_POST['password'], PASSWORD_BCRYPT),
        ]);
        header('Location: index.php');
    }

    // ----------------------------

    if ($_GET['action'] == 'login') {
        $statement = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $statement->execute([
            ":username" => $_POST['username'],
        ]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        // if($_POST['username'] !== $user['username']){
        //     echo "no register";
        // }

        if (password_verify($_POST['password'], $user["password"])) {
            $_SESSION["loggedIn"] = true;

            session_start();
            $_SESSION['userID'] = $user['userID']; 
        } else {
            echo "Wrong username or password.";
        }
    }

    // ----------------------------

    if ($_GET['action'] == 'newpost') {

        session_start();
        $user['userID'] = $_SESSION['userID'];

        $statement = $pdo->prepare(
            "INSERT INTO entries (title, content, createdAt, userID)
             VALUES (:title, :content, :createdAt, :userID)"
        );
        date_default_timezone_set("Europe/Stockholm"); 
        $statement->execute([
            ":title" => $_POST['title'],
            ":content" => $_POST['content'],
            ":createdAt" => date('Y-m-d H:i:s'),
            ":userID" => $user['userID']
        ]);
        header('Location: index.php');
    }

    // ----------------------------

    if ($_GET['action'] == 'signout') {
        $_SESSION["signedOut"] = true;
        unset($_SESSION["loggedIn"]);
        require 'partials/sessionsignout.php';
    }
}

// ----------------------------

if (isset($_SESSION["loggedIn"])) {

    echo "<form id='form-signout' action='?action=signout' method='POST' >
               <input id='btn-signout' type='submit' value='Sign out' class='btn-lg btn-primary'>
          </form>";

    echo "<div class='user-login'>Logged in as {$user['username']}!</div>";
    require 'views/newpost.php';

    $statement = $pdo->prepare("DELETE FROM entries WHERE entryID = {$_GET['entryID']}");
    $statement->execute();

    session_start();
    $user['userID'] = $_SESSION['userID'];

    $statement = $pdo->prepare("SELECT entryID, title, content, createdAt, userID
                                FROM entries WHERE userID = {$user['userID']}");
    $statement->execute();
    $data = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $i) {
        $output .= "<div id='post-box' class='blog-post'>
                        <h2>{$i['title']}</h2>
                        <p class='blog-post-meta'>{$i['createdAt']}</p>
                        <p>{$i['content']}</p>
                        <a class='delete-post-btn' href='?entryID={$i['entryID']}'>Delete Post</a>
                    </div>";
    }
    echo $output;

} elseif (isset($_SESSION['signedOut'])) {
    require 'views/signout.php';
} else {
    require 'views/login.php';
    require 'views/register.php';
}
require 'views/footer.php';