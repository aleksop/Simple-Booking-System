<?php
require_once  "header.php";
?>
<br>
<main>
    <br>
    <center>
        <h1>Profile</h1><br>
    </center>
    <div class="vh-50 d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="border border-3 border-primary"></div>
                    <div class="card bg-white shadow-lg">
                        <div class="card-body p-5">
                            <form action="incl/profile.incl.php" method="post" onsubmit="return validateSignup(this)" class="mb-3 mt-md-4">
                                <input type="hidden" name="userId" placeholder="userId" class="signu" value="<?php echo $_SESSION['userId'] ?>">
                                <h2 class="fw-bold mb-2 text-uppercase"></h2>
                                <?php

                                if (isset($_GET['error'])) {
                                    if ($_GET['error'] == "emptyfields") {
                                        echo '<p class="usererror">Fill in all fields!</p>';
                                    } else if ($_GET['error'] == "invaliduser") {
                                        echo '<p class="usererror">Invalid username!</p>';
                                    } else if ($_GET['error'] == "invalidemail") {
                                        echo '<p class="usererror">Invalid e-mail!</p>';
                                    }
                                } else if (isset($_GET['update'])) {
                                    if ($_GET['update'] == "success") {
                                        echo '<p class="usersuccess">Success!</p>';
                                    }
                                }

                                if (isset($_SESSION['userName'])) {
                                    require_once  'classes/dbh.classes.php';
                                    require_once  'classes/users.classes.php';
                                    $user = new Users;
                                    $userData = $user->getUserByName($_SESSION['userName']);
                                } else {
                                    header("Location: ../index.php");
                                    exit();
                                }
                                ?>
                                <p class=" mb-5"><?php echo "User " . $_SESSION['userName'] . " data and settings: "; ?></p>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="John Smith" value="<?php echo $userData['name']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="text" name="email" class="form-control" id="email" placeholder="name@example.com" value="<?php echo $userData['email']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" id="phone" placeholder="+812568813359" value="<?php echo $userData['phone']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="usernaddressame" class="form-label">Address</label>
                                    <input type="text" name="address" class="form-control" id="address" placeholder="Keppler str. 64" value="<?php echo $userData['address']; ?>">
                                </div>
                                <div class="d-grid">
                                    <button name="signup-submit3" class="btn btn-outline-dark" type="submit">Update</button>
                                </div>
                            </form>
                            <div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
require_once  "footer.php";
?>