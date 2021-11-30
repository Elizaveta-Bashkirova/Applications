<!DOCTYPE html>
  <head>
    <title>Админ</title>
	<link rel="stylesheet" href="css/admin.css?<?echo time();?>">
  </head>
  <body>
  <div class="container">
	  <h1>Страница Админа</h1>
		<form action="adminPage.php" method="post" >
		<fieldset>
			<br>
			Выберите таблицу для отображения:<br>
			<select class="select" name="tableValue">
			<option disabled>Выбрать</option>
				<option value="user">user</option>
				<option value="product">product</option>
				<option value="size">size</option>
				<option value="category">category</option>
				<option value="color">color	</option>
				<option value="order_product">order_product</option>
				<option value="order_user">order_user</option>
			</select>	
		
		    <input type=submit name="showTable" value="Отобразить">
		    <br><br><br>
			Выберите таблицу для поиска: <br>
			<select class="select" name="tableSearch">
			<option disabled>Выбрать</option>
				<option value="user">user</option>
				<option value="product">product</option>
				<option value="size">size</option>
				<option value="category">category</option>
				<option value="color">color	</option>
				<option value="order_product">order_product</option>
				<option value="order_user">order_user</option>
			</select>
			<input type=submit name="tableSubmit" value="Выбрать">
			
			<?php
			if(isset($_POST['tableSubmit'])){
				include "php/connection.php";
				$tableValue = $_POST["tableSearch"];
				session_start();
				$_SESSION['table'] = $tableValue;
				$queryColoum = "SHOW COLUMNS FROM ".$tableValue.";";
				$resultColoum = mysqli_query($connection, $queryColoum) or die("Ошибка " . mysqli_error($connection));
				if($resultColoum){	
				echo "Выберите поле для поиска: <br>";
			
					echo"<select name='searchColoum'>";
					while ($rowColoum = mysqli_fetch_row($resultColoum)) {
						echo "<option value=".$rowColoum[0].">".$rowColoum[0]."</option>";
					}
					echo"</select>";
					echo"<input type=text name='valueSearch'>";
					echo"<input type=submit name='coloumSubmitSearch' value='Искать'> <br>";
				}
			}
			?>
			<br><br><br>
			Выберите таблицу для сортировки: <br>
			<select class="select" name="tableSort">
			<option disabled>Выбрать</option>
				<option value="user">user</option>
				<option value="product">product</option>
				<option value="size">size</option>
				<option value="category">category</option>
				<option value="color">color	</option>
				<option value="order_product">order_product</option>
				<option value="order_user">order_user</option>
			</select>
			<input type=submit name="tableSubmitSort" value="Выбрать">
			
			<?php
			if(isset($_POST['tableSubmitSort'])){
				include "php/connection.php";
				$tableValue = $_POST["tableSort"];
				session_start();
				$_SESSION['tableSortSession'] = $tableValue;
				$queryColoum = "SHOW COLUMNS FROM ".$tableValue.";";
				$resultColoum = mysqli_query($connection, $queryColoum) or die("Ошибка " . mysqli_error($connection));
				if($resultColoum){
				echo "Выберите поле для сортировки: <br>";
			
					echo"<select name='ColoumSort'>";
					while ($rowColoum = mysqli_fetch_row($resultColoum)) {
						echo "<option value=".$rowColoum[0].">".$rowColoum[0]."</option>";
					}
					echo"</select>";
					echo"<input type=submit name='coloumSubmitSort' value='сортировать'> <br>";
				}
			}
			?>
			<br><br><br>
			Выберите таблицу для удаления данных: <br>
			<select class="select" name="tableDelete">
				<option value="user">user</option>
				<option disabled>Выбрать</option>
				<option value="product">product</option>
				<option value="size">size</option>
				<option value="category">category</option>
				<option value="color">color	</option>
				<option value="order_product">order_product</option>
				<option value="order_user">order_user</option>
			</select>
			<input type=submit name="tableSubmitDelete" value="Выбрать">
			<?php
			if(isset($_POST['tableSubmitDelete'])){
				include "php/connection.php";
				$tableValue = $_POST["tableDelete"];
				session_start();
				$_SESSION['tableDeleteSession'] = $tableValue;
				$queryColoum = "SHOW COLUMNS FROM ".$tableValue.";";
				$resultColoum = mysqli_query($connection, $queryColoum) or die("Ошибка " . mysqli_error($connection));
				if($resultColoum){
				echo "<br>";
				echo "Выберите поле для удаления: <br>";
				
					echo"<select name='ColoumDelete'>";
					while ($rowColoum = mysqli_fetch_row($resultColoum)) {
						echo "<option value=".$rowColoum[0].">".$rowColoum[0]."</option>";
					}
					echo"</select>";
					echo"<input type=text name='valueDelete'>";
					echo"<input type=submit name='coloumSubmitDelete' value='удалить'> <br>";
				}
			}
			?>
			
			
			<br><br><br>
			Выберите таблицу для изменения данных: <br>
			<select class="select" name="tableUpdate">
			<option disabled>Выбрать</option>
				<option value="user">user</option>
				<option value="product">product</option>
				<option value="size">size</option>
				<option value="category">category</option>
				<option value="color">color	</option>
				<option value="order_product">order_product</option>
				<option value="order_user">order_user</option>
			</select>
			<input type=submit name="tableSubmitUpdate" value="Выбрать">
			<?php
			if(isset($_POST['tableSubmitUpdate'])){
				include "php/connection.php";
				$tableValue = $_POST["tableUpdate"];
				session_start();
				$_SESSION['tableUpdateSession'] = $tableValue;
				$queryColoum = "SHOW COLUMNS FROM ".$tableValue.";";
				$resultColoum = mysqli_query($connection, $queryColoum) or die("Ошибка " . mysqli_error($connection));
				if($resultColoum){
				echo "<br>";
				echo "Выберите id для изменения: <br>";
				echo"<input type=text name='valueUpdateId'>";
				echo "Выберите поле для изменения: <br>";
				
					echo"<select name='ColoumUpdate'>";
					while ($rowColoum = mysqli_fetch_row($resultColoum)) {
						echo "<option value=".$rowColoum[0].">".$rowColoum[0]."</option>";
					}
					echo"</select>";
					echo"<input type=text name='valueUpdate'>";
					echo"<input type=submit name='coloumSubmitUpdate' value='изменить'> <br>";
				}
			}
			?>
			
				<br><br><br>
			Выберите таблицу для добавления данных: <br>
			<select class="select" name="tableAdd">
			<option disabled>Выбрать</option>
				<option value="product">product</option>
				<option value="size">size</option>
				<option value="category">category</option>
				<option value="color">color	</option>
				<option value="order_product">order_product</option>
				<option value="order_user">order_user</option>
			</select>
			<input type=submit name="tableSubmitAdd" value="Выбрать">
			<?php
			if(isset($_POST['tableSubmitAdd'])){
				include "php/connection.php";
				$tableValue = $_POST["tableAdd"];
				session_start();
				$_SESSION['tableAddSession'] = $tableValue;
				if($tableValue=="product"){			
					echo "<p><label>ID category</label><input name='id_category' type='text'></p>";
					echo "<p><label>Price </label><input name='price' type='text'></p>";
					echo "<p><label>link to picture </label><input name='link_To_Picture' type='text'></p>";
					echo "<p><label>ID color </label><input name='id_color' type='text'></p>";
					echo "<p><label>Count product</label><input name='count_product' type='text'></p>";
					echo "<p><label>ID size </label><input name='id_size' type='text'></p>";
					echo "<p><button type='reset'>Сброс</button>";
					echo "<button type='submit' name='addProduct'>Добавить</button></p>";
				}
				if($tableValue=="size"){			
					echo "<p><label>Name size</label><input name='name_size' type='text'></p>";
					echo "<p><button type='reset'>Сброс</button>";
					echo "<button type='submit' name='addSize'>Добавить</button></p>";
				}
				if($tableValue=="category"){			
					echo "<p><label>Name category</label><input name='name_category' type='text'></p>";
					echo "<p><button type='reset'>Сброс</button>";
					echo "<button type='submit' name='addCategory'>Добавить</button></p>";
				}
				if($tableValue=="color"){			
					echo "<p><label>Name color</label><input name='name_color' type='text'></p>";
					echo "<p><button type='reset'>Сброс</button>";
					echo "<button type='submit' name='addColor'>Добавить</button></p>";
				}
					if($tableValue=="order_product"){			
					echo "<p><label>id_order</label><input name='id_order' type='text'></p>";
					echo "<p><label>id_product</label><input name='id_product' type='text'></p>";
					echo "<p><button type='reset'>Сброс</button>";
					echo "<button type='submit' name='addOrder_product'>Добавить</button></p>";
				}
				if($tableValue=="order_user"){			
					echo "<p><label>id_user</label><input name='id_user' type='text'></p>";
					echo "<p><label>sum_price</label><input name='sum_price' type='text'></p>";
					echo "<p><button type='reset'>Сброс</button>";
					echo "<button type='submit' name='addOrder_user'>Добавить</button></p>";
				}
			}
			?>
			
		</fieldset>
		</form>
	</div>
	
	<?php
	
		if(isset($_POST['showTable'])){
			include "php/connection.php";
			$tableValue = $_POST["tableValue"];
			if($tableValue == "product"){
				$query = "select p.id_product".
						", c.name_category".
						", p.price".
						", p.link_to_picture".
						", col.name_color".
						", p.count_product".
						", s.name_size".
						" from product as p".
						" left join".
						" category as c".
						" on p.id_category = c.id_category".
						" left join".
						" color as col".
						" on p.id_color = col.id_color".
						" left join".
						" size as s".
						" on p.id_size = s.id_size;";
			}
			else{
			$query = "select * from ".$tableValue.";"; // составляем запрос
			}
			$queryColoum = "SHOW COLUMNS FROM ".$tableValue.";";
			$result = mysqli_query($connection, $query) or die("Ошибка " . mysqli_error($connection)); // выполняем запрос
			$resultColoum = mysqli_query($connection, $queryColoum) or die("Ошибка " . mysqli_error($connection)); // выполняем запрос
			if($result){
				echo "<table>";
				echo "<tr>";
				while ($rowColoum = mysqli_fetch_row($resultColoum)){
					echo "<th>".$rowColoum[0]."</th>";
				}
				echo "</tr>";
				while ($row = mysqli_fetch_row($result)) {
					echo "<tr>";
					for ($i = 0; $i < count($row); $i++) {
					echo "<td>".$row[$i]."</td>";
					}
					echo "</tr>";
				}
				echo "</table>";
			}
		}
		
		if(isset($_POST['coloumSubmitSearch'])){
			session_start();
			$coloum = $_POST["searchColoum"];
			$value = $_POST["valueSearch"];
			include "php/connection.php";
			$query = "select * from ".$_SESSION['table']." where ".$coloum." like '%".$value."%'"; // составляем запрос
			$queryColoum = "SHOW COLUMNS FROM ".$_SESSION['table'].";";
			$result = mysqli_query($connection, $query) or die("Ошибка " . mysqli_error($connection)); // выполняем запрос
			$resultColoum = mysqli_query($connection, $queryColoum) or die("Ошибка " . mysqli_error($connection)); // выполняем запрос
			if($result){
				echo "<table>";
				echo "<tr>";
				while ($rowColoum = mysqli_fetch_row($resultColoum)){
					echo "<th>".$rowColoum[0]."</th>";
				}
				echo "</tr>";
				while ($row = mysqli_fetch_row($result)) {
					echo "<tr>";
					for ($i = 0; $i < count($row); $i++) {
					echo "<td>".$row[$i]."</td>";
					}
					echo "</tr>";
				}
				echo "</table>";
			}
		}
		
		if(isset($_POST['coloumSubmitSort'])){
			session_start();
			$coloum = $_POST["ColoumSort"];
			include "php/connection.php";
			$query = "select * from ".$_SESSION['tableSortSession']." order by ".$coloum.";"; // составляем запрос
			$queryColoum = "SHOW COLUMNS FROM ".$_SESSION['tableSortSession'].";";
			$result = mysqli_query($connection, $query) or die("Ошибка " . mysqli_error($connection)); // выполняем запрос
			$resultColoum = mysqli_query($connection, $queryColoum) or die("Ошибка " . mysqli_error($connection)); // выполняем запрос
			if($result){
				echo "<table>";
				echo "<tr>";
				while ($rowColoum = mysqli_fetch_row($resultColoum)){
					echo "<th>".$rowColoum[0]."</th>";
				}
				echo "</tr>";
				while ($row = mysqli_fetch_row($result)) {
					echo "<tr>";
					for ($i = 0; $i < count($row); $i++) {
					echo "<td>".$row[$i]."</td>";
					}
					echo "</tr>";
				}
				echo "</table>";
			}
		}
		
		
		if(isset($_POST['coloumSubmitDelete'])){
			session_start();
			$coloum = $_POST["ColoumDelete"];
			$value = $_POST["valueDelete"];
			include "php/connection.php";
			$queryDelete = "DELETE FROM ".$_SESSION['tableDeleteSession']." WHERE ".$coloum." = '".$value."';"; // составляем запрос
			echo($queryDelete); 
			$resultDelete = mysqli_query($connection, $queryDelete) or die("Ошибка " . mysqli_error($connection)); // выполняем запрос
			
			$queryColoum = "SHOW COLUMNS FROM ".$_SESSION['tableDeleteSession'].";";
			$resultColoum = mysqli_query($connection, $queryColoum) or die("Ошибка " . mysqli_error($connection)); // выполняем запрос
			
			$query = "select * from ".$_SESSION['tableDeleteSession'].";";			
			$result = mysqli_query($connection, $query) or die("Ошибка " . mysqli_error($connection)); // выполняем запрос
			
			if($result){
				echo "<table>";
				echo "<tr>";
				while ($rowColoum = mysqli_fetch_row($resultColoum)){
					echo "<th>".$rowColoum[0]."</th>";
				}
				echo "</tr>";
				while ($row = mysqli_fetch_row($result)) {
					echo "<tr>";
					for ($i = 0; $i < count($row); $i++) {
					echo "<td>".$row[$i]."</td>";
					}
					echo "</tr>";
				}
				echo "</table>";
			}
		}
		
		
		if(isset($_POST['coloumSubmitUpdate'])){
			session_start();
			$coloum = $_POST["ColoumUpdate"];
			$value = $_POST["valueUpdate"];
			$id = $_POST["valueUpdateId"];
			include "php/connection.php";
			
			$queryColoum = "SHOW COLUMNS FROM ".$_SESSION['tableUpdateSession'].";";
			$resultColoumm = mysqli_query($connection, $queryColoum) or die("Ошибка " . mysqli_error($connection)); // выполняем запрос
			$idColoum=mysqli_fetch_row($resultColoumm);
			
			
			$queryUpdate = "UPDATE ".$_SESSION['tableUpdateSession']." SET ".$coloum." = '".$value."' WHERE (".$idColoum[0]." = ".$id.");";
			$resultUpdate = mysqli_query($connection, $queryUpdate) or die("Ошибка " . mysqli_error($connection)); // выполняем запрос
			
			$query = "select * from ".$_SESSION['tableUpdateSession'].";";
			$result = mysqli_query($connection, $query) or die("Ошибка " . mysqli_error($connection)); // выполняем запрос
			
			
			$queryColoum = "SHOW COLUMNS FROM ".$_SESSION['tableUpdateSession'].";";
			$resultColoum = mysqli_query($connection, $queryColoum) or die("Ошибка " . mysqli_error($connection)); // выполняем запрос
			if($result){
				echo "<table>";
				echo "<tr>";
				while ($rowColoum = mysqli_fetch_row($resultColoum)){
					echo "<th>".$rowColoum[0]."</th>";
				}
				echo "</tr>";
				while ($row = mysqli_fetch_row($result)) {
					echo "<tr>";
					for ($i = 0; $i < count($row); $i++) {
					echo "<td>".$row[$i]."</td>";
					}
					echo "</tr>";
				}
				echo "</table>";
			}
		}	
		
			if(isset($_POST['addProduct'])){
			
			$id_category = $_POST["id_category"];
			$price = $_POST["price"];
			$link_To_Picture = $_POST["link_To_Picture"];
			$id_color = $_POST["id_color"];
			$count_product = $_POST["count_product"];
			$id_size = $_POST["id_size"];
			
			if (!$id_category || !$price || !$link_To_Picture || !$id_color || !$count_product || !$id_size ){
				echo "Вы ввели не все данные. Вернитесь назад и попробуйте еще раз";
				exit();
			}
			
			include "php/connection.php";

			$queryAdd = "INSERT INTO product (`id_product`, `id_category`, `price`, `link_to_picture`, `id_color`, `count_product`, `id_size`) 
					  VALUES (NULL, '".$id_category."', '".$price."', '".$link_To_Picture."', '".$id_color."', '".$count_product."', '".$id_size."');";
			$result = mysqli_query($connection, $queryAdd) or die("Ошибка " . mysqli_error($connection));
			echo($queryAdd);
			$query = "select p.id_product".
						", c.name_category".
						", p.price".
						", p.link_to_picture".
						", col.name_color".
						", p.count_product".
						", s.name_size".
						" from product as p".
						" left join".
						" category as c".
						" on p.id_category = c.id_category".
						" left join".
						" color as col".
						" on p.id_color = col.id_color".
						" left join".
						" size as s".
						" on p.id_size = s.id_size;";
			$result = mysqli_query($connection, $query) or die("Ошибка " . mysqli_error($connection)); // выполняем запрос
			
			$queryColoum = "SHOW COLUMNS FROM product;";
			$resultColoum = mysqli_query($connection, $queryColoum) or die("Ошибка " . mysqli_error($connection)); // выполняем запрос
			if($result){
				echo "<table>";
				echo "<tr>";
				while ($rowColoum = mysqli_fetch_row($resultColoum)){
					echo "<th>".$rowColoum[0]."</th>";
				}
				echo "</tr>";
				while ($row = mysqli_fetch_row($result)) {
					echo "<tr>";
					for ($i = 0; $i < count($row); $i++) {
					echo "<td>".$row[$i]."</td>";
					}
					echo "</tr>";
				}
				echo "</table>";
			}
		}
		
		
		if(isset($_POST['addSize'])){
			$name_size = $_POST["name_size"];
			if (!$name_size ){
				echo "Вы ввели не все данные. Вернитесь назад и попробуйте еще раз";
				exit();
			}
			include "php/connection.php";
			$queryAdd = "INSERT INTO size (`id_size`, `name_size`) 
					  VALUES (NULL, '".$name_size."');";
			$result = mysqli_query($connection, $queryAdd) or die("Ошибка " . mysqli_error($connection));
			echo($queryAdd);
			$query = "select * from size;";
			$result = mysqli_query($connection, $query) or die("Ошибка " . mysqli_error($connection)); // выполняем запрос
			
			$queryColoum = "SHOW COLUMNS FROM size;";
			$resultColoum = mysqli_query($connection, $queryColoum) or die("Ошибка " . mysqli_error($connection)); // выполняем запрос
			if($result){
				echo "<table>";
				echo "<tr>";
				while ($rowColoum = mysqli_fetch_row($resultColoum)){
					echo "<th>".$rowColoum[0]."</th>";
				}
				echo "</tr>";
				while ($row = mysqli_fetch_row($result)) {
					echo "<tr>";
					for ($i = 0; $i < count($row); $i++) {
					echo "<td>".$row[$i]."</td>";
					}
					echo "</tr>";
				}
				echo "</table>";
			}
		}
		
		if(isset($_POST['addCategory'])){
			$name_category = $_POST["name_category"];
			if (!$name_category ){
				echo "Вы ввели не все данные. Вернитесь назад и попробуйте еще раз";
				exit();
			}
			include "php/connection.php";
			$queryAdd = "INSERT INTO category (`id_category`, `name_category`) 
					  VALUES (NULL, '".$name_category."');";
			$result = mysqli_query($connection, $queryAdd) or die("Ошибка " . mysqli_error($connection));
			echo($queryAdd);
			$query = "select * from category;";
			$result = mysqli_query($connection, $query) or die("Ошибка " . mysqli_error($connection)); // выполняем запрос
			
			$queryColoum = "SHOW COLUMNS FROM category;";
			$resultColoum = mysqli_query($connection, $queryColoum) or die("Ошибка " . mysqli_error($connection)); // выполняем запрос
			if($result){
				echo "<table>";
				echo "<tr>";
				while ($rowColoum = mysqli_fetch_row($resultColoum)){
					echo "<th>".$rowColoum[0]."</th>";
				}
				echo "</tr>";
				while ($row = mysqli_fetch_row($result)) {
					echo "<tr>";
					for ($i = 0; $i < count($row); $i++) {
					echo "<td>".$row[$i]."</td>";
					}
					echo "</tr>";
				}
				echo "</table>";
			}
		}
		
			if(isset($_POST['addColor'])){
			$name_color = $_POST["name_color"];
			if (!$name_color ){
				echo "Вы ввели не все данные. Вернитесь назад и попробуйте еще раз";
				exit();
			}
			include "php/connection.php";
			$queryAdd = "INSERT INTO color (`id_color`, `name_color`) 
					  VALUES (NULL, '".$name_color."');";
			$result = mysqli_query($connection, $queryAdd) or die("Ошибка " . mysqli_error($connection));
			echo($queryAdd);
			$query = "select * from color;";
			$result = mysqli_query($connection, $query) or die("Ошибка " . mysqli_error($connection)); // выполняем запрос
			
			$queryColoum = "SHOW COLUMNS FROM color;";
			$resultColoum = mysqli_query($connection, $queryColoum) or die("Ошибка " . mysqli_error($connection)); // выполняем запрос
			if($result){
				echo "<table>";
				echo "<tr>";
				while ($rowColoum = mysqli_fetch_row($resultColoum)){
					echo "<th>".$rowColoum[0]."</th>";
				}
				echo "</tr>";
				while ($row = mysqli_fetch_row($result)) {
					echo "<tr>";
					for ($i = 0; $i < count($row); $i++) {
					echo "<td>".$row[$i]."</td>";
					}
					echo "</tr>";
				}
				echo "</table>";
			}
		}

		if(isset($_POST['addOrder_product'])){
			$id_order = $_POST["id_order"];
			$id_product = $_POST["id_product"];
			if (!$id_order || !$id_product){
				echo "Вы ввели не все данные. Вернитесь назад и попробуйте еще раз";
				exit();
			}
			include "php/connection.php";
			$queryAdd = "INSERT INTO order_product (`id_order`, `id_product`) 
					  VALUES ('".$id_order."', '".$id_product."');";
			$result = mysqli_query($connection, $queryAdd) or die("Ошибка " . mysqli_error($connection));
			echo($queryAdd);
			$query = "select * from order_product;";
			$result = mysqli_query($connection, $query) or die("Ошибка " . mysqli_error($connection)); // выполняем запрос
			
			$queryColoum = "SHOW COLUMNS FROM order_product;";
			$resultColoum = mysqli_query($connection, $queryColoum) or die("Ошибка " . mysqli_error($connection)); // выполняем запрос
			if($result){
				echo "<table>";
				echo "<tr>";
				while ($rowColoum = mysqli_fetch_row($resultColoum)){
					echo "<th>".$rowColoum[0]."</th>";
				}
				echo "</tr>";
				while ($row = mysqli_fetch_row($result)) {
					echo "<tr>";
					for ($i = 0; $i < count($row); $i++) {
					echo "<td>".$row[$i]."</td>";
					}
					echo "</tr>";
				}
				echo "</table>";
			}
		}


		if(isset($_POST['addOrder_user'])){
			$id_user = $_POST["id_user"];
			$date_order = date("Y-m-d");
			$sum_price = $_POST["sum_price"];
			if (!$id_user || !$date_order || !$sum_price){
				echo "Вы ввели не все данные. Вернитесь назад и попробуйте еще раз";
				exit();
			}
			include "php/connection.php";
				$queryAdd = "INSERT INTO order_user (id_order, id_user, date_order, sum_price) 
						VALUES (NULL, '".$id_user."', '".$date_order."', ".$sum_price.");";
						echo($queryAdd);
			$result = mysqli_query($connection, $queryAdd) or die("Ошибка " . mysqli_error($connection));
			
			$query = "select * from order_user;";
			$result = mysqli_query($connection, $query) or die("Ошибка " . mysqli_error($connection)); // выполняем запрос
			
			$queryColoum = "SHOW COLUMNS FROM order_user;";
			$resultColoum = mysqli_query($connection, $queryColoum) or die("Ошибка " . mysqli_error($connection)); // выполняем запрос
			if($result){
				echo "<table>";
				echo "<tr>";
				while ($rowColoum = mysqli_fetch_row($resultColoum)){
					echo "<th>".$rowColoum[0]."</th>";
				}
				echo "</tr>";
				while ($row = mysqli_fetch_row($result)) {
					echo "<tr>";
					for ($i = 0; $i < count($row); $i++) {
					echo "<td>".$row[$i]."</td>";
					}
					echo "</tr>";
				}
				echo "</table>";
			}
		}
		
		
	?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="js/admin.js"></script>
	</body>
	</html>