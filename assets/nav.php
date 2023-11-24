
<nav>
    <div class="logo">
        <a class="bas" href="index">Stadsklacht</a>
        <p class="bbb">Voor een leefbare Rotterdam</p>
        <!-- <img src="img/basLogo.png" alt="Bas Logo"> -->
    </div>

    <div class="navContainer">
        <div> <a href="index" class="navLink">Home</a>
            <?php
                require 'database/database.php';

                // Check if user is logged in
                if(isset($_SESSION['username'])) {
                    require 'function.php';
                

                    // Display different navigation bar based on user's 'functie'
                    switch($rights) {
                        case "admin":
                            echo '<a href="registerForm" class="navLink">Register</a>'; 
                            echo '<div class="dropdown">';
                            echo '<button class="dropbtn">Management Systeem</button>';
                            echo '<div class="dropdown-content">';
                            echo '<a href="klantReadManagement" class="navLink">Klant</a>'; 
                            echo '<a href="boekingReadManagement" class="navLink">Boekingen</a>'; 
                            echo '</div>';
                            echo '</div>';
                            echo '<div class="dropdown">';
                            echo '<button class="dropbtn">Admin</button>';
                            echo '<div class="dropdown-content">';
                            echo '<a href="adminTableBoekingen" class="navLink">Boekingen</a>'; 
                            echo '<a href="adminTableTochten" class="navLink">Tochten</a>'; 
                            echo '<a href="adminTableKlanten" class="navLink">Klanten</a>'; 
                            echo '<a href="adminTableStatussen" class="navLink">Statussen</a>'; 
                            echo '</div>';
                            echo '</div>';
                            break;
                        case "management":
                            // echo '<a href="registerForm" class="navLink">Register</a>'; 
                            echo '<div class="dropdown">';
                            echo '<button class="dropbtn">Management Systeem</button>';
                            echo '<div class="dropdown-content">';
                            echo '<a href="klantReadManagement" class="navLink">Klant</a>'; 
                            echo '<a href="boekingReadManagement" class="navLink">Boekingen</a>'; 
                            echo '</div>';
                            echo '</div>';
                            break;
                        case 'NULL'|| NULL:
                            // Display navigation bar for klant
                            echo '<a href="about" class="navLink">About</a>'; 
                            echo '<a href="contact" class="navLink">Contact</a>'; 
                            echo '<div class="dropdown">';
                            echo '<button class="dropbtn">Boekingen</button>';
                            echo '<div class="dropdown-content">';
                            echo '<a href="boekingRead" class="navLink">Inzien</a>'; 
                            echo '<a href="boekingCreateForm" class="navLink">Aanvragen</a>'; 
                            echo '</div>';
                            echo '</div>';     
                            break;
                    default:
                        // Display default navigation bar
                        break;
                    }

                } else {

                    // Display navigation bar for non-logged-in users
                    ?>
                    <a href="about" class="navLink">About</a>
                    <a href="contact" class="navLink">Contact</a>
                    <?php

                }

            ?>
        </div>  
    </div>
    <div class="navLogin">
        <?php if(isset($_SESSION['username'])):?>
            <a href="account" class="navLinkLogin"><?php echo $_SESSION['username']; ?>: <i class='bx bxs-user-detail' ></i></a>
            <a href="logout" class="navLinkLogin">Logout: <i class='bx bxs-user-minus' ></i></a>
            <?php else: ?>
            <a href="loginForm" class="navLinkLogin">Login: <i class='bx bxs-user' ></i></a>
            <a href="registerForm" class="navLinkLogin">Register: <i class='bx bxs-user-plus'></i></a>
        <?php endif; ?>
 
    </div>
</nav>
