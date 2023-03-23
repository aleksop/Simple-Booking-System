<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Linus. Reservation.</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="img/favicon-96.png">
    <link rel="icon" type="image/png" sizes="120x120" href="img/favicon-120.png">
    <link rel="icon" type="image/png" sizes="192x192" href="img/favicon-192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png">
    <link rel="mask-icon" href="img/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="stylesheet" type="text/css" href="css/calendar.css">
    <link rel="stylesheet" type="text/css" href="css/prices.css">
    <link rel="stylesheet" type="text/css" href="css/reviews.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="msapplication-TileImage" content="img/mstile150.png">
    <meta name="msapplication-square70x70logo" content="img/mstile70.png">
    <meta name="msapplication-square150x150logo" content="img/mstile150.png">
    <meta name="msapplication-square310x310logo" content="img/mstile310.png">
    <meta name="application-name" content="Booking electrician">
    <meta name="msapplication-config" content="browserconfig.xml">
    <meta name="msapplication-TileColor" content="#da532c">
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#ffffff">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <script>
        function validate(form) {
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
            else if (/[^a-zA-Z0-9_-]/.test(field))
                return "Only a-z, A-Z, 0-9, - and _ allowed in Usernames.\n";
            return ""
        }

        function validatePassword(field) {
            if (field == "") return "No Password was entered.\n"
            return ""
        }
    </script>

    <header>

        <div id="bar" style="text-align: center;">
            Welcome to Linus page!
            <img src="img/box.png" style="width: 140px; float: right">
            <a href="index.php"><img src="img/favicon192.png" style="width: 140px; float: left"></a>
            <br> <br>
            <div style="font-size: 25px">
                Here you can set a reservation date, find out the prices and contact Linus directly
            </div>
        </div>
        <nav>
            <ul id="menu">
                <li><a href="prices.php" class="nav_links">Prices</a></li>
                <li><a href="reservation.php" class="nav_links">Make a reservation</a></li>
                <li><a href="reviews.php" class="nav_links">Reviews</a></li>
                <?php
                if (isset($_SESSION['userId'])) { ?>
                    <li>        <a href="incl/logout.incl.php" class="buttonLogin">Log out</a> </li>

                    <?php echo '<a href="profile.php" class="profileLink">' . $_SESSION['userName'] . "</a></li>";
                } else {
                    ?>
                    <li>
                        <a href="login.php" class="buttonLogin">Log in</a></li>
                     <li>   <a href="signup.php" class="buttonSignup">Sign up</a>
                    </li>
                    <?php } ?>
            </ul>
        </nav>

    </header>