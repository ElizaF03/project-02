<div class="container">
    <input type="checkbox" id="check">
    <label class="login form">
        <header>Login</header>
        <form action='post_login.php' method="post">
            <label for="email" style="color: crimson" ><?php if(!empty($errors['email'])){echo $errors['email'];}?></label>
            <label for="email"  style="color: crimson" ><?php if(isset($noReg)){echo $noReg;}?></label>
            <input type="text" placeholder="Enter your email" name="email">
            <label for="password" style="color: crimson" ><?php if(!empty($errors['password'])){echo $errors['password'];}?></label>
            <label for="password" style="color: crimson" ><?php if(isset( $incorrectPassword )){echo  $incorrectPassword ;}?></label>
            <input type="password" placeholder="Enter your password" name="password">
            <button type="submit" class="button" value="Login">Login</button>
        </form>
        <div class="signup">
        <span class="signup">Don't have an account?
       <a href="get_registration.php">Registration</a>
        </span>
        </div>
    </div>
</div>
<style>

    #check:checked ~ .registration {
        display: block;
    }

    #check:checked ~ .login {
        display: none;
    }

    #check {
        display: none;
    }

    .container .form {
        padding: 2rem;
    }

    .form header {
        font-size: 2rem;
        font-weight: 500;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .form input {
        height: 60px;
        width: 100%;
        padding: 0 15px;
        font-size: 17px;
        margin-bottom: 1.3rem;
        border: 1px solid #ddd;
        border-radius: 6px;
        outline: none;
    }

    .button {
        height: 60px;
        width: 100%;
        padding: 0 15px;
        font-size: 17px;
        margin-bottom: 1.3rem;
        border: 1px solid #ddd;
        border-radius: 6px;
        outline: none;
        cursor: pointer;
        text-decoration: none;
        background: #006653;
        color: #dddddd;
    }

    .form input:focus {
        box-shadow: 0 1px 0 rgba(0, 0, 0, 0.2);
    }

    .form a {
        font-size: 16px;
        color: #009579;
        text-decoration: none;
    }

    .form a:hover {
        text-decoration: underline;
    }

    .form input.button {
        color: #fff;
        background: #009579;
        font-size: 1.2rem;
        font-weight: 500;
        letter-spacing: 1px;
        margin-top: 1.7rem;
        cursor: pointer;
        transition: 0.4s;
    }

    .form input.button:hover {
        background: #006653;
    }

    .signup {
        font-size: 17px;
        text-align: center;
    }

    .signup label {
        color: #009579;
        cursor: pointer;
    }

    .signup label:hover {
        text-decoration: underline;
    }
</style>