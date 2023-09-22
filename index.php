<?php
include_once("./check_login.php");
include_once("./header.php");

include_once('./function.php');

include_once('./head.php');

//declaration of the objects needed for the page
$song = new Song();
$artist = new Artist();
$genre = new Genre();

$song_data_fetch = $song->getAllSongs();
$algorithm = new BayesianMonthlyListenersCalculator($song_data_fetch);
$song_data = $algorithm->calculateListeners();
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
      <h1 class="poppins greetings text-size32"> Greetings, <?php echo (isset($_SESSION['user_name'])) ? $_SESSION['user_name'] : ''; ?></h1>
      <input id="home_searchbar" type="text" class="search-bar" placeholder="Search...">
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fa-regular fa-user" style=" color:#ffffff;"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end  dropdown-menu-dark">
          <?php
          if ($_SESSION['user_admin']) {
          ?>
            <li>
              <a href="./admin.php" class="dropdown-item text-center">
                Dashboard
              </a>
            </li>

          <?php
          }
          ?>
          <!-- <li>
            <a href="./profile.php" class="dropdown-item text-center w-100">
              Profile
            </a>
          </li> -->
          <li>
            <hr class="dropdown-divider" />
          </li>
          <li>
            <a href="./logout.php" class="dropdown-item text-center text-white">
              Log out
            </a>
          </li>
        </ul>
      </div>

    </div>
    <div class="home-song-container snap-inline" id="homepage_song_wrapper">

      <?php foreach ($song_groups as $group) : ?>
        <div class="song-container">
          <?php foreach ($group as $song) :
            $artistDetail = $artist->getArtistById($song['artist']);
          ?>
            <div class="song-wrapper">
              <img class="song-image" onclick="setSong(<?php echo $song['id']; ?>)" src="./assets/images/<?php echo (!empty($artistDetail) && $artistDetail['avatar']) ? $artistDetail['avatar'] : "default_music_icon.jpg"; ?>" alt="<?php echo $song['name']; ?>" />
              <header onclick="setSong(<?php echo $song['id']; ?>)"><?php echo $song['name']; ?></header>


              <header class="text-size14 flex justify-between" >
              <span onclick="setSong(<?php echo $song['id']; ?>)"><?php echo $artistDetail['name']; ?></span>
             
                  <i class="fas fa-heart removefavorite" onclick="toggle(this)" id="removefavorite" value="add" name="add" data-id="<?php echo $song['id']; ?>"></i>
            
            </header>
        </div>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
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