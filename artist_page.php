<?php
include_once("./check_login.php");
include_once("./header.php");

include_once('./function.php');

$id = $_GET['id'];

//declaration of the objects needed for the page
$song = new Song();
$artist = new Artist();

$song_group = $song->getSongsByArtist($id);

$artist_data = $artist->getArtistById($id);


$artist_data_fetch = $artist->getAllArtists();
$algorithm = new BayesianMonthlyListenersEstimator();
$artist_algorithm_data = $algorithm->estimateAverageMonthlyListeners();



?>
<main class="music_wrapper" id="main_music_wrapper" 
<?php 
if($artist_data['background']){
    echo "style=\"background-image:url('./assets/images/".$artist_data['background']."')\""; 
}
?>
>
    <nav class="navigation"><?php include_once("./music_nav.php"); ?> </nav>
    <section class="main_wrapper" aria-label="container">
        <div class="flex justify-between items-center">
            <h1 class="poppins greetings text-size32"><?php echo $artist_data['name']; ?>
        <span class="block text-size18"><?php
        foreach($artist_algorithm_data as $val){
            if($val['id'] == $artist_data['id']){
                echo $val["average"];
            }
        }
        ?> Total Listeners</span>
      
    </h1>
            <input id="song_artist_search" type="text" class="search-bar" placeholder="Search..." style="margin-right:0!important;">
        </div>
        <div class="home-song-container snap-inline">

            <ol type="1" class="artist-song-container" id="song_artist_wrapper">
                <?php foreach ($song_group as $group) :
                    $artistDetail = $artist->getArtistById($group['artist']);

                ?>

                    <div class="song-wrapper flex justify-between" onclick="setSong(<?php echo $group['id']; ?>)">

                    <li style="padding-left: 30px"><header><?php echo $group['name']; ?></header> </li>
                    <button style="padding-bottom: 25x;" onclick="toggle(this)" id="removefavorite" class="removefavorite" value="add" name="add"><i class="fas fa-heart"></i></button>


                </div>
                <?php endforeach; ?>
            </ol>
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