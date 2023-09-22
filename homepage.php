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
<main class="mt-12 pl-2">
    <h1 class="title text-center">Feel the music</h1>
    <p class="subtitle text-center">
        Stream your favourite music in just one click.
    </p>
    <button class="btn-2 mx-auto mt-6 text-center">
        <a href="./signup.php">
            Join Now
        </a>

    </button>
</main>

<div class="blue-circle"></div>
<div class="yellow-circle"></div>
<div class="pink-circle"></div>
</div>
<?php
include_once("./footer.php");
?>