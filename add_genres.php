<?php
include_once("./check_admin.php");
include_once("./header.php");
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
    <div class="mx-auto mt-4 w-half">
        <form id="add_genre_form" class="flex flex-cols items-center justify-center gap-2">
            <label class="block w-75 text-size18" for="genre_name">Genre Name</label>
            <input type="text" class="input block w-75" name="genre" id="genre_name" placeholder="Enter name of the Genre" />
            <label class="block w-75 text-size18" for="genre_avatar">Genre Icon</label>
            <input type="file" class="input block w-75" name="avatar" id="genre_avatar" accept="image/*" />
            <button type="submit" class="btn-3 block w-75 mt-1">Add Genre</button>
        </form>
    </div>
</div>

<?php
include_once("./footer.php");
?>