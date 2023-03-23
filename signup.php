<?php
require_once  "header.php";
?>

<main>
    <script>
        function validateSignup(form) {
            fail = validatename(form.name.value)
            fail += validateUsername(form.username.value)
            fail += validatePassword(form.pwd.value)
            fail += validatePhone(form.phone.value)
            fail += validateEmail(form.email.value)
            if (fail == "") return true
            else {
                alert(fail);
                return false
            }
        }

        function validatename(field) {
            return (field == "") ? "No name was entered.\n" : ""
        }

        function validateUsername(field) {
            if (field == "") return "No username was entered.\n"
            else if (field.length < 5)
                return "Usernames must be at least 5 characters.\n"
            else if (/[^@.a-zA-Z0-9_-]/.test(field))
                return "Only a-z, A-Z, 0-9, @, -, _ and . allowed in Usernames.\n"
            return ""
        }

        function validatePassword(field) {
            if (field == "") return "No password was entered.\n"
            else if (field.length < 4)
                return "Passwords must be at least 4 characters.\n"
            return ""
        }

        function validatePhone(field) {
            if (field == "") return "No phone was entered.\n"
            return ""
        }

        function validateEmail(field) {
            if (field == "") return "No e-mail was entered.\n"
            else if (!((field.indexOf(".") > 0) &&
                    (field.indexOf("@") > 0)) ||
                /[^a-zA-Z0-9.@_-]/.test(field))
                return "The Email address is invalid.\n"
            return ""
        }
    </script>
    <br>

    <div class="vh-50 d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="border border-3 border-primary"></div>
                    <div class="card bg-white shadow-lg">
                        <div class="card-body p-5">
                            <form action="incl/signup.incl.php" method="post" onsubmit="return validateSignup(this)" class="mb-3 mt-md-4">
                                <h2 class="fw-bold mb-2 text-uppercase "></h2>
                                <?php
                                if (isset($_GET['error'])) {
                                    if ($_GET['error'] == "usertaken") {
                                        echo '<p class="usererror"> User already exists!</p>';
                                    } else if ($_GET['error'] == "emptyfields") {
                                        echo '<p class="usererror">Fill in all fields!</p>';
                                    } else if ($_GET['error'] == "pwdcheck") {
                                        echo '<p class="usererror">Passwords do not match!</p>';
                                    } else if ($_GET['error'] == "invalidusermail") {
                                        echo '<p class="usererror">Invalid username and e-mail!</p>';
                                    } else if ($_GET['error'] == "invalidemail") {
                                        echo '<p class="usererror">Invalid e-mail!</p>';
                                    } else if ($_GET['error'] == "invaliduser") {
                                        echo '<p class="usererror">Invalid username!</p>';
                                    } else if ($_GET['error'] == "emailtaken") {
                                        echo '<p class="usererror">E-Mail already exists!</p>';
                                    }
                                } else if (isset($_GET['signup'])) {
                                    if ($_GET['signup'] == "success") {
                                        echo '<p class="usersuccess">Success!</p>';
                                    }
                                }
                                ?>
                                <p class=" mb-5">Please fill in all fields:</p>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control" id="username" placeholder="name@example.com">
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="John Smith">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="text" name="email" class="form-control" id="email" placeholder="name@example.com">
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" id="phone" placeholder="+812568813359">
                                </div>
                                <div class="mb-3">
                                    <label for="usernaddressame" class="form-label">Address</label>
                                    <input type="text" name="address" class="form-control" id="address" placeholder="Wagner str. 64">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label ">Password</label>
                                    <input type="password" name="pwd" class="form-control" id="password" placeholder="*******">
                                </div>
                                <div class="mb-3">
                                    <label for="password2" class="form-label ">Repeat password</label>
                                    <input type="password" name="pwd2" class="form-control" id="password" placeholder="*******">
                                </div>
                                <div class="d-grid">
                                    <button name="signup-submit3" class="btn btn-outline-dark" type="submit">Sign-up</button>
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