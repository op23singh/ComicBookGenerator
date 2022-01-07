<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head></head>

<body>
    <style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    * {
        box-sizing: border-box
    }

    /* Full-width input fields */
    input[type=text],
    input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    input[type=text]:focus,
    input[type=password]:focus {
        background-color: #ddd;
        outline: none;
    }

    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
    }

    /* Set a style for all buttons */
    button {
        background-color: #04AA6D;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }

    button:hover {
        opacity: 1;
    }

    /* Extra styles for the cancel button */
    .cancelbtn {
        padding: 14px 20px;
        background-color: #f44336;
    }

    /* Float cancel and signup buttons and add an equal width */
    .cancelbtn,
    .signupbtn {
        float: left;
        width: 50%;
    }

    /* Add padding to container elements */
    .container {
        padding: 16px;
    }

    /* Clear floats */
    .clearfix::after {
        content: "";
        clear: both;
        display: table;
    }

    /* Change styles for cancel button and signup button on extra small screens */
    @media screen and (max-width: 300px) {

        .cancelbtn,
        .signupbtn {
            width: 100%;
        }
    }
    </style>

    <body>

        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" style="border:1px solid #ccc" method="post">
            <div class="container">
                <h1>Sign Up</h1>
                <p>Please fill in this form to create an account.</p>
                <hr>

                <label for="email"><b>E_mail</b></label>
                <input type="text" name='email' placeholder="Enter E_mail" name="email" required>

                <label for="username"><b>Full Name</b></label>
                <input type="text" name='username' placeholder="Enter Full Name" required>

                <label for="password"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" required>

                <label for="cpassword"><b>Repeat Password</b></label>
                <input type="password" name='cpassword' placeholder="Confirm Password" required>

                <label for="mobile"><b>Phone</b></label>
                <input type="text" name='mobile' placeholder="Enter mobile number" required>

                <!-- <label>
      <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
    </label> -->

                <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>

                <div class="clearfix">
                    <button type="button" class="cancelbtn">Cancel</button>
                    <button type="submit" name='submit' class="signupbtn">Sign Up</button>
                </div>
                <p> Already Have an account ?<a href="login.php" style="color:dodgerblue"> Login</a></p>
            </div>
        </form>
        <?php
        include 'dbcon.php';
        include 'sendgrid/config.php';
        include 'sendgrid/vendor/autoload.php';
        if (isset($_POST['submit'])) {
            $username = mysqli_real_escape_string($con, $_POST['username']);
            $password = mysqli_real_escape_string($con, $_POST['password']);
            $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
            $E_mail = mysqli_real_escape_string($con, $_POST['email']);
            $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
            $pass = password_hash($password, PASSWORD_BCRYPT);
            $cpass = password_hash($cpassword, PASSWORD_BCRYPT);
            $query = mysqli_query($con, "select * from registration where email='$E_mail'") or die(mysqli_error($con));
            $count = mysqli_num_rows($query);
            $token = bin2hex(random_bytes(15));
            $status = "inactive";
            $E_mail = trim($E_mail);
            if ($count > 0) {
                echo "email already exits";
            } else {
                if ($password === $cpassword) {
                    $insertQuery = "insert into registration(username,email,mobile,password,cpassword,token,status) values('$username','$E_mail','$mobile','$pass','$cpass','$token','$status')";
                    $iquery = mysqli_query($con, $insertQuery) or die(mysqli_error($con));
                    if ($iquery) {
                        echo '<script type="text/javascript"> alert("user inserted successfully");</script>';
                        $to_email = $E_mail;
                        $subject = "Simple Email Test via PHP";
                        $body = "please click to verify http://localhost/vscode_php/activate.php?token=$token";
                        $headers = "From: indinikumar01200@gmail.com";

                        if (mail($to_email, $subject, $body, $headers)) {
                            echo "Email successfully sent to $to_email...";
                            $_SESSION['message'] = "please verify your account $to_email";
                            header('location:login.php');
                        } else {
                            echo "Email sending failed...";
                        }
                    } else {
                        echo '<script type="text/javascript">
            alert("user is not inserted");
            </script>';
                    }
                } else {
                    echo "passwords are not matching";
                }
            }
        }
        ?>

    </body>

</html>
//from line 153
/* $email = new \SendGrid\Mail\Mail();
<!-- // $email->setFrom('onkarpreetsingh23@gmail.com', 'op');
// $email->setSubject("verify your email");
// $email->addTo($E_mail, $username);
// $email->addContent("text/plain", "Hi,'$username'. Click here too activate your account
// http://localhost/vscode_php/activate.php?token=$token ");
// $email->addContent(
//     'text/html',
//     "<a href='http://localhost/vscode_php/activate.php?token=$token'>Verify now</a>"
// );
// $sendgrid = new \SendGrid(SENDGRID_APIKEY);
// try {
//     $response = $sendgrid->send($email);
//     if ($response->statusCode() == '202') {
//         $_SESSION['message'] = "check your email to activate your account '$E_mail'";
//         header('location:login.php');
//     } else {
//         echo "email sending failed ";
//     }
//     print $response->statusCode() . "\n";
//     print_r($response->headers());
//     print $response->body() . "\n";
// } catch (Exception $e) {
//     echo 'Caught exception: ' . $e->getMessage() . "\n";
// }*/ -->