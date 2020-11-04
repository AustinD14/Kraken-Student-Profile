<?php
session_start();
//（CSRF)
$_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
$token = $_SESSION['token'];
// Clickjacking
header('X-FRAME-OPTIONS: SAMEORIGIN');
// database information !!!create DBconnect php file later
$user = 'root';
$password = 'rmpoke1945';
$dbName = "student_profile";
$host = "localhost";
//init error message
$errors = array();
//connect to DB
$dsn = "mysql:host={$host};dbname={$dbName};charser=utf8mb4";
$pdo = new PDO($dsn, $user, $password);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//after click "send" button
if (isset($_POST['submit'])) {
   //if email is empty
   if (empty($_POST['mail'])) {
       $errors['mail'] = 'Email address has not been entered.';
   }else{
       //put post data into variable
       $mail = isset($_POST['mail']) ? $_POST['mail'] : NULL;
   
       //chack mail address
       if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $mail)){
			$errors['mail_check'] = "Email address format is incorrect.";
       }
       //DB check        
       $sql = "SELECT id FROM user_data WHERE mail=:mail";
       $stm = $pdo->prepare($sql);
       $stm->bindValue(':mail', $mail, PDO::PARAM_STR);
       
       $stm->execute();
       $result = $stm->fetch(PDO::FETCH_ASSOC);
       //if same value is in user_data, throw error
       if(isset($result["id"])){
			$errors['user_check'] = "This email address is already in use.";
       }
       
   }
   //if no error, insert data to pre_user table
   if (count($errors) === 0){
       $urltoken = hash('sha256',uniqid(rand(),1));
       // Caution!!
       //we change url when we use AWS
       // Caution!!
       $url = "http://localhost/kraken/signup.php?urltoken=".$urltoken;
       //register to db here
       try{
           //exception
           $sql = "INSERT INTO pre_user (urltoken, mail, date, flag) VALUES (:urltoken, :mail, now(), '0')";
           $stm = $pdo->prepare($sql);
           $stm->bindValue(':urltoken', $urltoken, PDO::PARAM_STR);
           $stm->bindValue(':mail', $mail, PDO::PARAM_STR);
           $stm->execute();
           $pdo = null;
           $message = "The email was sent. Please register from the URL provided in the email within 24 hours.";     
       }catch (PDOException $e){
           print('Error:'.$e->getMessage());
           die();
       }
       /*
       * Email certificate
       * now I test without this
       * 
       */
       /*  
       $mailTo = $mail;
       
       //Return-Path address
       $returnMail = '';

       $name = "CIT496P Project";
       $mail = '';
       $subject = "Register Student Profile";

       $body = <<< EOM
       register below URL within 24 hours
       {$url}
EOM;
       mb_language('en');
       mb_internal_encoding('UTF-8');
   
       //create from header
       $header = 'From: ' . mb_encode_mimeheader($name). ' <' . $mail. '>';
   
       if(mb_send_mail($mailTo, $subject, $body, $header, '-f'. $returnMail)){      
           //release session
           $_SESSION = array();
           //delete cookie
           if (isset($_COOKIE["PHPSESSID"])) {
               setcookie("PHPSESSID", '', time() - 1800, '/');
           }
           //destroy session
           session_destroy();
           $message = "The email was sent. Please register from the URL provided in the email within 24 hours.";
       } else {
           $errors['mail_error'] = "Failed to send email.";
       }
       */
   }
}
?>
<h1>Temporary membership registration</h1>
<?php if (isset($_POST['submit']) && count($errors) === 0): ?>
   <!-- registered  -->
   <p><?=$message?></p>
   <p>↓TEST(delete this later)：sent email has this URL</p>
   <a href="<?=$url?>"><?=$url?></a>
<?php else: ?>
<!-- register -->
   <?php if(count($errors) > 0): ?>
       <?php
       foreach($errors as $value){
           echo "<p class='error'>".$value."</p>";
       }
       ?>
   <?php endif; ?>
   <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">
       <p>email address：<input type="text" name="mail" size="50" value="<?php if( !empty($_POST['mail']) ){ echo $_POST['mail']; } ?>"></p> 
       <input type="hidden" name="token" value="<?=$token?>">
       <input type="submit" name="submit" value="Send">
   </form>
<?php endif; ?>
