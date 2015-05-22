<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Fitness Trainer Page</title>
		<link rel="stylesheet" type="text/css" href="trainerStyle.css">
	</head>
	
	
	<?php
		session_start(); //for the global variable
	?>
	
	<body>
		<div class="banner">
		<img src="sitUp.jpg" alt="People doing situps">
		<h1>Welcome to <span>Fitness</span></h1>
		</div>
		
		<?php //all variable
			$emailTo = "";
			$emailToName = "";
			$emailFrom = "";
			$emailFromName = "";
			$emailSubject = "";
			$emailBody = "";
			//trainer workout Variables
			$exerciseName="";
			$dayOfYear=0;
			$link="";
			$calorieCount=0;
			$description="";
		
			
			$connection = new mysqli("localhost", "zachohearn", "orange", "zachohearn");
		
			if($connection->connect_error) {
				die("<h2>Unable to connect to database $conection->connect_error</h2>");
			}
			
			$users = $connection->query("SELECT * FROM `users` WHERE userID =".$_SESSION['id']);
			while ($user = $users->fetch_assoc()) 
			{
				$username = $user['username'];
			}
			//echo "Hi, ".$username;
		?>
		
		
<!--Header Section-->	
		<form action="trainerMain.php" method="post">
			<div>
				<input class="nav" type="submit" name="Profile" value="Profile" id="profile"/>
				<input class="nav" type="submit" name="Trainees" value="Trainees" id="trainees"/>
				<input class="nav" type="submit" name="Workouts" value="Post Workouts"/>
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
			if((isset($_POST["Profile"])) || (!isset($_POST["Trainees"]) && !isset($_POST["Workouts"]) && !isset($_POST["Messages"]) && (!isset($_POST["chooseWorkout"])) && (!isset($_POST["emailChoose"])) && (!isset($_POST["emailSend"])) && (!isset($_POST["addTrainee"])) && (!isset($_POST["add"])) && !isset($_POST["editProfile"]) && !isset($_POST["update_username"]) && !isset($_POST["update_name"]) && !isset($_POST["update_password"]) && !isset($_POST["update_email"]))) {
				$users = $connection->query("SELECT * FROM users");
				$user = $_SESSION['id'];
				
				$result = $connection->query("SELECT username, firstname, lastname, email FROM users WHERE userId = '$user'");
				
				while($rows = mysqli_fetch_array($result)):
					
				$user_name = $rows['username'];
				$first_name = $rows['firstname'];
				$last_name = $rows['lastname'];
				$email = $rows['email'];
				endwhile;
				
				?>
				<form action="trainerMain.php" method="post">
				<div class="subset">
					<p><h2>Profile</h2></p>
					<p>Name: <?php echo $first_name . " " . $last_name;?></p>	
					<p>Email: <?php echo $email;?></p>
					<input class="profile" type="submit" name="editProfile" value="Edit Profile" />
				</div>
				</form>
				<?php	
			}
//Updating Profile
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
				<form action="trainerMain.php" method="post">
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
//Trainee Section
			if(isset($_POST['Trainees'])) {
				?>
				<form action="trainerMain.php" method="post">
				<div class="subset">
				<h2>Trainees</h2>
				<table>
					<tr class="header">
						<th>Name </th><th>MTD Calorie Count</th><th>Email Address</th>
					</tr>
				<?php
					$users = $connection->query("SELECT * FROM `users` WHERE TrainerName = '".$username."' ORDER BY `lastname` ");
					$count = 0;
					while ($user = $users->fetch_assoc()) {
						if ($count%2 == 0) {
							echo "<tr class='even'>";
						} else {
							echo "<tr class='odd'>";
						}
						echo "<td>" . $user['lastname'] . ", " . $user['firstname'] . "</td>";
						echo "<td>" . $user['mtdCalories'] . "</td>";
						echo "<td>" . $user['email'] . "</td>";
						echo "</tr>";
						$count++;					
					}
				echo "</table>";
				echo "<input type='submit' name='addTrainee' value='Add New Trainee' />";
				echo "</div>";
				echo "</form>";
			}
			
			if (isset($_POST["addTrainee"]) || isset($_POST['add'])) {
				//values
				$fname = "";
				$lname = "";
				$Newusername = "";
				$password = "";
				$email = "";
				$result = "";
				//Err Msgs
				$errFname = "";
				$errLname = "";
				$errUsername = "";
				$errPassword = "";
				$errEmail = "";
				//bools
				$boolfname = false;
				$boollname = false;
				$booluser = false;
				$boolpass = false;
				$boolemail = false;
				if (isset($_POST['add'])) {
					$fname = $_POST['fname'];
					$lname = $_POST['lname'];
					$Newusername = $_POST['username'];
					$email = $_POST['email'];
					if (empty($_POST['fname'])) {
						$errFname = "This field must be filled.";
						$boolfname = false;
					} else {
						$errFname = "";
						$boolfname = true;
						
					}
					if (empty($_POST['lname'])) {
						$errLname = "This field must be filled.";
						$boollname = false;
					} else {
						$errLname = "";
						$boollname = true;
						
					}
					if (empty($_POST['username'])) {
						$errUsername = "This field must be filled.";
						$booluser = false;
					} else {
						$errUsername = "";
						$booluser = true;
					}
					if (empty($_POST['password'])) {
						$errPassword = "This field must be filled.";
						$boolpass = false;
					} else {
						$errPassword = "";
						$boolpass = true;
					}
					if (empty($_POST['email'])) {
						$errEmail = "This field must be filled.";
						$boolemail = false;
					} else {
						$errEmail = "";
						$boolemail = true;
					}
					if ($boolfname && $boollname && $booluser && $boolpass && $boolemail) {
						$fname = $connection->real_escape_string(htmlentities($_POST['fname']));
						$lname = $connection->real_escape_string(htmlentities($_POST['lname']));
						$Newusername = $connection->real_escape_string(htmlentities($_POST['username']));
						$password = $connection->real_escape_string(htmlentities($_POST['password']));
						$email = $connection->real_escape_string(htmlentities($_POST['email']));
						$attempt = $connection->query("INSERT INTO `users`(`firstname`, `lastname`, `username`, `password`, `mtdCalories`, `isTrainee`, `TrainerName`, `email`, `workoutDone`) VALUES ('$fname' , '$lname' , '$Newusername' , '$password' , 0 , 1 , '$username', '$email', 0)");
						if ($attempt) {
							$result = "Insertion Complete";
						} else {
							$result = "Insertion Incomplete";
						}
						?>
						<script>
							document.getElementById('trainees').click();
						</script>
						<?php
					}
				}
				?>
				<form action="trainerMain.php" method="post">
				<div class="subset">
					<h2>Add New Trainee</h2>
					<div>
						<label>First Name: </label>
						<input type="text" name="fname" value="<?php echo $fname ?>" />
						<span class="error">
							<?php echo $errFname?>
						</span>
					</div>
					<div>
						<label>Last Name: </label>
						<input type="text" name="lname" value="<?php echo $lname ?>" />
						<span class="error">
							<?php echo $errLname?>
						</span>
					</div>
					<div>
						<label>Username: </label>
						<input type="text" name="username" value="<?php echo $Newusername ?>" />
						<span class="error">
							<?php echo $errUsername?>
						</span>
					</div>
					<div>
						<label>Password: </label>
						<input type="text" name="password" />
						<span class="error">
							<?php echo $errPassword?>
						</span>
					</div>
					<div>
						<label>Email: </label>
						<input type="text" name="email" value="<?php echo $email ?>" />
						<span class="error">
							<?php echo $errEmail?>
						</span>
					</div>
					<div>
						<input type="submit" name="add" value="Add New Trainee" />
						<span>
							<?php echo $result ?>
						</span>
					</div>
				</div>
				</form>
			<?php
			}
//Messages Section			
			if(isset($_POST["Messages"])) {
				echo '<form action="trainerMain.php" method="post">';
				echo "<div class='subset'>";
				echo "<h2>Messages</h2>";
				echo "Trainee List :";
				$users = $connection->query("SELECT * FROM `users` WHERE TrainerName = '".$username."'");
				while ($user = $users->fetch_assoc()) 
				{
				?>
					<div>
						<input type="radio" name="traineeEmail" value="<?php echo $user['userId']; ?>">
						<?php echo $user['lastname'] . ", " . $user['firstname']; ?>
					</div>
				<?php
				}
				?>
				<input type="submit" name="emailChoose" value="Choose"/>
				</div>
				</form>
				<?php
			}
			
			if(isset($_POST["emailChoose"]))
			{	
				
				if(!isset($_POST["traineeEmail"]))
				{
					?>
					<form action="trainerMain.php" method="post">
					<div class="subset">
					<h2>Messages</h2>
					<p>Trainee List:</p>
					
					<?php
						$users = $connection->query("SELECT * FROM `users` WHERE TrainerName = '".$username."'");
						while ($user = $users->fetch_assoc()) 
						{
							?>
								<input type="radio" name="traineeEmail" value="<?php echo $user['userId']; ?>">
									<?php echo $user['lastname'] . ", " . $user['firstname']; ?><br/>
							<?php
						}
						?>
						<input type="submit" name="emailChoose" value="Choose"/>
						<span class="error">Please, select a trainee!</span><br/>
					</div>
					</form>
					<?php
				
				} else {
					echo "<div class='subset'>";
					$users = $connection->query("SELECT * FROM `users` WHERE userID =".$_POST["traineeEmail"]);
					while ($user = $users->fetch_assoc()) 
					{
						echo "To : " . $user['lastname'] . ", " . $user['firstname'];
						$_SESSION['traineeEmail'] = $_POST["traineeEmail"];
					}
					?>
					<form action="trainerMain.php" method="post">
					<label>Subject :</label><input type="text" name="emailSubject" size="45"/><br/>
					<textarea name="email" rows="10" cols="50"></textarea><br/>
					<input type="submit" name="emailSend" value="Send"/><br/>
					</div>
					</form>
					<?php
				}
			}
			
			if(isset($_POST["emailSend"]))
			{	
				require 'email/PHPMailerAutoload.php';
				
				$users = $connection->query("SELECT * FROM `users` WHERE userID =".$_SESSION['id']);
				while ($user = $users->fetch_assoc()) 
				{
					
					$emailFrom = $user['email'];
					$emailFromName = $user['username'];
					$emailSubject = $_POST["emailSubject"];
					$emailBody = $_POST["email"];
					$emailSubject = htmlentities($emailSubject);
					$emailBody = htmlentities($emailBody)."\n\nFrom : ".$emailFromName." \nEmail : ".$emailFrom;
				}
				
				$users = $connection->query("SELECT * FROM `users` WHERE userID =".$_SESSION['traineeEmail']);
				while ($user = $users->fetch_assoc()) 
				{
					$emailToName = $user['username'];
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
			if(isset($_POST["Workouts"])) {
			?>
				<form action="trainerMain.php" method="post">
					<div class="subset">
							<h2>Workouts</h2>
							<label class="radio">Edit Workout</label>
							<input type="radio" name="workout" value="Edit Workouts" />
						<br/>
							<label class="radio">Add Workout</label>
							<input type="radio" name="workout" value="Add Workouts" />
						<br/>
						<input type="submit" name="chooseWorkout" value="GO">
					</div>
				</form>
			<?php
			}
			if (isset($_POST['chooseWorkout'])) {
				if (!isset($_POST['workout'])) {
					?>
						<form action="trainerMain.php" method="post">
						<div class="subset">
								<h2>Workouts</h2>
								<label class="radio">Edit Workout</label>
								<input type="radio" name="workout" value="Edit Workouts" />
							<br/>
								<label class="radio">Add Workout</label>
								<input type="radio" name="workout" value="Add Workouts" />
							<br/>
							<input type="submit" name="chooseWorkout" value="GO">
							<span class="error">Please, select an option</span>
						</div>
					</form>
					<?php
				} else if ($_POST['workout'] == "Add Workouts") {
					?>
						<form action="trainerMain.php" method="post">
							<div class="subset">
							<?php
							$day=date('z')+1;
							echo "Current Day: " . $day; 
							?> 
							<h2>Add Workout</h2>
								<label class="long">Workout Name: </label>
								<input type="text" name="name" />
								<br/>
								<label class="long">Day (1-365): </label>
								<input type="text" name="dayOfYear" />
								<br/>
								<label class="long">Link to Workout: </label>
								<input type="text" name="link" />
								<br/>
								<label class="long">Calorie Count: </label>
								<input type="text" name="calorieCount" />
								<br/>
								<label class="long">Description: </label>
								<input type="text" name="description" />
								<br/>
								<input type="submit" name="insertWorkout" value="Add Workout"/>
							</div>
						</form>			
					<?php
				} else if($_POST["workout"] == "Edit Workouts") {
					$allWorkouts=$connection->query("SELECT * FROM `workouts` WHERE dayOfYear<400 ORDER BY dayOfYear DESC");
			
					echo '<form action="trainerMain.php" method="post">';
					echo '<div class="subset">';
					echo '<h2>Edit Workout</h2>';
					while($row=$allWorkouts->fetch_assoc())
					{
					?>
						<p>
							<input type="radio" name="workoutList" value="<?php echo $row['dayOfYear']; ?>">
							<?php echo "Workout Name: ".$row['name']. "<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" ."Day: ".$row['dayOfYear']; ?>
						</p>
					<?php
					}
					?>
					<input type="submit" name="deleteWorkout" value="Delete"/><br/>
						</div>
						</form>
					<?php
			
				}
			}
			if(isset($_POST["insertWorkout"])) {
				if (($_POST["calorieCount"] > 0) && ($_POST["dayOfYear"] < 366 && $_POST["dayOfYear"] > 0)) {
					$exerciseName=$_POST["name"];
					$dayOfYear=$_POST["dayOfYear"];
					$link=$_POST["link"];
					$calorieCount=$_POST["calorieCount"];
					$description=$_POST["description"];
					
					$exerciseName=htmlentities($exerciseName);
					$dayOfYear=htmlentities($dayOfYear);
					$link=htmlentities($link);
					$calorieCount=htmlentities($calorieCount);
					$description=htmlentities($description);

					$exerciseName = $connection->real_escape_string($exerciseName);
					$dayOfYear = $connection->real_escape_string($dayOfYear);
					$link = $connection->real_escape_string($link);
					$calorieCount = $connection->real_escape_string($calorieCount);
					$description = $connection->real_escape_string($description);
					
					//echo "exercise: ".$exerciseName." day of year: ".$dayOfYear." link: ".$link." Caloie Count: ".$calorieCount." desc: ".$description;
					
				
					
					$val=$connection->query("INSERT INTO `workouts`(`name`, `dayOfYear`, `link`, `calorieCount`, `description`) VALUES ("."'".$exerciseName."'".", ".$dayOfYear.", "."'".$link."'".", ".$calorieCount.","."'".$description."'".")");
					if($val) {
						echo "Successfully Inserted! ";
					} else {
						echo "One or more field were not entered correctly..Please try again.";
					}
				} else {
					echo "One or more field were not entered correctly..Please try again.";
				}
			}			
			if(isset($_POST["deleteWorkout"])&&isset($_POST["workoutList"])) {
				$connection->query("DELETE FROM `workouts` WHERE dayOfYear =".$_POST["workoutList"]);
				echo "Deletion Successful. ";
			}
			?>
	</body>
</html>