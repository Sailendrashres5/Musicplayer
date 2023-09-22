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
    <div class="mx-auto mt-6 w-half">
        <form id="add_song" class="flex flex-cols items-center justify-center gap-2">
            <label class="block w-75 text-size18" for="song">Song Name</label>
            <input type="text" class="input block w-75" name="song" id="song_name" placeholder="Enter Song Name" />
            <label class="block w-75 text-size18" for="song_genre">Style/Genre</label>
            <select class="input block w-75" name="genre" id="song_genre">
                <option class="hidden" value="">Select Style/Genre</option>
            </select>
            <label class="block w-75 text-size18" for="song_artist" aria-roledescription="label">Artist</label>
            <select class="input block w-75" name="genre" id="song_artist">
            <option value="" class="hidden">Select Artist</option>
            </select>
            <label class="block w-75 text-size18" for="song_file">Song File</label>
            <input type="file" class="input block w-75" name="song_file" id="song_file" placeholder="Enter Song File" /> 
            <button type="submit" class="btn-3 block w-75 mt-1">Add Song</button>
        </form>
    </div>
</div>

<?php
include_once("./footer.php");
?>