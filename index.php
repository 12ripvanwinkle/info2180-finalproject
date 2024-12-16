<?php
session_start();
// if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
//     header('Location: log.php');
//     exit;
// }
?>


<!DOCTYPE html>

<html lang="en">

    <!-- Head -->    

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		
		<title> INFO2180 - Customer Relationship Management (CRM) </title>
	
        <link rel="stylesheet" href="dolphin.css">  
        <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <link rel = "stylesheet" href = "https://unicons.iconscout.com/release/v4.0.8/css/line.css"> 

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="dolphin.js"></script>
	</head>

    <!--- Body --->

	<body>

        <!-- Header -->

        <header class="dashboard-header" id="header">            
            <h6 class="header-title"> <img src="dolphin.png" alt="Dolphin Image" class="img"> Dolphin CRM </h6>
        </header>

        <!-- Main -->
        
		<main class="dashboard-main" id="main">

            <!--- Sidebar --->

            <section class="sidebar" id="sidebar">
                <nav class = "nav">                  
                    <ul class = "nav-list">
                        <li class = "nav-item">
                            <i class="uil uil-house-user"></i>
                            
                            <a href = "#home" onclick="      " class = "nav-link"> 
                                Home 
                            </a>
                        </li>
    
                        <li class = "nav-item">
                            <i class="uil uil-user-circle"></i>

                            <a href = "#contacts" onclick="      " class = "nav-link"> 
                                New Contact 
                            </a>
                        </li>
    
                        <li class = "nav-item">
                            <i class="uil uil-user-plus"></i>

                            <a href = "#users" onclick="      " class = "nav-link"> 
                                Users 
                            </a>
                        </li>

                        <hr>

                        <li class = "nav-item">
                            <i class="uil uil-signout"></i>
                            <a href = "#" class = "nav-link" id="logoutLink"> 
                                Log Out 
                            </a>
                        </li>
                    </ul> 
                </nav>
            </section>

            <!--- Dashboard Area --->

            <section class="dashboard-area">
            </section>
            <?php
                if (isset($_SESSION['just_logged_in'])) {
                    echo '<script type="text/javascript">',
                    "$(document).ready(function() {",
                    "$('a[href=\"#home\"]').trigger('click');",
                    "});",
                    '</script>';
                    unset($_SESSION['just_logged_in']);
                }
            ?>



		</main>
	</body>
</html>