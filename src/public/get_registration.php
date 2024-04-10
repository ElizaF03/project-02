<div class="container">
    <input type="checkbox" id="check">
    <div class="registration form">
        <header>Signup</header>
        <form action="post_registration.php" method="post">
            <label for="name" style="color: crimson" ><?php if(!empty($errors['name'])){echo 'Name is too short';}?></label>
            <input type="text" name="name" placeholder="Enter your name" value="<?php if(!empty($_POST['name'])){echo $_POST['name'];}?>">
            <label for="name" style="color: crimson" ><?php if(!empty($errors['email'])){echo 'Invalid email format';}?></label>
            <input type="text" name="email" placeholder="Enter your email" value="<?php if(!empty($_POST['email'])){echo $_POST['email'];}?>">
            <label for="password" style="color: crimson" ><?php if(!empty($errors['password'])){echo 'Password must contain as many as 6 characters including lower-case, upper-case, numbers and symbols.';}?></label>
            <input type="password" name="password" placeholder="Create a password">
            <label for="repeat-password" style="color: crimson" ><?php if(!empty($errors['pswRepeat'])){echo 'Errors matching password';}?></label>
            <input type="password" name="repeat-password" placeholder="Confirm your password">
            <button type="submit" class="button" value="Signup">Signup</button>
        </form>
        <div class="signup">
        <span class="signup">Already have an account?
         <label for="check">Login</label>
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