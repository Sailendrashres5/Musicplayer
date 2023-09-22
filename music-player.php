<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Music Player | CodingNepal</title>
  <!--   <link rel="stylesheet" href="index.css">
 -->
  <link rel="stylesheet" type="text/css" href="./tonado.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">


</head>

<body>
  <div class="sidebar">
    <header class="main-header">
      <a href="/" class="brand-logo">
        <div class="main-logo"></div>
      </a>
    </header>
    <div class="items">
      <ul>
        <li>Your Library</li>
        <li>Liked Songs</li>
        <li>Playlist</li>
        <li>Artists</li>
        <li>Albums</li>
      </ul>
    </div>
  </div>
  <div class="wrapper">
    <div class="song-bar">
      <div class="img-area">
        <img src="" alt="">
      </div>
      <div class="song-details">
        <p class="name"></p>
        <p class="artist"></p>
      </div>
      <div class="progress-area">
        <div class="progress-bar">
          <audio id="musicPlayer" class="music_player">
            <source src="" type="audio/mpeg" id="music_source">
          </audio>
        </div>
        <div class="song-timer">
          <span class="current-time">0:00</span>
          <span class="max-duration">0:00</span>
        </div>
      </div>
      <div class="controls">
        <i id="repeat-plist" class="material-icons" title="Playlist looped">repeat</i>
        <i id="prev" class="material-icons">skip_previous</i>
        <div class="play-pause">
          <i class="material-icons play">play_arrow</i>
        </div>
        <i id="next" class="material-icons">skip_next</i>
        <i id="more-music" class="material-icons">queue_music</i>
      </div>
      <div class="music-list">
        <div class="header">
          <div class="row">
            <i class="list material-icons">queue_music</i>
            <span>Music list</span>
          </div>
          <i id="close" class="material-icons">close</i>
        </div>
        <ul>
          <!-- here li list are coming from js -->
        </ul>
      </div>
    </div>
  </div>
  <script src="./assets/js/music.js"></script>


  <script src="https://kit.fontawesome.com/fe21ab8811.js" crossorigin="anonymous"></script>

</body>

</html>