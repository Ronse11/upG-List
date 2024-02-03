<?php
include 'header.php';
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    ob_end_flush();
}
?>

<div class="d-flex flex-column flex-md-row mt-5 mx-1 mx-md-5">
    <div class="d-flex justify-content-center ">
        <div class="nav flex-row flex-md-column nav-pills py-4 px-1" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <button class="nav-link active mx-1 mb-2" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">To Buy</button>
            <button class="nav-link mx-1 mb-2" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">New</button>
            <button class="nav-link mx-1 mb-2" id="v-pills-history-tab" data-bs-toggle="pill" data-bs-target="#v-pills-history" type="button" role="tab" aria-controls="v-pills-history" aria-selected="false">History</button>
        </div>
    </div>

    <div class="container-fluid d-flex justify-content-center">
        <div class="tab-content d-flex my-5 justify-content-center" id="v-pills-tabContent" style="width: 100%;">
            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">

                    <div class="container d-flex justify-content-center py-2 mb-3" style="font-size: .8rem">
                        <div class="search_main">
                            <div class="student_search">
                                <form action="" method="POST">
                                    <input type="hidden" name="userID" value="<?= $_SESSION['u_id'] ?>">
                                    <input class="border-primary rounded-2 px-2 py-1 " type="text" name="user_items" value="" placeholder="Search Item">
                                    <input class="text-primary border-primary rounded-2 px-2 py-1" type="submit" name="search" value="Search">
                                </form>
                                <?php
                                include 'search.php'
                                ?>
                            </div>
                        </div>
                    </div>
                    
                <div class="px-4 position-relative" style="font-size: .7rem;">
                    <?php if (isset($_GET['confirm'])) { ?>
                        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                            <?php
                            $itemID = $_GET['id'];

                            $select = $conn->prepare("SELECT p_id FROM items WHERE p_id = ?");
                            $select->execute([$itemID]);
                            foreach ($select as $selects) { ?>
                                <p class=" text-danger ">Are you sure you want to delete this item?</p>
                                <a href="process.php?delete&id=<?= $selects['p_id'] ?>" type="button" class="btn btn-danger text-decoration-none">Yes</a>
                            <?php } ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } elseif (isset($_GET['clear'])) { ?>
                        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                            <?php
                            $userID = $_GET['user'];

                            $clearAll = $conn->prepare("SELECT user_id FROM history WHERE user_id = ?");
                            $clearAll->execute([$userID]);
                            $data = $clearAll->fetch(PDO::FETCH_ASSOC);
                            if ($data) { ?>
                                <p class=" text-danger ">Are you sure you want to delete all your history?</p>
                                <a href="process.php?clear&user=<?= $data['user_id'] ?>" type="button" class="btn btn-danger text-decoration-none">Yes</a>
                            <?php } ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } elseif (isset($_GET['history'])) { ?>
                        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                            <?php
                            $pID = $_GET['id'];

                            $singleHistory = $conn->prepare("SELECT p_id FROM history WHERE p_id = ?");
                            $singleHistory->execute([$pID]);
                            foreach ($singleHistory as $data) { ?>
                                <p class=" text-danger ">Are you sure you want to delete this item from your history?</p>
                                <a href="process.php?history&id=<?= $data['p_id'] ?>" type="button" class="btn btn-danger text-decoration-none">Yes</a>
                            <?php } ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } elseif (isset($_GET['msg'])) { ?>
                        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                            <strong class=" text-success "><?= $_GET['msg']; ?></strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>

                    <table class="table">
                        <thead align="center">
                            <tr>
                                <th scope="col" class="px-md-4">#</th>
                                <th scope="col" class="text-start px-md-4">Items</th>
                                <th scope="col" class="px-md-4">Price</th>
                                <th scope="col" class="px-md-4">Quantity</th>
                                <th scope="col" class="px-md-4">Total</th>
                                <th scope="col" class="px-md-4">Action</th>
                            </tr>
                        </thead>
                        <tbody align="center">

                            <?php
                            $id = $_SESSION['u_id'];
                            $getID = $conn->prepare("SELECT COUNT(*) FROM items WHERE user_id=?");
                            $getID->execute([$id]);

                            $totalItems = $getID->fetchColumn();

                            $itemsPerPage = 5;
                            $cnt = 1;

                            $currentPage = isset($_GET['page']) ? max(1, $_GET['page']) : 1;

                            $offset = ($currentPage - 1) * $itemsPerPage;

                            $getItems = $conn->prepare("SELECT * FROM items WHERE user_id=? LIMIT $offset, $itemsPerPage");
                            $getItems->execute([$id]);

                            foreach ($getItems as $selects) { ?>
                                <tr>

                                    <th class="px-md-4" scope="row"><?= $cnt++ ?></th>
                                    <td class="px-md-4" align="start"><?= $selects['user_items'] ?></td>
                                    <td class="px-md-4">₱ <?= $selects['user_price'] ?></td>
                                    <td class="px-md-4"><?= $selects['quantity'] ?></td>
                                    <td class="px-md-4">₱ <?= $selects['user_price'] * $selects['quantity'] ?> </td>
                                    <td class="px-md-4">

                                        <div class="dropdown">
                                            <a class="text-decoration-none dropdown-toggle text-black" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>

                                            <ul class="dropdown-menu text-center">
                                                <div class="d-inline-flex">
                                                    <li><a class="dropdown-item" href="process.php?done&id=<?= $selects['p_id'] ?>&user=<?= $selects['user_id'] ?>&item=<?= $selects['user_items'] ?>&price=<?= $selects['user_price'] ?>&quantity=<?= $selects['quantity'] ?>" class="text-decoration-none">✔</a></li>
                                                    <li><a class="dropdown-item" href="index.php?update&id=<?= $selects['p_id'] ?>" class="text-decoration-none">✏</a></li>
                                                    <li><a class="dropdown-item" href="index.php?confirm&id=<?= $selects['p_id'] ?>" class="text-decoration-none">❌</a></li>
                                                </div>
                                            </ul>
                                        </div>
                                    </td>

                                </tr>

                            <?php } ?>
                        </tbody>

                    </table>
                </div>
                <?php
                if (empty($totalItems)) { ?>
                    <div class="container d-flex justify-content-center ">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">

                            </ul>
                        </nav>
                    </div>
                <?php } else { ?>
                    <div class="container d-flex justify-content-center ">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link user-select-none " aria-label="Previous">
                                        <span aria-hidden="true">•</span>
                                    </a>
                                </li>
                                <?php
                                for ($i = 1; $i <= ceil($totalItems / $itemsPerPage); $i++) { ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                <?php } ?>
                                <li class="page-item">
                                    <a class="page-link user-select-none" aria-label="Next">
                                        <span aria-hidden="true">•</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                <?php } ?>
            </div>

            <div class="tab-pane fade show" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0" style="width: 500px; height: 310px; font-size: .7rem;">
                <div class="shadow p-4 rounded-3">
                    <?php
                    if (isset($_GET['update'])) { ?>

                        <?php
                        $id = $_GET['id'];

                        $getUser = $conn->prepare("SELECT * FROM items WHERE p_id = ?");
                        $getUser->execute([$id]);

                        foreach ($getUser as $data) { ?>

                            <form method="POST" action="process.php">
                                <div class="mb-1 row">
                                    <div class="col-3 py-1">
                                        <label for="item" class="form-label"><b>Item:</b></label>
                                    </div>
                                    <div class="col">
                                        <input type="hidden" class="form-control" name="userID" value="<?= $data['p_id'] ?>">
                                        <input type="text" class="form-control" id="item" style="font-size: .7rem;" name="item" value="<?= $data['user_items'] ?>">
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-3 py-1">
                                        <label for="price" class="form-label "><b>Price:</b></label>
                                    </div>
                                    <div class="mb-1 col">
                                        <input type="text" class="form-control" id="price" style="font-size: .7rem;" name="price" value="<?= $data['user_price'] ?>">
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-3 py-1">
                                        <label for="quantity" class="form-label "><b>Quantity:</b></label>
                                    </div>
                                    <div class="mb-1 col">
                                        <input type="text" class="form-control" id="quantity" style="font-size: .7rem;" name="quantity" value="<?= $data['quantity'] ?>">
                                    </div>
                                </div>
                                <div class="my-3 form-check card-body text-center">
                                    <button type="submit" class="btn btn-primary" name="update" value="Update">Update</button>
                                </div>
                            </form>
                        <?php   } ?>
                    <?php } else { ?>


                        <form method="POST" action="process.php">
                            <div id="inputs">
                                <div class="position-relative mb-3">
                                    <div class="mb-1 row">
                                        <div class="col-3 py-1">
                                            <label for="item" class="form-label"><b>Item:</b></label>
                                        </div>
                                        <div class="col">
                                            <input type="hidden" class="form-control" name="userID" value="<?= $_SESSION['u_id'] ?>">
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
                            </div>
                            <div class="my-1 text-center">
                                <a type="button" class="text-decoration-none" onclick="addInput()">
                                    <h1 class="text-success">+</h1>
                                </a>
                            </div>
                            <div class="my-3 form-check card-body text-center">
                                <button type="submit" class="btn btn-primary" name="create">Submit</button>
                            </div>
                        </form>
                    <?php } ?>

                </div>
            </div>


            <div class="tab-pane fade show" id="v-pills-history" role="tabpanel" aria-labelledby="v-pills-history-tab" tabindex="0">
                <table class="table" style="font-size: .7rem;">
                    <thead align="center">
                        <tr>
                            <th scope="col" class="text-start px-md-4">Items</th>
                            <th scope="col" class="px-md-4">Price</th>
                            <th scope="col" class="px-md-4">Quantity</th>
                            <th scope="col" class="px-md-4">Total</th>
                            <th scope="col" class="px-md-4">Action</th>
                        </tr>
                    </thead>

                    <tbody align="center">
                        <tr>
                            <?php
                            $userID = $_SESSION['u_id'];

                            $getHistory = $conn->prepare("SELECT * FROM history WHERE user_id = ?");
                            $getHistory->execute([$userID]);

                            foreach ($getHistory as $history) { ?>

                                <td class="px-md-4" align="start"><?= $history['user_items'] ?></td>
                                <td class="px-md-4">₱ <?= $history['user_price'] ?></td>
                                <td class="px-md-4"><?= $history['quantity'] ?> pcs.</td>
                                <td class="px-md-4">₱ <?= $history['user_price'] * $history['quantity'] ?> </td>
                                <td class="text-center px-md-4 ">
                                    <a href="index.php?history&id=<?= $history['p_id'] ?>" class="text-decoration-none">❌</a>
                                </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <div class="my-3 form-check card-body text-center">
                    <a href="index.php?clear&user=<?= $history['user_id'] ?>" class="btn btn-danger" name="clear">🗑</a>
                </div>
            </div>


        </div>
    </div>
</div>
</div>
</body>

</html>