<?php
session_start();
if (isset($_SESSION["user_email"])) {
    header("Location:./index.php");
}

include_once("./header.php");
?>

<div class="min-h-screen grid grid-row-1 w-full container-1">
    <nav class="main-header mt-3">
        <a href="/" class="ml-3">
            <img class="main-logo" src="./assets/icons/white-logo.png" />
        </a>
        <a href="./login.php" class="btn-1 mx-auto mr-6">Login</a>
    </nav>
    <div class="mx-auto w-half mt-3">    
        <form id="signup_form" class="flex flex-cols items-center justify-center gap-2">
            <label class="block w-75 " for="fullname">Full name</label>
            <input type="text" id="fullname" name="full_name" placeholder="Enter your full name" class="input-signup block w-75" />
            <p class="Error block w-75">*Please enter your full name</p>
            <label class="block w-75 " for="email">Email</label>
            <input type="text" name="email" id="email" placeholder="Enter your email address" class="input-signup block w-75" />
            <p class="Error block w-75">*Please enter valid email</p>
            <label class="block w-75" for="password">Password</label>
            <input type="password" id="password" placeholder="Enter your password" class="input-signup block w-75" />
            <p class="Error block w-75">*Please enter password that contains at lease one Capital letter, a Number and a Special Character</p>
            <label class="block w-75 " for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="password" placeholder="Confirm Password" class="input-signup block w-75" />
            <p class="Error block w-75">*Please check if the passwords match</p>
            <button type="submit" class="btn-3 block w-75 mt-1">Join</button>
        </form>
    </div>

    <?php
    include_once("./footer.php");
    ?>