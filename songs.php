<?php
include_once("./check_login.php");
include_once("./header.php");

include_once('./function.php');

//declaration of the objects needed for the page
$song = new Song();
$artist = new Artist();
$genre = new Genre();

$song_data_fetch = $song->getAllSongs();
$algorithm = new BayesianPopularityCalculator($song_data_fetch);
$song_data = $algorithm->calculatePopularity();
if (!empty($song_data)) {
    // Divide the song data into groups of 8
    $song_groups = array_chunk($song_data, 8);
} else {
    // If the song data array is empty, initialize an empty array
    $song_groups = [];
}
?>
<main class="music_wrapper" id="main_music_wrapper">
    <nav class="navigation"><?php include_once("./music_nav.php"); ?> </nav>
  <section class="main_wrapper" aria-label="container">

    <div class="flex justify-between items-center">
        <h1 class="poppins greetings text-size32">Songs</h1>
        <input id="songs_searchbar" type="text" class="search-bar" placeholder="Search...">
    </div>
    <div class="home-song-container snap-inline">
        
            <ul class="flex-cols mt-4">
        <?php
        foreach ($song_data as $dat) {
            $artistDetail = $artist->getArtistById($dat['artist']);
            $genreDetail = $genre->getGenreById($dat['genre']);
        ?>
<li class="song-view-list justify-between items-center" onclick="setSong(<?php echo $dat['id']; ?>)">
<span class="block"><?php echo $dat['name']; ?></span>
<span class="block"><?php echo $artistDetail['name'];?></span>
<span class="block"><?php echo $genreDetail['name']; ?></span>
</li>
<?php
        }
        ?>
        </ul>
      
    </div>
  </section>
    <section class="music-player">
    <?php 
    include_once('./music_player.php');
    ?>
  </section>
</main>
<?php
include_once("./footer.php");
?>