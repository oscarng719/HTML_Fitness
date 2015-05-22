<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" type="text/css" href="loginStyle.css">
	</head>
	<?php
		session_start(); //for the global variable
	?>
	<body>
		<?php
		$username = "";
		$password = "";
		$result = "";
		$stop = false;
		$connection = new mysqli("localhost", "zachohearn", "orange", "zachohearn");
		
		if($connection->connect_error) {
			die("<h2>Unable to connect to database $conection->connect_error</h2>");
		}
		
		if (isset($_POST["submit"])) {
			$username = $_POST["username"];
			$password = $_POST["password"];
			$username = htmlentities($username);
			$password = htmlentities($password);
			$username = $connection->real_escape_string($username);
			$password = $connection->real_escape_string($password);
			$users = $connection->query("SELECT * FROM users");
			if (!$users) {
				$result = "Error Accessing Database";
				echo "Error Accessing Database";
			}
			
			$result = "Invalid username or password";
			
			while ($user = $users->fetch_assoc()) {
				if (($username == $user['username']) && ($password == $user['password'])) {
				
					if ($user['isTrainee'] == 1) {
						header('Location: traineeMain.php');
						$stop = true;
					} else {
						header('Location: trainerMain.php');
						$stop = true;
					}
					 //global variable store the user ID
					$_SESSION['id'] = $user['userId'];
				}
			}
			
		}
		
		?>
		<form action="login.php" method="post">
			<div class="banner">
			<img src="sitUp.jpg" alt="People doing situps">
			<h1>Welcome to <span>Fitness</span></h1>
			</div>
			<div class="login">
			<div><label for="username">Username: </label><input type="text" name="username" id="username" value="<?php echo $username ?>" /></label></div>
			<div><label for="password">Password: </label><input type="password" name="password" id="username" /></div>
			<div><input class = "login" type="submit" name="submit" value="Log In"/></div>
			<span class="error"><p><?php echo $result ?></p></span>
			</div>
		</form>
	</body>
</html>