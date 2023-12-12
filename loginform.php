<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
    <?php include("assets/nav.php"); ?>
    <main>
        <div class="content">
            

            <div class="loginView">  
            <h2>Login Form</h2>  

                <div class="loginForm">          
                    <form method="post" action="login.php">
                        <div class="labelInput">
                            <label class="iconField" for="naam"><i class='bx bxs-user'></i></label>
                            <input type="text" id="naam" name="naam" placeholder="Username" value="<?php echo isset($_SESSION['usernamePost']) ? $_SESSION['usernamePost'] : ''; ?>" required>
                        </div>
                        <div class="labelInput">
                            <label class="iconField" for="wachtwoord"><i class='bx bxs-lock-alt' ></i></label>
                            <input type="password" id="wachtwoord" name="wachtwoord" placeholder="Password" value="<?php echo isset($_SESSION['passwordPost']) ? $_SESSION['passwordPost'] : ''; ?>" required>
                        </div>
                        <input type="submit" value="Login" class="submitButton">
                        <p class="redirect">New here? <a href="registerForm">Sign up now<i class='bx bxs-right-arrow-alt'></i></a></p>
                        
                    </form> 
                    <div class="messagePHP"><?php
                        if (isset($_SESSION['message'])) {
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                        }
                        
                        ?></div>
                        <?php if (isset($_GET['message'])) { ?>
                        <div class="message">
                            <?php echo $_GET['message']; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>
    <style>
        input {
            width: 200px;
            padding: 10px 15px;
            margin: 5px 0;
            box-sizing: border-box;
        }
    </style>
    <script src="assets/main.js"></script>

</body>
</html>
