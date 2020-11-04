<?php
session_start();
//for CSRF
$_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
$token = $_SESSION['token'];
//for click jacking
header('X-FRAME-OPTIONS: SAMEORIGIN');

//init error message
$errors = array();

//DB info
// we can create new php file to connect DB later
$user = 'root';
$password = 'rmpoke1945';
$dbName = "student_profile";
$host = "localhost";
//DB connection
$dsn = "mysql:host={$host};dbname={$dbName};charser=utf8mb4";
$pdo = new PDO($dsn, $user, $password);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(empty($_GET)) {
	header("Location: registration_mail");
	exit();
}else{
	//insert get data
	$urltoken = isset($_GET["urltoken"]) ? $_GET["urltoken"] : NULL;
	//check token
	if ($urltoken == ''){
		$errors['urltoken'] = "No token.";
	}else{
		try{
			// connect to DB
			//flag = 0, it means temp member
			$sql = "SELECT mail FROM pre_user WHERE urltoken=(:urltoken) AND flag =0 AND date > now() - interval 24 hour";
           $stm = $pdo->prepare($sql);
			$stm->bindValue(':urltoken', $urltoken, PDO::PARAM_STR);
			$stm->execute();
			
			//get record num
			$row_count = $stm->rowCount();
			
			// within 24hrs and temp member token
			if( $row_count ==1){
				$mail_array = $stm->fetch();
				$mail = $mail_array["mail"];
				$_SESSION['mail'] = $mail;
			}else{
				$errors['urltoken_timeover'] = "
                This URL is not available. The expiration date may have expired or the URL may be incorrect. Please register again.";
			}
			//check db connection
			$stm = null;
		}catch (PDOException $e){
			print('Error:'.$e->getMessage());
			die();
		}
	}
}

/**
* btn_confirm
*/
if(isset($_POST['btn_confirm'])){
	if(empty($_POST)) {
		header("Location: registration_mail.php");
		exit();
	}else{
		//POST data
		$name = isset($_POST['name']) ? $_POST['name'] : NULL;
        $password = isset($_POST['password']) ? $_POST['password'] : NULL;
        $role = isset($_POST['role']) ? $_POST['role'] : NULL;
        $role_1 = $role;
		
		//session
		$_SESSION['name'] = $name;
        $_SESSION['password'] = $password;
        $_SESSION['role'] = $role;
        if($role_1==='0'){
            $role_1 = 'Student';
        }else $role_1 = 'Professor';

		//account
		//password
		if ($password == ''):
			$errors['password'] = "No password entered";
		else:
			$password_hide = str_repeat('*', strlen($password));
		endif;

		if ($name == ''):
			$errors['name'] = "No name entered";
        endif;
        
        if ($role == ''):
            $errors['role'] = "No role selected";
		endif;
	}
	
}

/**
* page_3
* btn_submit
*/
if(isset($_POST['btn_submit'])){
	//hash password
	$password_hash =  password_hash($_SESSION['password'], PASSWORD_DEFAULT);

	//register to DB here
	try{
		$sql = "INSERT INTO user_data (name,password,mail,status,created_at,updated_at,role) VALUES (:name,:password_hash,:mail,0,now(),now(),:role)";
       $stm = $pdo->prepare($sql);
		$stm->bindValue(':name', $_SESSION['name'], PDO::PARAM_STR);
        $stm->bindValue(':mail', $_SESSION['mail'], PDO::PARAM_STR);
        $stm->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
        $stm->bindValue(':role', $_SESSION['role'], PDO::PARAM_STR);
		$stm->execute();

		//pre_user flag -> 1, invalidation token
		$sql = "UPDATE pre_user SET flag=1 WHERE mail=:mail";
		$stm = $pdo->prepare($sql);
		//set the actual value in the placeholder
		$stm->bindValue(':mail', $mail, PDO::PARAM_STR);
		$stm->execute();
						
		/*
		* sending temporary registered emails to registered users and admin
       */
/* 
		$mailTo = $mail.','.$companymail;
       $body = <<< EOM
       Thank you for registering.
EOM;
       mb_language('en');
       mb_internal_encoding('UTF-8');
   
       //From header
       $header = 'From: ' . mb_encode_mimeheader($companyname). ' <' . $companymail. '>';
   
       if(mb_send_mail($mailTo, $registation_mail_subject, $body, $header, '-f'. $companymail)){          
           $message['success'] = "Registered!";
       }else{
           $errors['mail_error'] = "Failed to send email.";
		}	
*/
		//check DB connection
		$stm = null;

		//Release all session value
		$_SESSION = array();
		//Delete all cookie
		if (isset($_COOKIE["PHPSESSID"])) {
				setcookie("PHPSESSID", '', time() - 1800, '/');
		}
		//destroy session
		session_destroy();

	}catch (PDOException $e){
		//Transaction cancellation (rollback)
		$pdo->rollBack();
		$errors['error'] = "Please try again";
		print('Error:'.$e->getMessage());
	}
}

?>

<h1>Member registration</h1>

<!-- page_3 Complete page-->
<?php if(isset($_POST['btn_submit']) && count($errors) === 0): ?>
Registered.

	<a href="login.php"><button class="btn">Back to Login Page</button></a>

<!-- page_2 Confirm page-->
<?php elseif (isset($_POST['btn_confirm']) && count($errors) === 0): ?>
	<form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>?urltoken=<?php print $urltoken; ?>" method="post">
		<p>Email address：<?=htmlspecialchars($_SESSION['mail'], ENT_QUOTES)?></p>
		<p>Password：<?=$password_hide?></p>
        <p>Name：<?=htmlspecialchars($name, ENT_QUOTES)?></p>
        <p>Your role: <?=$role_1?></p>
		
		<input type="submit" name="btn_back" value="Back">
		<input type="hidden" name="token" value="<?=$_POST['token']?>">
		<input type="submit" name="btn_submit" value="Register">
	</form>

<?php else: ?>
<!-- page_1 Register page -->
	<?php if(count($errors) > 0): ?>
       <?php
       foreach($errors as $value){
           echo "<p class='error'>".$value."</p>";
       }
       ?>
   <?php endif; ?>
		<?php if(!isset($errors['urltoken_timeover'])): ?>
			<form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>?urltoken=<?php print $urltoken; ?>" method="post">
				<p>Email address：<?=htmlspecialchars($mail, ENT_QUOTES, 'UTF-8')?></p>
				<p>Password：<input type="password" name="password"></p>
                <p>Name：<input type="text" name="name" value="<?php if( !empty($_SESSION['name']) ){ echo $_SESSION['name']; } ?>"></p>
                <p>Student/Professor?<input type="radio" name ="role" value="0">Student<input type="radio" name ="role" value="1">Professor</p>
				<input type="hidden" name="token" value="<?=$token?>">
				<input type="submit" name="btn_confirm" value="Confirm">
			</form>
		<?php endif ?>
<?php endif; ?>