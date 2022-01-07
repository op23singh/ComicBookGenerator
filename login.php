<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    form {
        border: 3px solid #f1f1f1;
    }

    input[type=text],
    input[type=password] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    button {
        background-color: #04AA6D;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
    }

    button:hover {
        opacity: 0.8;
    }

    .cancelbtn {
        width: auto;
        padding: 10px 18px;
        background-color: #f44336;
    }

    .imgcontainer {
        text-align: center;
        margin: 24px 0 12px 0;
    }

    img.avatar {
        width: 20%;
        border-radius: 50%;
    }

    .container {
        padding: 16px;
    }

    span.psw {
        float: right;
        padding-top: 16px;
    }

    /* Change styles for span and cancel button on extra small screens */
    @media screen and (max-width: 300px) {
        span.psw {
            display: block;
            float: none;
        }

        .cancelbtn {
            width: 100%;
        }
    }
    </style>
</head>

<body>

    <h2>Login Form</h2>
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>" method="post">
        <div class="imgcontainer">
            <img src="img_avatar2.png" alt="Avatar" class="avatar">
        </div>
        <?php
        if (isset($_SESSION['message'])) {
            echo "<div class='container' style='background-color:greenyellow;text-align:center'>";
            echo "<h1>";
            echo $_SESSION['message'];
            echo "</h1></div>";
        }
        ?>
        <div class="container">
            <label for="email"><b>Username</b></label>
            <input type="text" placeholder="Enter email" name="email" required>

            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>

            <button type="submit" name="login">Login</button>
            <!-- <label>
                <input type="checkbox" checked="checked" name="remember"> Remember me
            </label> -->
            <p>already have an account ? <a href="signup.php">Signup</a></p>
        </div>
        <!-- <div class="container" style="background-color:#f1f1f1">
            <button type="button" class="cancelbtn">Cancel</button>
            <span class="psw">Forgot <a href="#">password?</a></span>
        </div> -->
    </form>
    <?php
    include 'dbcon.php';
    if (isset($_POST['login'])) {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $hash_password = password_hash($password, PASSWORD_BCRYPT);
        $Query = "select email ,password,username,status from registration having email='$email' and status='active'";
        $searchQuery = mysqli_query($con, $Query) or die(mysqli_error($con));
        $search_count = mysqli_num_rows($searchQuery);
        if ($search_count > 0) {
            $user = mysqli_fetch_assoc($searchQuery);
            $_SESSION['username'] = $user['username'];
            if (password_verify($password, $user['password'])) {
                echo "login successful";
                echo '<script>location.replace("success.php")</script>';
            } else {
                echo "incorrect password";
            }
        } else {
            echo 'invalid email';
        }
    }
    ?>
</body>

</html>