<?php
		$bdhost="localhost"; // хост
		$bduser="root"; // Имя пользователя 
		$bdpassword="dflbv181818"; // Пароль
		$bddatabase="onlinestore"; // Имя БД
		// создаём подключение и подключемся к БД или выводим ошибку
		$connection = new mysqli($bdhost, $bduser, $bdpassword, $bddatabase) or die("Ошибка:  ".mysqli_error($connection));
		// устанавливаем кодировку
		$connection->set_charset("utf8");
		
	?>