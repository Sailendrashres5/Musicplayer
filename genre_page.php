<?php
include_once("./check_login.php");
include_once("./header.php");

include_once('./function.php');

//declaration of the objects needed for the page
$artist = new Artist();

$id = $_GET['id'];

$artist_groups = $artist->getArtistByGenres($id);

?>
<main class="music_wrapper" id="main_music_wrapper">
    <nav class="navigation"><?php include_once("./music_nav.php"); ?> </nav>
    <section class="main_wrapper" aria-label="container">
        <div class="flex justify-between items-center">
            <h1 class="poppins greetings text-size32"> Greetings, <?php echo (isset($_SESSION['user_name'])) ? $_SESSION['user_name'] : ''; ?></h1>
            <input id="genre_artist_search" type="text" class="search-bar" placeholder="Search...">
        </div>
        <div class="home-song-container snap-inline">

            <div class="song-container" id="genre_artist_wrapper">
                <?php foreach ($artist_groups as $group) : ?>
                    <a href="./artist_page.php?id=<?php echo $group["id"]; ?>" class="song-wrapper">
                        <img class="song-image" src="./assets/images/<?php echo (!empty($group) && $group['avatar']) ? $group['avatar'] : "default_music_icon.jpg"; ?>" alt="<?php echo $group['name']; ?>" />
                        <header class="text-white"><?php echo $group['name']; ?></header>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <section class="music-player wrapper">
        <?php
        include_once('./music_player.php');
        ?>
    </section>
</main>
<?php
include_once("./footer.php");
?>