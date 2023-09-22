const wrapper = document.querySelector(".wrapper"),
  musicImg = wrapper.querySelector(".img-area img"),
  musicName = wrapper.querySelector(".song-details .name"),
  musicArtist = wrapper.querySelector(".song-details .artist"),
  playPauseBtn = wrapper.querySelector(".play-pause"),
  prevBtn = wrapper.querySelector("#prev"),
  nextBtn = wrapper.querySelector("#next"),
  mainAudio = wrapper.querySelector("#main-audio"),
  progressArea = wrapper.querySelector(".progress-area"),
  progressBar = progressArea.querySelector(".progress-bar"),
  musicList = wrapper.querySelector(".music-list"),
  moreMusicBtn = wrapper.querySelector("#more-music");

  var volume_btn = document.getElementById("volume_btn");

  var background_wrapper = document.getElementById("main_music_wrapper");

  if(volume_btn){
    volume_btn.addEventListener("click",(e)=>{
     const volumeClass= e.target.classList;
     if(volumeClass.contains("fa-volume-high")){
      e.target.classList.remove("fa-volume-high");
      e.target.classList.add("fa-volume-mute");
      mainAudio.muted=true;
     }else{
      e.target.classList.remove("fa-volume-mute");
      e.target.classList.add("fa-volume-high");
      mainAudio.muted=false;
     }
    })
  }

let allMusic = [];

getAllSongs().then((dat)=>{
    allMusic = dat
}).catch(err=>console.error(err))

let musicIndex = Math.floor(Math.random() * allMusic.length) + 1;
let isMusicPaused = true;

// Load music when the page is loaded
window.addEventListener("load", () => {
  loadMusic(musicIndex);
  playingSong();
});

function setSong(id){
    let findIndexOf = allMusic.findIndex(dat=>dat.id===id);
    loadMusic(findIndexOf+1)
    playMusic()
}

// Load music function
function loadMusic(indexNumb) {
  getArtistById(allMusic[indexNumb - 1].artist).then(dat=>{
    musicName.innerText = allMusic[indexNumb - 1].name;
    musicArtist.innerText = dat.name;
    musicImg.src = `/spotify/assets/images/${dat.avatar}`;
    mainAudio.src = `/spotify/assets/songs/${allMusic[indexNumb - 1].filename}`;
    mainAudio.setAttribute("data-music-id",allMusic[indexNumb-1].id)  
    getArtistById(allMusic[indexNumb-1].artist).then((res)=>{
      if(res.background){
        background_wrapper.style.backgroundImage = `url('./assets/images/${res.background}')`;
      }
    })

  }).catch(err=>console.error(err))
}

// Play music function
function playMusic() {
  wrapper.classList.add("paused");
  playPauseBtn.querySelector("i").innerText = "pause";
  
  setTimeout(()=>mainAudio.play(),1000)
}

// Pause music function
function pauseMusic() {
  wrapper.classList.remove("paused");
  playPauseBtn.querySelector("i").innerText = "play_arrow";
  mainAudio.pause();
}

// Prev music function
function prevMusic() {
  musicIndex--;
  musicIndex < 1 ? (musicIndex = allMusic.length) : (musicIndex = musicIndex);
  loadMusic(musicIndex);
  playMusic();
  playingSong();
}


// Next music function
function nextMusic() {
  musicIndex++;
  musicIndex > allMusic.length ? (musicIndex = 1) : musicIndex;
  loadMusic(musicIndex);
  playMusic();
  playingSong();
}

function loadAndPlayMusic(randIndex){
  if(randIndex > allMusic.length){
    randIndex -=1; 
  }else if(randIndex < 0){
    randIndex = 0;
  }
  loadMusic(randIndex);
  playMusic();

}

// Play or pause button event
playPauseBtn.addEventListener("click", () => {
  const isMusicPlay = wrapper.classList.contains("paused");
  isMusicPlay ? pauseMusic() : playMusic();
  playingSong();
});

// Prev music button event
prevBtn.addEventListener("click", () => {
  prevMusic();
});

// Next music button event
nextBtn.addEventListener("click", () => {
  nextMusic();
});

// Update progress bar width according to music current time
mainAudio.addEventListener("timeupdate", (e) => {
  const currentTime = e.target.currentTime;
  const duration = e.target.duration;
  let progressWidth = (currentTime / duration) * 100;
  progressBar.style.width = `${progressWidth}%`;

  let musicCurrentTime = wrapper.querySelector(".current-time"),
    musicDuartion = wrapper.querySelector(".max-duration");
  mainAudio.addEventListener("loadeddata", () => {
    let mainAdDuration = mainAudio.duration;
    let totalMin = Math.floor(mainAdDuration / 60);
    let totalSec = Math.floor(mainAdDuration % 60);
    if (totalSec < 10) {
      totalSec = `0${totalSec}`;
    }
    musicDuartion.innerText = `${totalMin}:${totalSec}`;
  });

  let currentMin = Math.floor(currentTime / 60);
  let currentSec = Math.floor(currentTime % 60);
  if (currentSec < 10) {
    currentSec = `0${currentSec}`;
  }
  musicCurrentTime.innerText = `${currentMin}:${currentSec}`;
});

// Update playing song currentTime on according to the progress bar width
progressArea.addEventListener("click", (e) => {
  let progressWidth = progressArea.clientWidth;
  let clickedOffsetX = e.offsetX;
  let songDuration = mainAudio.duration;

  mainAudio.currentTime = (clickedOffsetX / progressWidth) * songDuration;
  playMusic();
  playingSong();
});

// Change loop, shuffle, repeat icon onclick
const repeatBtn = wrapper.querySelector("#repeat-plist");
repeatBtn.addEventListener("click", () => {
  let getText = repeatBtn.innerText;
  switch (getText) {
    case "repeat":
      repeatBtn.innerText = "repeat_one";
      repeatBtn.setAttribute("title", "Song looped");
      break;
    case "repeat_one":
      repeatBtn.innerText = "shuffle";
      repeatBtn.setAttribute("title", "Playback shuffled");
      break;
    case "shuffle":
      repeatBtn.innerText = "repeat";
      repeatBtn.setAttribute("title", "Playlist looped");
      break;
  }
});

// Code for what to do after song ended
mainAudio.addEventListener("ended", () => {
  let getText = repeatBtn.innerText;
  addCountToSong(mainAudio.getAttribute("data-music-id"));
  switch (getText) {
    case "repeat":
      nextMusic();
      break;
    case "repeat_one":
      mainAudio.currentTime = 0;
      playMusic();
      break;
    case "shuffle":
      let randIndex;
      do {
        randIndex = Math.floor(Math.random() * allMusic.length);
      } while (musicIndex === randIndex);
      loadAndPlayMusic(randIndex);
      break;
  }
});

// Show music list onclick of music icon
moreMusicBtn.addEventListener("click", () => {
  musicList.classList.toggle("show");
});
closemoreMusic.addEventListener("click", () => {
  moreMusicBtn.click();
});

const ulTag = wrapper.querySelector("ul");
for (let i = 0; i < allMusic.length; i++) {
  let liTag = `<li li-index="${i + 1}">
                <div class="row">
                  <span>${allMusic[i].name}</span>
                  <p>${allMusic[i].artist}</p>
                </div>
                <span id="${allMusic[i].src}" class="audio-duration">3:40</span>
                <audio class="${allMusic[i].src}" src="songs/${allMusic[i].src}.mp3"></audio>
              </li>`;
  ulTag.insertAdjacentHTML("beforeend", liTag);

  let liAudioDuartionTag = ulTag.querySelector(`#${allMusic[i].src}`);
  let liAudioTag = ulTag.querySelector(`.${allMusic[i].src}`);
  liAudioTag.addEventListener("loadeddata", () => {
    let duration = liAudioTag.duration;
    let totalMin = Math.floor(duration / 60);
    let totalSec = Math.floor(duration % 60);
    if (totalSec < 10) {
      totalSec = `0${totalSec}`;
    }
    liAudioDuartionTag.innerText = `${totalMin}:${totalSec}`;
    liAudioDuartionTag.setAttribute("t-duration", `${totalMin}:${totalSec}`);
  });
}

function playingSong() {
  const allLiTag = ulTag.querySelectorAll("li");

  for (let j = 0; j < allLiTag.length; j++) {
    let audioTag = allLiTag[j].querySelector(".audio-duration");

    if (allLiTag[j].classList.contains("playing")) {
      allLiTag[j].classList.remove("playing");
      let adDuration = audioTag.getAttribute("t-duration");
      audioTag.innerText = adDuration;
    }

    if (allLiTag[j].getAttribute("li-index") == musicIndex) {
      allLiTag[j].classList.add("playing");
      audioTag.innerText = "Playing";
    }

    allLiTag[j].setAttribute("onclick", "clicked(this)");
  }
}

function clicked(element) {
  let getLiIndex = element.getAttribute("li-index");
  musicIndex = getLiIndex;
  loadMusic(musicIndex);
  playMusic();
  playingSong();
}
