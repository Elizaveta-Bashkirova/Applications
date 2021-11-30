<?php
ob_start();// функция, чтобы работала переадресация
		
// Соединямся с БД
//Устанавливаем доступы к базе данных:
include "connection.php";

if(isset($_POST['register_enter']))
{
    $err = [];

    // проверям login
    if(!preg_match("/^[\w\d\.]+\@[a-zA-Z\.]+\.[A-Za-z]{1,4}$/",$_POST['register_login']))
    {
        $err[] = "login может состоять только из букв английского алфавита и цифр";
    }

    if(strlen($_POST['register_login']) < 3 or strlen($_POST['register_login']) > 30)
    {
        $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
    }

    // проверяем, не сущестует ли пользователя с таким login
    $query = mysqli_query($connection, "SELECT id_user FROM user WHERE login='".mysqli_real_escape_string($connection, $_POST['register_login'])."'");
    if(mysqli_num_rows($query) > 0)
    {
        $err[] = "Пользователь с таким логином уже существует в базе данных";
    }

    // Если нет ошибок, то добавляем в БД нового пользователя
    if(count($err) == 0)
    {
		$nikName=$_POST['register_name'];
		$login=$_POST['register_login'];
		
        // Убераем лишние пробелы и делаем двойное хеширование
        $password = md5(md5(trim($_POST['register_password'])));

        mysqli_query($connection,"INSERT INTO `user` (`id_user`, `login`, `password`, `nikName`, `role`) 
		VALUES (NULL, '".$login."', '".$password."', '".$nikName."', 'user');")
	or die( mysqli_error($connection) );
        header('Location: ../index.php'); exit();
    }
    else
    {
			
        print "<b>При регистрации произошли следующие ошибки:</b><br>";
        foreach($err AS $error)
        {
            print $error."<br>";
        }
		echo <<<HTML

		<a href="../" style=""> назад </a>
			<style>
			a {
				color: red;
			}
		</style>

HTML;
    }
}
	ob_end_flush();
?>

