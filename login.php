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
        <a href="./signup.php" class="btn-1 mx-auto mr-6">Join</a>
    </nav>
    <div class="mx-auto mt-7 w-half">
        <form id="login_form" class="flex flex-cols items-center justify-center gap-2">
            <label class="block w-75 text-size18" for="email">Email</label>
            <input type="text" class="input block w-75" name="email" id="email" placeholder="Enter your email address" />
            <label class="block w-75 text-size18" for="password">Password</label>
            <input type="password" class="input block w-75" name="password" id="password" placeholder="Enter your password" />

            <p class="Error block w-75" id="error_msg">
                *Incorrect Email or Password
            </p>

            <button type="submit" class="btn-3 block w-75 mt-1">Log in</button>
        </form>
    </div>
</div>
<?php
include_once("./footer.php");
?>