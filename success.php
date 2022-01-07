<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: login.php');
}
?>
<!DOCTYPE html>
<html>

<head>
    <style>
    .w3-green,
    .w3-hover-green:hover {
        color: #fff !important;
        background-color: #4CAF50 !important
    }

    .w3-panel {
        padding: 0.01em 16px
    }
    </style>
</head>

<body>
    <h2>Display Success</h2>
    <h1>hello <?php echo $_SESSION['username']; ?>You have already subcribed to xccd random comic book sender</h1>

    <div class="w3-panel w3-pale-green w3-border">
        <h3>Success!</h3>
        <p>Green often indicates something successful or positive.</p>
    </div>

    <div class="w3-panel w3-green">
        <h3>Success!</h3>
        <p>Green often indicates something successful or positive.</p>
    </div>
    <button type="submit" name="logout">Logout</button>
    <script>
    document.getElementsByName("logout")[0].addEventListener("click", function() {
        location.replace("logout.php");
    });
    </script>
</body>

</html>