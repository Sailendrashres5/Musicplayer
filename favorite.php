<?php
include_once("./check_login.php");
include_once("./header.php");

include_once('./function.php');

$id = $_SESSION["user_id"];

//declaration of the objects needed for the page

$favorite= new Favorite($id);
$song_group = $favorite->getFavorite();

?>
<main class="music_wrapper" id="main_music_wrapper">
    <nav class="navigation"><?php include_once("./music_nav.php"); ?> </nav>
    <section class="main_wrapper" aria-label="container">
        <div class="flex justify-between items-center">
            <h1 class="poppins greetings text-size32">Your Liked Songs
      
    </h1>
        </div>
        <div class="home-song-container snap-inline">

            <ol type="1" class="artist-song-container" id="song_artist_wrapper">
                <?php foreach ($song_group as $group) :
                   

                ?>

                    <div class="song-wrapper flex justify-between" >

                    <li style="padding-left: 30px" onclick="setSong(<?php echo $group['id']; ?>)"><header><?php echo $group['name']; ?></header> </li>
                    <button onclick="toggle(this)" id="removefavorite" class="removefavorite" value="add" name="add" data-id="<?php echo $group['id']; ?>" style="color:#ff3252;"><i class="fas fa-heart"></i></button>


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