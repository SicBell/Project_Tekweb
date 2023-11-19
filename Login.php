<?php
  include("db_connect.php");
  include("Sign_up.php");
?>
<style>
  /* Google Font Link */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins" , sans-serif;
}
body{
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #F6CAC9;
  padding: 30px;
}
/* FORM */
.container{
  position: relative;
  max-width: 850px;
  width: 100%;
  background: #F4BF96;
  padding: 40px 30px;
  box-shadow: 0 5px 10px rgba(0,0,0,0.2);
  perspective: 2700px;
}
.container .cover{
  position: absolute;
  top: 0;
  left: 50%;
  height: 100%;
  width: 50%;
  z-index: 98;
  transition: all 1s ease;
  transform-origin: left;
  transform-style: preserve-3d;
}
.container #flip:checked ~ .cover{
  transform: rotateY(-180deg);
}
 .container .cover .front,
 .container .cover .back{
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
}
.cover .back{
  transform: rotateY(180deg);
  backface-visibility: hidden;
}
.container .cover::before,
.container .cover::after{
  content: '';
  position: absolute;
  height: 100%;
  width: 100%;
  background: #FFCCCC;
  opacity: 0.5;
  z-index: 12;
}
.container .cover::after{
  opacity: 0.3;
  transform: rotateY(180deg);
  backface-visibility: hidden;
}
.container .cover img{
  position: absolute;
  height: 100%;
  width: 100%;
  object-fit: cover;
  z-index: 10;
}
.container .cover .text{
  position: absolute;
  z-index: 130;
  height: 100%;
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}
/* QUOTE  */
.cover .text .text-2{
  font-size: 26px;
  font-weight: 600;
  color: #EEEBDD;
  text-align: center;
}
.cover .text .text-1{
  font-size: 23px;
  font-weight: 600;
  color: #F9FCFB;
  text-align: center;
}
.cover .text .text-2{
  font-size: 15px;
  font-weight: 500;
}
.container .forms{
  height: 100%;
  width: 100%;
  background: #F4BF96;
}
.container .form-content{
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.form-content .login-form,
.form-content .signup-form{
  width: calc(100% / 2 - 25px);
}
/* LOGIN title */
.forms .form-content .title{
  position: relative;
  font-size: 24px;
  font-weight: 500;
  color: #E63870;
}
.forms .form-content .title:before{
  content: '';
  position: absolute;
  left: 0;
  bottom: 0;
  height: 3px;
  width: 25px;
  background: #FFCCCC;
}
.forms .signup-form  .title:before{
  width: 20px;
}
.forms .form-content .input-boxes{
  margin-top: 30px;
}
.forms .form-content .input-box{
  display: flex;
  align-items: center;
  height: 50px;
  width: 100%;
  margin: 10px 0;
  position: relative;
}


.form-content .input-box input {
  box-sizing: border-box; 
  height: 100%;
  
  width: 100%;
  outline: none;
  border: none;
  padding: 0 30px;
  font-size: 16px;
  font-weight: 500;
  border-bottom: 2px solid rgba(0, 0, 0, 0.2);
  transition: all 0.3s ease;
}
.form-content .input-box input:focus,
.form-content .input-box input:valid{
  border-color: #F5EEDC;
}
/* LOCK AND PROFILE */
.form-content .input-box i{
  position: absolute;
  color: #F56A47;
  font-size: 17px;
}
/* Dont' have account */
.forms .form-content .text {
  font-size: 14px;
  font-weight: 500;
  color: #FFA36C;
}

/* Change the color of the link to #F5EEDC */
.forms .form-content .text a {
  text-decoration: none;
  color: #FD5E53;
}

.forms .form-content .text a:hover {
  text-decoration: underline;
}
.forms .form-content .button{
  color: #FF63B5;
  margin-top: 40px;
}
/* SUBMIT */
.forms .form-content .button input{
  color: #FF63B5;
  background: #FFDDCC;
  border-radius: 6px;
  padding: 0;
  cursor: pointer;
  transition: all 0.4s ease;
}
.forms .form-content .button input:hover{
  background: #FFCCCC;
}
/* SIGN UP */
.forms .form-content label{
  color: #FF63B5;
  cursor: pointer;
}
.forms .form-content label:hover{
  text-decoration: underline;
}
.forms .form-content .login-text,
.forms .form-content .sign-up-text{
  text-align: center;
  margin-top: 25px;
}
.container #flip{
  display: none;
}
@media (max-width: 730px) {
  .container .cover{
    display: none;
  }
  .form-content .login-form,
  .form-content .signup-form{
    width: 100%;
  }
  .form-content .signup-form{
    display: none;
  }
  .container #flip:checked ~ .forms .signup-form{
    display: block;
  }
  .container #flip:checked ~ .forms .login-form{
    display: none;
  }
}
.forms .form-content .text.sign-up-text {
  font-size: 14px;
  font-weight: 500;
  color: #FD5E53; /* Change the color to #FD5E53 */
}

.forms .form-content .text.sign-up-text label {
  cursor: pointer;
}

.forms .form-content .text.sign-up-text label:hover {
  text-decoration: underline;
}
#logo{
  margin-left: 8px;
}

</style>
<!DOCTYPE html>

<html lang="en" dir="ltr">

  <head>
    <meta charset="UTF-8">
    
    <link rel="stylesheet" href="style.css">
    <
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="container">
    <input type="checkbox" id="flip">
    <div class="cover">
      <div class="front">
        <img src="background_login.jpg" alt="">
        <div class="text">
          <span class="text-1">"There is more treasure in books <br>than in all the pirate's loot on Treasure island"</span>
          <span class="text-2">-Walt Disney</span>
        </div>
      </div>
      <div class="back">
        
        <div class="text">
          <span class="text-1">Complete miles of journey <br> with one step</span>
          <span class="text-2">Let's get started</span>
        </div>
      </div>
    </div>
    <div class="forms">
        <div class="form-content">
          <div class="login-form">
            <div class="title">Login</div>
          <form action="#">
            <div class="input-boxes">
              <div class="input-box">
                <i id="logo" class="fas fa-envelope"></i>
                <input type="text" placeholder="Enter your email" required>
              </div>
              <div class="input-box">
                <i id="logo" class="fas fa-lock"></i>
                <input type="password" placeholder="Enter your password" required>
              </div>
              <div  class="text"><a  href="#">Forgot password?</a></div>
              <div class="button input-box">
                <input type="submit" value="Login">
              </div>
              <div class="text sign-up-text">Don't have an account? <label for="flip">Sigup now</label></div>
            </div>
        </form>
        <!-- SIGN UP -->
      </div>
        <div class="signup-form">
          <div class="title">Signup</div>
        <form name="signup_form" method="POST" action="Sign_up.php">
            <div class="input-boxes">
              <div class="input-box">
                <i id="logo" class="fas fa-user"></i>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
              </div>
              <div class="input-box">
                <i id="logo" class="fas fa-envelope"></i>
                <input type="text" id="email" name="email" placeholder="Enter your email" required>
              </div>
              <div class="input-box">
                <i id="logo" class="fas fa-lock"></i>
                <input type="password" id="pass" name="pass" placeholder="Enter your password" required>
              </div>
              <div class="input-box">
                <i id="logo" class="fas fa-lock"></i>
                <input type="password" id="cpass" name="cpass" placeholder="Confirm your password" required>
              </div>
              <div class="button input-box">
                <input type="submit" id="btn" value="SignUp" name="submit">
              </div>
              <div class="text sign-up-text">Already have an account? <label for="flip">Login now</label></div>
            </div>
      </form>
    </div>
    </div>
    </div>
  </div>
</body>
</html>
<style></style>