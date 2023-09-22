<?php
include_once("./check_admin.php");

include_once("./header.php");
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header("location:./admin.php");
}
?>

<div class="min-h-screen grid grid-row-1 w-full container-1">
<nav class="main-header flex mt-3">
        <a href="./admin.php" class="ml-3 block">
            <img class="main-logo" src="./assets/icons/white-logo.png" />
        </a>
        <div class="mx-auto mr-6 flex items-center justify-center">
            <!-- <div class="profile mx-auto mr-6">Profile</div> -->
            <a href="./logout.php" class="btn-1">Logout</a>
        </div>
    </nav>
    <form id="update_user" class="flex flex-cols items-center justify-center gap-2" aria-id="<?php echo $id; ?>">
        <label class="block w-half" for="fullname">Full name</label>
        <input type="text" id="fullname" name="full_name" placeholder="Enter your full name" class="input block w-half" />
        <p class="Error w-half">*Please enter your full name</p>
        <label class="block w-half" for="email">Email</label>
        <input type="text" name="email" id="email" placeholder="Enter your email address" class="input block w-half" />
        <p class="Error w-half">*Please enter valid email</p>
        <label class="block w-half" for="password">Password</label>
        <input type="password" id="password" placeholder="Enter your password" class="input block w-half" />
        <p class="Error w-half">*Please enter password that contains at lease one Capital letter, a Number and a Special Character</p>
        <label class="block w-half" for="confirm_password">Confirm Password</label>
        <input type="password" id="confirm_password" name="password" placeholder="Confirm Password" class="input block w-half" />
        <p class="block Error w-half">*Please check if the passwords match</p>
        <button type="submit" class="btn-2">Update User</button>
    </form>
    <?php
    include_once("./footer.php");
    ?>