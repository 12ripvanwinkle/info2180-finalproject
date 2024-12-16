<!DOCTYPE html>

<html lang="en">

    <!--- Head --->

    <head>
        <meta charset="UTF-8">
        <meta http-equiv = "X-UA-Compatible" content= "IE=edge">
        <link rel="stylesheet" href="dolphinStyle.css"> 
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

        <!--- Main --->

        <main class="login-main" id="main">

            <!--- Login --->

            <section class="form-wrapper">

                <form action="" class="login-form" id="login-form">
                    
                    <h1 class="login-title">Login</h1>

                    <div class="form-content">
                        <div class="form-box" id="login-box">
                            <div class="form-box-input" id="login-box-input">
                                <input type = "email" 
                                    class = "login-input" 
                                    placeholder = "Email address"
                                    id="email">
                            </div>  
                            
                            <div class="form-box-input" id="login-box-input">
                                <input type = "password" 
                                    class = "login-input" 
                                    placeholder = "Password" 
                                    id = "pass">
                            </div>    
                        </div>  
                    </div>

                    <button type ="button" class="login-btn" id="form-btn">Login</button> <!-- Note: JS Needed -->


                </form>

                <hr class="footer-line">

                <footer class="login-footer" id="footer">
                    <h6 class="footer-title"> Copyright &copy 2022 Dolphin CRM </h6>
                </footer>
            </section>      
        </main>                    
    </body>
</html>