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
    <main class="mt-6 pl-2">
        <div class="w-qtr mx-auto bg-black opacity-60 rounded-11 pad-2">

            <header class="text-size28 text-center">Welcome <?php echo $_SESSION['user_name']; ?></header>
            <hr width="100%">
            <a class="block text-white mt-3 text-size20 text-center hovering" href="admin_songs.php">Songs</a>
            <a class="block text-white mt-3 text-size20 text-center hovering" href="add_songs.php">Add Songs</a>
            <a class="block text-white mt-3 text-size20 text-center hovering" href="admin_artists.php">Artists</a>
            <a class="block text-white mt-3 text-size20 text-center hovering" href="admin_users.php">Users</a>
            <a class="block text-white mt-3 text-size20 text-center hovering" href="add_artist.php">Add Artists</a>
            <a class="block text-white mt-3 text-size20 text-center hovering" href="admin_genres.php">Genres</a>
            <a class="block text-white mt-3 text-size20 text-center hovering" href="add_genres.php">Add Genres</a>
            <a class="block text-white mt-3 text-size20 text-center hovering" href="index.php">Go To Player</a>

        </div>
    </main>

    <div class="blue-circle"></div>
    <div class="yellow-circle"></div>
    <div class="pink-circle"></div>
</div>
<?php
include_once("./footer.php");
?>