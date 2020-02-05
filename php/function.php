<?php
//search user in the database if user exist return id else return null
function search_user($pseudo){
    global $bdd;
    $sql = $bdd->prepare("SELECT id, pseudo FROM user");

    $sql->execute();

    while($row = $sql->fetch()){
        if($row['pseudo'] == $pseudo){

            $id = $row['id'];
            $sql->closeCursor();

            return $id;
        }
    }
    $sql->closeCursor();
    return NULL;
}
//add user in the database
function addUser($pseudo, $password){
    global $bdd;

    $id = search_user($pseudo);

    if(!isset($id)){
        $group_id = 1;

        $sql = $bdd->prepare("INSERT INTO user (pseudo, password, group_id) VALUES (:pseudo, :password, :group_id)");

        $sql->bindParam(":pseudo", $pseudo);
        $sql->bindParam(":password", $password);
        $sql->bindParam(":group_id", $group_id);

        $sql->execute();
        $sql->closeCursor();

        // afficher un message comme quoi le compte à bien été créer !
        header("location: login.php");
    } else {
        echo "Ce nom d'utilisateur existe déjà !";
    }
}
//add commentary in the database
function addComment($pseudo, $comment){
    global $bdd;

    $id = search_user($pseudo);

    if(isset($id)){
        $timestamp = time();
        $modified = 0;

        $sql = $bdd->prepare("INSERT INTO commentary (comment, date, user_id, last_modified_user, modified) VALUES (:comment, :date, :id, :pseudo, :modified)");

        $sql->bindParam(":comment", $comment);
        $sql->bindParam(":date", $timestamp);
        $sql->bindParam(":id", $id);
        $sql->bindParam(":pseudo", $pseudo);
        $sql->bindParam(":modified", $modified);

        $sql->execute();
        $sql->closeCursor();
        header('location: comment_display.php');
    } else {
        echo "Vous n'êtes pas connecté ! Vous allez être redirigé dans X secondes";
        header('location: index.html');
    }
}
//update commentary in the database
function updateComment($commentaryId, $pseudo, $comment){
    global $bdd;

    $id = search_user($pseudo);

    if(isset($id)){
        $modified = 1;
        $sql = $bdd->prepare("UPDATE commentary SET comment = :comment, last_modified_user = :last_modified_user, modified = :modified WHERE id = :id");

        $sql->bindParam(":id", $commentaryId);
        $sql->bindParam(":comment", $comment);
        $sql->bindParam(":last_modified_user", $pseudo);
        $sql->bindParam(":modified", $modified);
        $sql->execute();

        $sql->closeCursor();
        header('location: comment_display.php');
    }else {
        echo "Vous n'êtes pas connecté ! Vous allez être redirigé dans X secondes";
        header('location: index.html');
    }
}

//function that displays the last 10 paged messages
function pagination($limit, $page){
    global $bdd;

    if(is_int(intval($page))){
        $debut = ($page - 1) * $limit;

        $sql = $bdd->prepare("SELECT * FROM commentary LEFT JOIN user ON commentary.user_id = user.id ORDER BY date DESC LIMIT :limit OFFSET :debut");

        $sql->bindValue('limit', $limit, PDO::PARAM_INT);
        $sql->bindValue('debut', $debut, PDO::PARAM_INT);

        $sql->execute();

        while($row = $sql->fetch()){
            $date = date("d.m.Y", $row['date']);
            $hour = date("H:m:s", $row['date']);
            echo "<div class='blocComment'><span class='commentPseudo'>".$row['pseudo']."</span> à posté comme commentaire : <div class='commentTXT'>".$row['comment']."</div>à ".$hour." le ".$date."</div><br>";

            //check if the commentary has been modified, 0 = no modified
            if(intval($row['modified'] > 0)){?>
                <div class="modified">Le commentaire à été modifié par <?= $row['last_modified_user']; ?> !</div></div>
            <?php }
            //check the user permission
            if(intval($_SESSION['group_id']) === 2 || intval($_SESSION['group_id']) === 3){

                $commentary_id = intval($row[0]);
                $comment = $row['comment'];

                echo "<div id='buttonUpdateDelete'>
                    <form action='comment.php' method='post'>
                            <input type='hidden' name='commentary_id' value='$commentary_id'>
                            <input type='hidden' name='comment' value='$comment'>
                            <input type='submit' value='Modifier' class='submit'>
                        </form>
                        
                    <form action='delete.php' method='post'>
                            <input type='hidden' name='commentary_id' value='$commentary_id'>
                            <input type='submit' value='Supprimer' class='submit'>
                        </form>
                  </div>";
            }
//        json_encode($row, true);
        }
        $sql->closeCursor();
    }else {
        echo "Le numéro de page n'est pas un entier !";
    }
}
//verify that the password and pseudo exists in the database
function checkLog($pseudo, $password){
    global $bdd;

    $sql = $bdd->prepare("SELECT * FROM user WHERE pseudo = :pseudo");

    $sql->bindValue("pseudo", $pseudo, PDO::PARAM_STR);
    $sql->execute();

    while($row = $sql->fetch()){
        if ($pseudo === $row['pseudo'] && password_verify($password, $row['password'])) {
            echo 'Le mot de passe est valide !';
//            $_SESSION['id'] = intval($row['id']);
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['group_id'] = $row['group_id'];
        } else {
            echo 'Le pseudo ou le mot de passe est incorrect !';
        }
    }
    $sql->closeCursor();
    if(isset($_SESSION['pseudo'])){
        header('location: comment.php');
    }else {
        header('location: login.php');
    }
}