<?php
require_once  "header.php";
?>

<main>
  <script>
    function validateLogin(form) {
      fail = validatePassword(form.pwd.value)
      fail += validateUsername(form.username.value)
      if (fail == "") return true
      else {
        alert(fail);
        return false
      }
    }

    function validateUsername(field) {
      if (field == "") return "No Username was entered.\n";
      else if (field.length < 4)
        return "Usernames must be at least 4 characters.\n";
      else if (/[^@.a-zA-Z0-9_-]/.test(field))
        return "Only a-z, A-Z, 0-9, @, -, _ and . allowed in Usernames.\n"
      return ""
    }

    function validatePassword(field) {
      if (field == "") return "No Password was entered.\n"
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
              <form action="incl/login.incl.php" method="post" onsubmit="return validateLogin(this)" class="mb-3 mt-md-4">
                <h2 class="fw-bold mb-2 text-uppercase "></h2>
                <?php
                if (isset($_GET['error'])) {
                  if ($_GET['error'] == "wrongpassword") {
                    echo '<p class="usererror"> Wrong password!</p>';
                  }
                  if ($_GET['error'] == "notexists") {
                    echo '<p class="usererror"> Wrong username!</p>';
                  }
                } else if (isset($_GET['login'])) {
                  if ($_GET['login'] == "success") {
                    echo '<p class="usersuccess">Success!</p>';
                  }
                }
                ?>
                <p class=" mb-5">Please enter your login and password!</p>
                <div class="mb-3">
                  <label for="username" class="form-label ">Email address</label>
                  <input type="text" name="username" class="form-control" id="email" placeholder="name@example.com">
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label ">Password</label>
                  <input type="password" name="pwd" class="form-control" id="password" placeholder="*******">
                </div>
                <div class="d-grid">
                  <button name="login-submit3" class="btn btn-outline-dark" type="submit">Login</button>
                </div>
              </form>
              <div>
                <p class="mb-0  text-center">Don't have an account? <a href="signup.php" class="text-primary fw-bold">Sign
                    Up</a></p>
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