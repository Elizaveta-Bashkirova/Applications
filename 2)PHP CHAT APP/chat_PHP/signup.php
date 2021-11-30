<DOCTYPE html>
    <html>
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Signup</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
        </head>
        <body>
        
            <?php
            session_start();
            include "connection.php";
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
            include "connection.php";
            $email="";
            $password="";
            $firstname="";
            $lastname="";
            function basicvalidate($data){
                $data=htmlspecialchars($data);
                $data=stripslashes($data);
                $data=trim($data);
                return $data;
            }
        
            if ($_SERVER['REQUEST_METHOD']=="POST"){
                $email=basicvalidate($_POST['email']);
                $password=basicvalidate($_POST['password']);
                $firstname=basicvalidate($_POST['fname']);
                $lastname=basicvalidate($_POST['lname']);                
                $date = Date('Y-m-d H:i:s');                
                $sql="INSERT INTO users (email,password,firstname,lastname,reg_date) VALUES ('$email','$password','$firstname','$lastname','$date');";
                if(mysqli_query($conn,$sql)){
                    header("Location:login.php");
                }
            }
            ?>        
            <div class='container-fluid shadow-lg p-3 mb-5 bg-body rounded'>
                <h3>Создание нового аккаунта </h3>
            </div>        
            <div class="container">
                <div class="row">
                    <div class="col">
                    </div>
                    <div class="col container shadow-lg p-3 mb-5 bg-body rounded">
                        <form method = "POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                        <p>email: <input type ="email" class="form-control is-invalid" id="floatingInputInvalid" placeholder="liza@example.com" name="email" required><br></p>
                        <p>Пароль: <input  type="password" class="form-control is-invalid" id="floatingInputInvalid" name= "password" placeholder="пароль" required><br></p>
                        <p>Имя: <input class="form-control is-invalid" type="textarea" name= "fname" placeholder="Елизавета"required><br></p>
                        <p>Фамилия: <input class="form-control is-invalid" type="textarea" name= "lname" placeholder="Башкирова" required><br></p>
                        <input class='btn btn-outline-secondary'type="submit" value="Создать">
                        </form>
                        <button class='btn btn-outline-secondary' onclick="window.location.href='login.php'" > Уже есть аккаунт</button>
                    </div>
                    <div class="col">
                    </div>
                </div>
            </div>
        </body>
    </html>