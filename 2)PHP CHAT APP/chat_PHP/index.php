<DOCTYPE html>
    <html>
        <head>
            <title>The Project</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
            <script>
                function isfriend(email){
                    document.getElementById(email).innerHTML="Ваш друг";
                    document.getElementById(email).type="button";
                }
                function isfriendd(email){
                    document.getElementById(email).innerHTML="Предлагает дружбу";
                    document.getElementById(email).type="button";
                }
            </script>
        </head>
        <body>
            <?php
                //Проверка ошибок
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                session_start();
                include "connection.php";
                include "functions.php";
                //Отправить заявку
                if (isset( $_POST['addfriend'])){
                    $source = $_SESSION['email'];
                    $target =  $_POST['addfriend'];
                    $sql="INSERT INTO friend_requests (source,target) values('$source','$target')";
                    $sqlcheck="select source, target from friend_requests where source='$target' AND target='$source' union select source, target from friend_int where source = '$source' AND target = '$target' union select source,target from friend_int where source = '$target' AND target='$source';";
                    $result=mysqli_query($conn,$sqlcheck);
                if(mysqli_num_rows($result)==0)
                    mysqli_query($conn,$sql);
                    header("Location: index.php");
                }
                //Принять друга
                if (isset( $_POST['accept'])){
                    $email=$_SESSION['email'];
                    $source= $_POST['accept'];
                    $sql= "insert into friend_int (source,target) values ('$source','$email');";
                    mysqli_query($conn,$sql);
                    $sql="delete from friend_requests where source='$source' AND target = '$email';";
                    mysqli_query($conn,$sql);
                    header("Location: index.php");
                }
                //Удаление друга
                if (isset( $_POST['delete'])){
                    $email=$_SESSION['email'];
                    $source= $_POST['delete'];
                    $sql = "delete from friend_int where (source ='$source' AND target= '$email') OR (target = '$source' AND source= '$email');";
                    mysqli_query($conn,$sql);
                    header("Location: index.php");
                }
                //Отмена друга
                if (isset( $_POST['reject'])){
                    $email=$_SESSION['email'];
                    $source= $_POST['reject'];
                    $sql = "delete from friend_requests where source = '$source' AND target='$email'";
                    mysqli_query($conn,$sql);
                    header("Location: index.php");
                }
                //Подсчёт заявок
                function requests($conn,$email){
                    $sql="select count(target) as requests from friend_requests where target = '$email'";
                    $result = mysqli_query($conn,$sql);
                    $req = mysqli_fetch_assoc($result);
                    return $req['requests'];
                }
                if (isset($_POST['friendemail'])){
                    $_SESSION['friendemail']=$_POST['friendemail'];
                    $_SESSION['friendname']=ucfirst($_POST['friendname']);
                    header("Location: msg.php");
                }

                //Проверка логина
                checklogin($conn);
                $name = $_SESSION['name'];
            ?>
            <div class='container-fluid shadow-lg p-3 mb-5 bg-body rounded'>
                <div class='row '>
                    <div class='col-3'><h3> Профиль :  <?php echo $name;?></h3></div>
                    <div class='col'><button onclick="window.location.href='logout.php'" class='btn btn-outline-secondary' style ="float:right;">Выйти</button>
                    <!-- Функция заявки в друзья -->
                        <?php
                            $email = $_SESSION['email'];
                            $sql="select source from friend_requests where target = '$email';";
                            $result = mysqli_query($conn,$sql);
                            
                                echo "<div style = 'float:right;'   class='dropdown'><button class='btn btn-secondary dropdown-toggle' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'> Заявки в друзья <span class='badge bg-secondary'>".requests($conn,$_SESSION['email'])."</span> </button> <ul class='dropdown-menu' aria-labelledby='dropdownMeneButton1'>";
				if (mysqli_num_rows($result)==0){
				echo "<li><div style='float:left;'> <p style='padding:10;'>Нет новых заявок </p></div></li></ul></div>";
				} else {
                                while ($row = mysqli_fetch_assoc($result)){
                                echo "<li>";
                                echo "<div style ='float:left;'><p style='padding:10;'>".$row['source']."</p></div>";
                                echo "<div style ='float:left;'><form method='POST' action ='index.php'> <button class='btn btn-outline-secondary' style='margin:5;' type = 'submit' name='accept' value=".$row["source"].">Принять</button> </form></div>";
                                echo "<div style ='float:left;'><form method='POST' action ='index.php'> <button class='btn btn-outline-secondary' style='margin:5;' type = 'submit' name='reject' value=".$row["source"].">Отклонить</button> </form></div>";
                                echo "</li></ul></div>";
                                
                            }
			    }
                        ?>                        
                    <button onclick="window.location.href='msg.php'" class='btn btn-outline-secondary' style ="float:right;">Сообщения</button>
            </div>
                    
		    </div>
                </div>
            </div>
            
            <?php
                $email = $_SESSION['email'];
                $sql = "select email,firstname, lastname,reg_date,status from users where NOT '$email' = email";
                $result = mysqli_query($conn,$sql);
                if (mysqli_num_rows($result)==0){
                    echo "<div class='container-fluid shadow-lg p-3 mb-5 bg-body rounded' ><p class='alert alert-dark' role='alert'>На сервере нет других пользователей !</p></div>";}
                else{
                    echo "<table class='table shadow-lg p-3 mb-5 bg-body rounded  table-dark table-striped'>";
                    echo "<tr><td> Имя </td> <td>Почта</td> <td>Статус</td><td>Дружба</td></tr>";
                    while ($row = mysqli_fetch_assoc($result)){
                        echo "<tr><td>".$row["firstname"]." ".$row['lastname']."</td><td>".$row["email"]."</td><td>".$row['status']."</td><td>";
                        echo "<form method='POST' action ='index.php' ><button id=".$row['email']." class='btn btn-outline-secondary' type = 'submit' name='addfriend' value=".$row["email"].">Добавить в друзьяы</button></form>";
                    }
                    echo "</table>";
                }
            ?>
            <h2> Список друзей</h2>
            <?php
                $email = $_SESSION['email'];
                $sql = "select email, firstname, lastname from users inner join (select target as friend from friend_int where source = '$email' union select source as friend from friend_int where target = '$email') as friends on users.email=friends.friend;";
                $result = mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>0){
                    echo "<div class = 'row shadow-lg p-3 mb-5 bg-body rounded'>";
                    while ($row=mysqli_fetch_assoc($result)){
                        echo "<div  class ='col-4 shadow-lg p-3 mb-5 bg-body rounded' style ='float:left;'><p >".ucfirst($row['firstname'])." ".ucfirst($row['lastname'])."</p></div>";
                        echo "<div class ='col shadow-lg p-3 mb-5 bg-body rounded' style ='float:left;'><form method='POST' action ='index.php'> <button class='btn btn-outline-secondary' type = 'submit' name='delete' value=".$row['email'].">Удалить</button> </form></td>";
                        echo "<form method='POST' action ='index.php'> <button  class='btn btn-outline-secondary' type = 'submit' name='friendemail' value=".$row['email'].">Написать</button> <input type='text' name='friendname' style='display:none;' value=".$row['firstname']."></input></form></td></tr></div>";
                        echo "<script type = \"text/javascript\"> isfriend(\"".$row['email']."\");</script>";
                        
                    }
                    echo "</div>";
                    } else {
                        echo "<div class='shadow-lg p-3 mb-5 bg-body rounded'><p class='alert alert-dark' >В вашем списке нет друзей!</p></div>";
                    }
            ?>
            <?php
                //Обновление заявок
                            $email = $_SESSION['email'];
                            $sql="select source from friend_requests where target = '$email';";
                            $result = mysqli_query($conn,$sql);
                                while ($row = mysqli_fetch_assoc($result)){
                                echo "<script type = \"text/javascript\"> isfriendd(\"".$row['source']."\");</script>";
                                                                
                            }
                            ?>
            
            <br>
        </body>
    </html>
