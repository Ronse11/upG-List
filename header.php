<?php
ob_start();
session_start();
include 'conn.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grocery List</title>
    <!-- css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">

    <style>
        * {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>

    <script>
        function addInput() {
            var container = document.getElementById("inputs");
            var inputDiv = `
            <div class="position-relative mb-3">
                <div class="mb-1 row">
                    <div class="col-3 py-1">
                        <label for="item" class="form-label"><b>Item:</b></label>
                    </div>
                    <div class="col">
                        <input type="text" style="font-size: .7rem;" class="form-control" id="item" name="item[]">
                    </div>
                </div>
                <div class="mb-1 row">
                    <div class="col-3 py-1">
                        <label for="price" class="form-label "><b>Price:</b></label>
                    </div>
                    <div class="col" id="input">
                        <input type="text" style="font-size: .7rem;" class="form-control" id="price" name="price[]">
                    </div>
                </div>
                <div class="mb-1 row" id="input">
                    <div class="col-3 py-1">
                        <label for="quantity" class="form-label "><b>Quantity:</b></label>
                    </div>
                    <div class="col" id="input">
                        <input type="text" style="font-size: .7rem;" class="form-control" id="quantity" name="quantity[]">
                    </div>
                </div>
                    <a type="button" class="text-decoration-none position-absolute top-0 start-100 translate-middle" style="width: 15px;" onclick="removeInput(this)"><small>❌</small></a>
            </div>
            `;
            container.insertAdjacentHTML('beforeend', inputDiv);
        }

        function removeInput(inputDiv) {
            var div = inputDiv.parentNode;
            div.parentNode.removeChild(div);
        }
    </script>

</head>

<body>

    <div class="container-fluid vh-100 px-md-5">
        <nav class="navbar navbar-expand bg-body px bg-transparent ">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarText">
                    <h4 class="navbar-nav px-2 me-auto text-primary user-select-none ">GList</h4>
                    <ul class="navbar-nav me-auto mb-lg-0 text-center">
                        <a class="nav-link active mx-1" aria-current="page" href="home.php" style="--bs-focus-text-color: rgba(var(--bs-success-rgb), .25)">Home</a>
                        <a class="nav-link active mx-1" aria-current="page" href="index.php">List</a>
                        <a class="nav-link active mx-1" aria-current="page" href="about.php">About</a>
                    </ul>
                    <?php
                    if (isset($_SESSION['logged_in'])) {
                        $userID = $_SESSION['u_id'];

                        $getUser = $conn->prepare("SELECT user_id FROM users WHERE user_id = ?");
                        $getUser->execute([$userID]);

                        foreach ($getUser as $user) { ?>
                            <span class="navbar-text px-lg-5">
                            <div class="dropdown">
                                <a class="dropdown-toggle-transparent bg-transparent btn-outline-none" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class='bx bx-user text-primary ' style="font-size: 1.7rem;"></i></a>

                                <ul class="dropdown-menu text-center bg-transparent" style="margin: 1rem 0 0 -8rem;">
                                    <li><a class="dropdown-item my-2 " href="./editProf.php?editProfile&id=<?=$user['user_id']?>">Edit Profile</a></li>
                                    <li><a type="button" class="btn btn-primary text-white px-3" aria-current="page" href="process.php?logout">Logout</a></li>
                                </ul>
                            </div>
                        </span>
                        <?php } ?>
                    <?php } else { ?>
                        <span class="navbar-text px-lg-5">
                            <div class="dropdown">
                                <a class="dropdown-toggle-transparent bg-transparent btn-outline-none" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class='bx bx-user text-primary ' style="font-size: 1.7rem;"></i></a>

                                <ul class="dropdown-menu text-center bg-transparent" style="margin: 1rem 0 0 -8rem;">
                                    <li><a type="button" class="btn btn-primary text-white px-3" aria-current="page" href="login.php">Login</a></li>
                                </ul>
                            </div>
                        </span>
                    <?php } ?>
                </div>
            </div>
        </nav>