<?php
include_once("./check_login.php");
include_once("./header.php");

include_once('./function.php');

//declaration of the objects needed for the page
$genre = new Genre();

$genre_group = $genre->getAllGenres();

?>
<main class="music_wrapper" id="main_music_wrapper">
  <nav class="navigation"><?php include_once("./music_nav.php"); ?> </nav>
  <section class="main_wrapper" aria-label="container">
    <div class="flex justify-between items-center">
      <h1 class="poppins greetings text-size32"> Genres </h1>
      <input id="genre_searchbar" type="text" class="search-bar" placeholder="Search..." style="margin-right:0!important;">
    </div>
    <div class="home-song-container snap-inline">

      <div class="song-container" id="genres_wrapper_home">
        <?php foreach ($genre_group as $group) : ?>

          <a href="./genre_page.php?id=<?php echo $group["id"]; ?>" class="song-wrapper">
            <img class="song-image" src="./assets/images/<?php echo (!empty($group) && $group['filename']) ? $group['filename'] : "default_music_icon.jpg"; ?>" alt="<?php echo $group['name']; ?>" />
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