<?php
include ('db_con.php');

//var_dump($_POST["user_id"]);


if(isset($_POST["action"])) {
    if ($_POST["action"] == "insert") {
        $pdo->beginTransaction();

        $sql = "INSERT INTO users (user_name) VALUES ('" . $_POST["user_name"] . "')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $user_id = $pdo->lastInsertId();

        $sql = "INSERT INTO messages (user_message,user_id) VALUES ('" . $_POST["message"] . "',$user_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $pdo->commit();
        echo '<p>Data inserted...</p>';
    }
    if($_POST["action"] == 'fetch_single')
    {
        $sql= "SELECT * FROM messages m  JOIN users u ON m.user_id = u.user_id WHERE m.user_id & u.user_id = '".$_POST["user_id"]."'";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row)
        {
            $output['user_name'] = $row['user_name'];
            $output['message'] = $row['user_message'];

        }
        echo json_encode($output);
    }

    if($_POST["action"] == "update")
    {
        $pdo->beginTransaction();

        $query="UPDATE users SET user_name = '" . $_POST["user_name"] . "' WHERE user_id = '" . $_POST["hidden_id"] . "'";
        $statement = $pdo->prepare($query);
        $statement->execute();

        $query="UPDATE messages SET user_message = '" . $_POST["message"] . "' WHERE user_id = '" . $_POST["hidden_id"] . "'";
        $statement = $pdo->prepare($query);
        $statement->execute();

        $pdo->commit();

    }

    if($_POST["action"] == 'delete')
    {
        $pdo->beginTransaction();

        $query = "DELETE FROM users WHERE user_id = '".$_POST["user_id"]."'";
        $statement = $pdo->prepare($query);
        $statement->execute();

        $query = "DELETE FROM messages WHERE user_id = '".$_POST["user_id"]."'";
        $statement = $pdo->prepare($query);
        $statement->execute();

        $pdo->commit();
        echo '<p>Data Deleted</p>';
    }

}


