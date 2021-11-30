<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>LogIn Form</title>
    <link rel="stylesheet" type="text/css" href="css/style.css?<?echo time();?>">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.16.1/TweenMax.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>

<body>

    <div class="heading">Good Style</div>
    <div id="login-button">
        <img src="img/login-w-icon.png">
    </div>
    <!-- LogIn Container -->
    <div id="container">
        <h1>Log In</h1>
        <span class="close-btn">
    <img src="img/circle_close_delete_-128.webp">
  </span>

        <form action="php/login.php" method="post">
            <input type="email" name="login" placeholder="E-mail">
            <input type="password" name="password" placeholder="Password">
            <input type="submit" name="enter" value="Log in">
            <div class="remember-container">
                <input type="checkbox" id="checkbox-2-1" class="checkbox" checked="checked" />
                <span id="remember">Remember me</span>
                <span id="register">go to register</span>
            </div>
        </form>
    </div>

    <!-- Register Container -->
    <div id="register-container">
        <h1>Register</h1>
        <span class="close-btn">
    <img src="img/circle_close_delete_-128.webp">
  </span>

        <form action="php/register.php" method="post" onsubmit="return validate();">
            <input type="text" id="name_id" name="register_name" placeholder="Name">
            <input type="email" id="email_id" name="register_login" placeholder="E-mail">
            <input type="password" id="password_id" name="register_password" placeholder="Password">
            <input type="submit" name="register_enter" value="Create account">
            <div class="remember-container">
                <span id="register-back">go to login</span>
            </div>
        </form>
    </div>

   
    <script src="js/index.js"></script>
    <script>
        function validate() {
            var name_pattern = /^[a-zA-Z0-9]+$/; //pattern allowed alphabet a-z or A-Z or 0-9
            var email_pattern = /^[\w\d\.]+\@[a-zA-Z\.]+\.[A-Za-z]{1,4}$/; //pattern valid email validation
            var password_pattern = /^[A-Z a-z 0-9 !@#$%&*()<>]{3,30}$/; //pattern password allowed A to Z, a to z, 0-9, !@#$%&*()<> charecter 

            var name = document.getElementById("name_id"); //textbox id name_id
            var email = document.getElementById("email_id"); //textbox id email_id
            var password = document.getElementById("password_id"); //textbox id password_id

            name.style.background = 'none';
            email.style.background = 'none';
            password.style.background = 'none';

            if (!name_pattern.test(name.value) || name.value == '') {
                alert("Enter Firstname Alphabet Only....!");
                name.focus();
                name.style.background = '#f08080';
                return false;
            }
            if (!email_pattern.test(email.value) || email.value == '') {
                alert("Enter Valid Email....!");
                email.focus();
                email.style.background = '#f08080';
                return false;
            }
            if (!password_pattern.test(password.value) || password.value == '') {
                alert("Password Must Be 6 to 12 and allowed !@#$%&*()<> character");
                password.focus();
                password.style.background = '#f08080';
                return false;
            }

        }
    </script>
</body>

</html>