<?php
    include('db_connect.php');
    if (isset($_POST['submit'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['pass']);
        $cpassword = mysqli_real_escape_string($conn, $_POST['cpass']);

        
        
        $sql = "Select * from accounts where username='$username'";
        $result = mysqli_query($conn, $sql);        
        $count_user = mysqli_num_rows($result);  

        $sql = "Select * from accounts where email='$email'";
        $result = mysqli_query($conn, $sql);        
        $count_email = mysqli_num_rows($result);  
        
        if($count_user == 0 && $count_email==0){  
            
            if($password == $cpassword) {
    
                
                    
                // Password Hashing is used here. 
                $sql = "INSERT INTO accounts(username, email, password) VALUES('$username', '$email','$password')";
        
                $result = mysqli_query($conn, $sql);
        
                if ($result) {
                    header("Location: index.php");
                }
            } 
            else { 
                echo  '<script>
                        alert("Passwords do not match")
                        window.location.href = "login.php";
                    </script>';
            }      
        }  
        else{  
            if($count_user>0){
                echo  '<script>
                        window.location.href = "login.php";
                        alert("Username already exists!!")
                    </script>';
            }
            if($count_email>0){
                echo  '<script>
                        window.location.href = "login.php";
                        alert("Email already exists!!")
                    </script>';
            }
        }     
    }
    ?>