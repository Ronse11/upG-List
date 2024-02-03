<?php
include 'conn.php';

// Register
if (isset($_POST['register'])) {
    $fname = $_POST['fName'];
    $lname = $_POST['lName'];
    $email = $_POST['email'];
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];

    if ($pass1 == $pass2) {
        $hash = password_hash($pass1, PASSWORD_DEFAULT);

        $insertUser = $conn->prepare("INSERT INTO users(user_fname, user_lname, user_email, user_pass) VALUES(?, ?, ?, ?)");
        $insertUser->execute([
            $fname,
            $lname,
            $email,
            $hash
        ]);

        header("Location: login.php");
        exit();
    } else {
        header("Location: register.php");
    }
}


// logout
if (isset($_GET['logout'])) {
    session_start();
    unset($_SESSION['logged_in']);
    unset($_SESSION['u_id']);

    header('Location: home.php');
}

// add data
if (isset($_POST['create'])) {
    $userID = $_POST['userID'];
    $items = $_POST['item'];
    $prices = $_POST['price'];
    $quantities = $_POST['quantity'];

    // Check if the incoming data is an array or a single value
    if (!is_array($items)) {
        // If it's not an array, convert single values to arrays
        $items = array($items);
        $prices = array($prices);
        $quantities = array($quantities);
    }

    // Get the count of items
    $count = count($items);

    // Prepare the INSERT statement
    $insertStatement = $conn->prepare("INSERT INTO items(user_id, user_items, user_price, quantity) VALUES(?, ?, ?, ?)");

    for ($i = 0; $i < $count; $i++) {
        $item = $items[$i];
        $price = $prices[$i];
        $quantity = $quantities[$i];

        // Bind parameters and execute the query for each item
        $insertStatement->execute([$userID, $item, $price, $quantity]);
    }

    // Redirect to the list page after all items are inserted
    header("Location: index.php");
    exit();
}






// update data
if (isset($_POST['update'])) {
    $userID = $_POST['userID'];
    $userItem = $_POST['item'];
    $userPrice = $_POST['price'];
    $quantity = $_POST['quantity'];

    $updateUser = $conn->prepare("UPDATE items SET user_items=?, user_price=?, quantity=? WHERE p_id=?");
    $updateUser->execute([
        $userItem,
        $userPrice,
        $quantity,
        $userID
    ]);

    $msg = 'Successfully Updated!';
    header("Location: index.php?msg=$msg");
    exit();
}

// delete data from items
if (isset($_GET['delete'])) {
    $id = $_GET['id'];

    $delete = $conn->prepare("DELETE FROM items WHERE p_id=?");
    $delete->execute([$id]);

    header("Location: index.php");
    exit();
}

// Gets the data to history table from items table
if (isset($_GET['done'])) {
    $id = $_GET['id'];
    $user = $_GET['user'];
    $item = $_GET['item'];
    $price = $_GET['price'];
    $quantity = $_GET['quantity'];

    $doneItem = $conn->prepare("INSERT INTO history(p_id, user_id, user_items, user_price, quantity) VALUES (?, ?, ?, ?, ?)");
    $doneItem->execute([$id, $user, $item, $price, $quantity]);

    $delete = $conn->prepare("DELETE FROM items WHERE p_id=?");
    $delete->execute([$id]);

    header("Location: index.php");
    exit();
}

// delete data from history
if (isset($_GET['history'])) {
    $id = $_GET['id'];

    $delHistory = $conn->prepare("DELETE FROM history WHERE p_id=?");
    $delHistory->execute([$id]);

    header("Location: index.php");
    exit();
}

// clear all data from history
if (isset($_GET['clear'])) {
    $userId = $_GET['user']; 

    $clearHistory = $conn->prepare("DELETE FROM history WHERE user_id=?");
    $clearHistory->execute([$userId]);

    header("Location: index.php");
    exit();
}

// EDIT PROFILE
if(isset($_POST['editProfile'])) {
    $userID = $_POST['userID'];
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $email = $_POST['email'];
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];

    if ($pass1 == $pass2) {
        $hash = password_hash($pass1, PASSWORD_DEFAULT);

        $insertUser = $conn->prepare("UPDATE users SET user_fname=?, user_lname=?, user_email=?, user_pass=? WHERE user_id=?");
        $insertUser->execute([
            $fName,
            $lName,
            $email,
            $hash,
            $userID
        ]);

        header("Location: index.php");
        exit();
    }
    
}

$pdo = null;
?>