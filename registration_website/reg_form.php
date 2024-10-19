<?php
include('data.php')
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration page</title>
    <link rel="stylesheet" href="regform.css" type="text/css">
</head>
<body>
    <div class="regform">
         <h2>Create an Account</h2>
         <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post"
         >
         <input type="text" placeholder="Name" name="name" size="30" required>
         <br>
         <input type="email" placeholder="Email" name="email" size="30" required>
         <br>
         <input type="password" placeholder="Password" name="password" size="30" minlength="8" required>
         <br>
         <input type="text" placeholder="Contact" name="contact" size="30" maxlength="10" minlength="10" required>
         <br>
         <input class="sub-btn" type="submit" name="submit" size="20">
    </div>
</body>
</html>
<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(isset($_POST["submit"])){
        $name=filter_input(INPUT_POST,"name",FILTER_SANITIZE_SPECIAL_CHARS);
        $password=password_hash(filter_input(INPUT_POST,"password",FILTER_SANITIZE_SPECIAL_CHARS),PASSWORD_BCRYPT);
        $email=filter_input(INPUT_POST,"email",FILTER_SANITIZE_SPECIAL_CHARS);
        $contact=filter_input(INPUT_POST,"contact",FILTER_SANITIZE_SPECIAL_CHARS);
        if(empty($name)){
            echo "You have not entered the username";
        }
        elseif(empty($email)){
            echo "You have not entered the email";
        }
        elseif(empty($password)){
            echo "You have not entered the password";
        }
        elseif(empty($contact)){
            echo "You have not entered the contact details";
        }
        else{
            $SQL=$conn->prepare("CALL insert_user(?,?,?,?)");
            $SQL->bind_param("ssss",$name,$email,$password,$contact);
            try{
                $SQL->execute();
                header("location:successful.php");
            }
            catch(mysqli_sql_exception){
               echo "<div class='email' style='text-align:center;margin-left:150px;' >
                     <p>Registration was not succesful!<br>You have entered a pre-existing email<p>
                     </div>";
        }
    }
        $SQL->close();
    }    
    }
mysqli_close($conn);
?>