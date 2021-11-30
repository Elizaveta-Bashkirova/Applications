<?php
  session_start();
 ob_start();// функция, чтобы работала переадресация

$login=$_POST['login'];
$password=$_POST['password'];	
	// Функция для генерации случайной строки
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}

// Соединямся с БД
//Устанавливаем доступы к базе данных:
	include "connection.php";

if(isset($_POST['enter']))
{
    // Вытаскиваем из БД запись, у которой логин равняеться введенному
    $query = mysqli_query($connection,"SELECT id_user, password, role FROM user WHERE login='".mysqli_real_escape_string($connection,$_POST['login'])."' LIMIT 1");
	$data = mysqli_fetch_assoc($query);
	//проверка на существование login в базе данных
	if($data === null){
		 print "Вы ввели неправильный логин/пароль";
	}
	else{
		// Сравниваем пароли
		if($data['password'] === md5(md5($_POST['password'])))
		{
			$querySession = mysqli_query($connection,"SELECT nikName FROM user WHERE login='".mysqli_real_escape_string($connection,$_POST['login'])."' LIMIT 1");
			$name = mysqli_fetch_assoc($querySession);
			$_SESSION['name'] = $name['name'] ;
			if($data['role'] == 'user'){  
				$_SESSION['id_user']=$data['id_user'];

			header('Location: ../HomePage.php'); exit();
			}
			else if($data['role'] == 'admin'){
				header('Location: ../AdminPage.php'); exit();
			}
		}
		else
		{
			print "Вы ввели неправильный логин/пароль";
		}
	}
}
?>
