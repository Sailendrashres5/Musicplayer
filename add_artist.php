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
        <form id="add_artist_form" class="flex flex-cols items-center justify-center gap-2">
            <label class="block w-75 text-size18" for="artist_name">Artist Name</label>
            <input type="text" class="input block w-75" name="artist" id="artist_name" placeholder="Enter artist's Name" />
            <label class="block w-75 text-size18" for="genre">Style/Genre</label>
            <select class="input block w-75" name="genre" id="genre">
                <option value="" class="hidden">Select Genre</option>
            </select>
            <label class="block w-75 text-size18" for="artist_avatar">Artist Avatar</label>
            <input type="file" class="input block w-75" name="avatar" id="artist_avatar" accept="image/*" />
            <label class="block w-75 text-size18" for="background">Artist Background</label>
            <input type="file" class="input block w-75" name="background" id="background" accept="image/*" />
            <button type="submit" class="btn-3 block w-75 mt-1">Add Artist</button>
        </form>
    </div>
</div>

<?php
include_once("./footer.php");
?>