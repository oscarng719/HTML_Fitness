<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>fitness Trainee Page</title>
		<link rel="stylesheet" type="text/css" href="traineeStyle.css">
	</head>
	<?php
		session_start(); //for the global variable
	?>
	<body>		
		<?php //all variables
			$emailTo = "";
			$emailToName = "";
			$emailFrom = "";
			$emailFromName = "";
			$emailSubject = "";
			$emailBody = "";
			
			$connection = new mysqli("localhost", "zachohearn", "orange", "zachohearn");
		
			if($connection->connect_error) {
				die("<h2>Unable to connect to database $conection->connect_error</h2>");
			}
			
			$users = $connection->query("SELECT * FROM `users` WHERE userID =".$_SESSION['id']);
			while ($user = $users->fetch_assoc()) 
			{
				$username = $user['username'];
			}
		?>
		
		<div class="banner">
		<img src="sitUp.jpg" alt="People doing situps">
		<h1>Welcome to <span>Fitness</span></h1>
		</div>
		
		<form action="traineeMain.php" method="post">
			<div>
				<input class="nav" type="submit" name="Profile" value="Profile"/>
				<input class="nav" type="submit" name="Workouts" value="Workouts"/>
				<input class="nav" type="submit" name="Messages" value="Messages"/>
				<input class="nav" type="submit" name="Logout" value="Log Out"/>
			</div>
		</form>
		
		<?php
//Logout Section		
			if(isset($_POST["Logout"]))
			{
				unset($_SESSION['id']);
				unset($_SESSION['traineeEmail']);
				header('Location: login.php');
			}
//Profile Section			
			if((isset($_POST["Profile"])) || (!isset($_POST["Workouts"]) && !isset($_POST["Messages"]) && !isset($_POST["pastWorkouts"]) && !isset($_POST["workoutComplete"]) && !isset($_POST["editProfile"])) && !isset($_POST["update_username"]) && !isset($_POST["update_name"]) && !isset($_POST["update_password"]) && !isset($_POST["update_email"])) {
				$users = $connection->query("SELECT * FROM users");
				$user = $_SESSION['id'];
				
				$result = $connection->query("SELECT username, firstname, lastname, mtdCalories, TrainerName FROM users WHERE userId = '$user'");
				
				
				
				while($rows = mysqli_fetch_array($result)):
					
				$user_name = $rows['username'];
				$first_name = $rows['firstname'];
				$last_name = $rows['lastname'];
				$cal_name = $rows['mtdCalories'];
				$trainer_name = $rows['TrainerName'];
				$trainerName = $connection->query("SELECT firstname, lastname FROM users WHERE username = '$trainer_name'");
				$fullName = $trainerName->fetch_assoc();
				$trainer_name = $fullName['firstname'] . " " . $fullName['lastname'];
				endwhile;
				
				?>
				<form action="traineeMain.php" method="post">
					<div class="subset">
						<h2>Profile</h2>
						<p>Name: <?php echo $first_name . " " . $last_name;?></p>
						<p>You Have Burned <?php echo $cal_name . " calories"; ?></p>
						<p>Trainer Assigned: <?php echo $trainer_name; ?></p>
						<input class="profile" type="submit" name="editProfile" value="Edit Profile" />
					</div>
				</form>
				<?php
			}
//Editting Profile
			if (isset($_POST["editProfile"]) || isset($_POST["update_username"]) || isset($_POST["update_name"]) || isset($_POST["update_password"]) || isset($_POST["update_email"])) {
				$result = "";
				$users = $connection->query("SELECT * FROM users");
				$user = $_SESSION['id'];
			
				if(isset($_POST["update_username"]))
					{
						if (!empty($_POST['usernameUP'])){
						$usernameUP = $_POST['usernameUP'];
						$usernameUP = $connection->real_escape_string(htmlentities($usernameUP));
						$connection->query("UPDATE users SET username = '$usernameUP' WHERE userId = '$user'");
						$result = "Username updated";
						}
					}
				if(isset($_POST["update_name"]))
					{
						if (!empty($_POST['firstnameUP']) && !empty($_POST['lastnameUP'])){
						$firstnameUP = $_POST['firstnameUP'];
						$lastnameUP = $_POST['lastnameUP'];
						$lastnameUP = $connection->real_escape_string(htmlentities($lastnameUP));
						$firstnameUP = $connection->real_escape_string(htmlentities($firstnameUP));
						$connection->query("UPDATE users SET firstname = '$firstnameUP', lastname = '$lastnameUP' WHERE userId = '$user'");
						$result = "Name updated";
						}
					}
				if(isset($_POST["update_password"]))
					{
						if (!empty($_POST['passwordUP'])){
						$passwordUP = $_POST['passwordUP'];
						$passwordUP = $connection->real_escape_string(htmlentities($passwordUP));
						$connection->query("UPDATE users SET password = '$passwordUP' WHERE userId = '$user'");
						$result = "Password updated";
						}
					}
				if(isset($_POST["update_email"]))
					{
						if (!empty($_POST['emailUP'])){
						$emailUP = $_POST['emailUP'];
						$emailUP = $connection->real_escape_string(htmlentities($emailUP));
						$connection->query("UPDATE users SET email = '$emailUP' WHERE userId = '$user'");
						$result = "Email updated";
						}
					}
			
			?>
			<form action="traineeMain.php" method="post">
			<div class="subset">
				<label class="float">Username:</label>
				<input type="text" name="usernameUP"/>
				<input type="submit" name="update_username" value="Update"/>
				<br/>
				<label class="float">First Name:</label>
				<input type="text" name="firstnameUP"/>
				<br/>
				<label class="float">Last Name:</label> <input type="text" name="lastnameUP"/>
				<input type="submit" name="update_name" value="Update"/>
				<br/>
				<label class="float">Password:</label>
				<input type="password" name="passwordUP"/>
				<input type="submit" name="update_password" value="Update"/>
				<br/>
				<label class="float">Email:</label>
				<input type="text" name="emailUP"/>
				<input type="submit" name="update_email" value="Update"/>
				<br/>
				<span class="result"><?php echo $result?></span>
			</div>
			</form>
			<?php
			}
//Message Section			
			if(isset($_POST["Messages"]))
			{
				echo "<div class='subset'>";
				$users = $connection->query("SELECT * FROM `users` WHERE userID =".$_SESSION['id']);
				$user = $users->fetch_assoc();
				$trainer_name = $user['TrainerName'];
				$trainer = $connection->query("SELECT * FROM `users` WHERE username='$trainer_name'");
				while ($name = $trainer->fetch_assoc())
				{
					echo "To : " . $name['lastname'] . ", " . $name['firstname'];
				}
				?>
					<form action="traineeMain.php" method="post">
					<label>Subject :  </label><input type="text" name="emailSubject" size="45"/><br/>
					<textarea name="email" rows="10" cols="50"></textarea><br/>
					<input type="submit" name="emailSend" value="Send"/><br/>
				</div>
				</form>
				<?php
			}
			
			if(isset($_POST["emailSend"]))
			{	
				require 'email/PHPMailerAutoload.php';
				
				$users = $connection->query("SELECT * FROM `users` WHERE userID =".$_SESSION['id']);
				while ($user = $users->fetch_assoc()) 
				{
					$emailToName = $user['TrainerName'];
					$emailFrom = $user['email'];
					$emailFromName = $user['username'];
					$emailSubject = $_POST["emailSubject"];
					$emailBody = $_POST["email"];
					$emailSubject = htmlentities($emailSubject);
					$emailBody = htmlentities($emailBody)."\n\nFrom : ".$emailFromName." \nEmail : ".$emailFrom;
				}
				
				$users = $connection->query("SELECT * FROM `users` WHERE username = '".$emailToName."'");
				while ($user = $users->fetch_assoc()) 
				{
					$emailTo = $user['email'];
				}
				
				$mail = new PHPMailer;
				//Send mail using gmail
				$mail = new PHPMailer(true);
				$mail->IsSMTP(); // telling the class to use SMTP
				$mail->SMTPAuth = true; // enable SMTP authentication
				$mail->SMTPSecure = 'ssl'; // sets the prefix to the servier
				$mail->Host = 'smtp.gmail.com'; // sets GMAIL as the SMTP server
				$mail->Port = 465; // set the SMTP port for the GMAIL server
				$mail->Username = "cs3450fitnessapplication@gmail.com"; // GMAIL username
				$mail->Password = "cscs3450"; // GMAIL password
				
				//Typical mail data
				$mail->AddAddress($emailTo, $emailToName);
				$mail->SetFrom($emailFrom, $emailFromName);
				$mail->Subject = $emailSubject;
				$mail->Body = $emailBody;

				try{
					$mail->Send();
					echo "Success!";
				} catch(Exception $e){
					//Something went bad
					echo "Fail - " . $mail->ErrorInfo;
				}
			}
//Workout Section
		function postWorkout($day,$result) {
			echo "<h2>Today's Workout</h2>";
			while($row=$result->fetch_assoc()) {
				echo"<form>
						<fieldset>";
				
				
				echo "<p>Workout: $row[name]<br/>";
				echo "Description: $row[description].<br/>";
				echo "Example Video: <a href='http://$row[link]'>$row[link]</a>.<br/>";
				echo "This workout is worth $row[calorieCount] calories. </p>";
				
				echo "  </fieldset>
							</form>";
			}
		}
		function postPastWorkouts($day, $resultPast) {
			echo "<h2>Past Workouts</h2>";
			while($row=$resultPast->fetch_assoc()) {
				echo"<form>
						<fieldset>
							<legend>Day ".$row['dayOfYear']."</legend>";
				echo "<p>Workout: $row[name]<br/>";
				echo "Description: $row[description].<br/>";
				echo "Example Video: <a href='http://$row[link]'>$row[link]</a>.<br/>";
				echo "This workout is worth $row[calorieCount] calories. </p>";
				
				echo "  </fieldset>
							</form>";

			}
		}

		if(isset($_POST['Workouts'])||isset($_POST['pastWorkouts'])||isset($_POST['workoutComplete'])) {
		if($connection->connect_error) {
			die("<h2>Failed to connect to the database:<br/>$connect->connect_error</h2>");
		}
		$day=date('z')+1;
	
		if(isset($_POST['workoutComplete'])) {
			$workoutCalories=$connection->query("SELECT * FROM `workouts` WHERE dayOfYear=".$day);
			$amountOfCalories=$connection->query("SELECT * FROM `users` WHERE userId=".$_SESSION['id']);
			$WC=$workoutCalories->fetch_assoc();
			
			$aoc=$amountOfCalories->fetch_assoc();
			$row=$WC['calorieCount'];
			$row1=$aoc['mtdCalories'];
			$total=(int)$row+(int)$row1;
			$connection->query("UPDATE `users` SET `mtdCalories`=".$total." WHERE userId=".$_SESSION['id']);
			$connection->query("UPDATE `users` SET `workoutDone`=".$day." WHERE userId=".$_SESSION['id']);
		}
		
		$result=$connection->query("SELECT * FROM `workouts` WHERE dayOfYear=".$day);
		$resultPast=$connection->query("SELECT * FROM `workouts` WHERE dayOfYear<".$day." ORDER BY dayOfYear DESC");
		
		if(isset($_POST['pastWorkouts'])) {
			echo "<div class='subset'>";
			echo "Current Day: ".$day;
			postPastWorkouts($day,$resultPast);
		} else {
			echo "<div class='subset'>";
			echo "Current Day: ".$day;
			postWorkout($day,$result);
		}
		//$query1=$connect->query("UPDATE `workouts` SET `isPosted`=1 WHERE dayOfYear=".$day);
		$completeWork = $connection->query("SELECT `workoutDone` FROM `users` WHERE userID =".$_SESSION['id']);	
		if (!$completeWork) {
			echo "ERRROROR";
		}
		?>
		<form action="traineeMain.php" method="post"> 
		<?php
		if(!isset($_POST['pastWorkouts'])) {
			$var = $completeWork->fetch_assoc();
			if ($var['workoutDone'] != $day) {
			?>
			<div>
				<label>Have you completed this workout?</label>
				<input type="submit" name="workoutComplete" value="Yes" />
			</div>
			<?php } ?>
			<div>
				<label>Would you like to view past workouts?</label>
				<input type="submit" name="pastWorkouts" value="Yes" />
			</div>
		</div>
		<?php
		}
		if(isset($_POST['pastWorkouts'])) {
		?>
		<label>Would you like to view Today's workout? <input type="submit" name="Workouts" value="Yes" /> </label><br/>
		<?php } ?>
		</form>
		<?php } ?>
	</body>
</html>