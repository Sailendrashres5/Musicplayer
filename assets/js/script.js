window.addEventListener("load", function () {
  // Check if the login_form ID is present
  var loginForm = document.getElementById("login_form");

  if (loginForm) {
    // The login_form ID is present
    // Perform actions specific to the login page

    // Example: Add an event listener to the login form
    loginForm.addEventListener("submit", async function (event) {
      event.preventDefault();
      let email = document.getElementById("email");
      let password = document.getElementById("password");
      let error_msg = document.getElementsByClassName("Error");
      if (email && password) {
        let response = await login(email.value, password.value);
        if (response) {
          window.location.href = "./index.php";
        } else {
          if (error_msg.length !== 0) {
            for (i = 0; i < error_msg.length; i++) {
              error_msg[i].style.display = "block";
            }
          }
        }
      }
      // Perform login form submission logic
    });
  }

  var signUp = document.getElementById("signup_form");

  if (signUp) {
    // The login_form ID is present
    // Perform actions specific to the login page

    // Example: Add an event listener to the login form
    signUp.addEventListener("submit", async function (event) {
      event.preventDefault();
      let name = document.getElementById("fullname");
      let email = document.getElementById("email");
      let password = document.getElementById("password");
      let cpassword = document.getElementById("confirm_password");
      let error_msg = document.getElementsByClassName("Error");
      if (email && password && name) {
        let response = await signup(
          name.value,
          email.value,
          password.value,
          cpassword.value
        );
        if (response) {
          window.location.href = "./login.php";
        } else {
          if (error_msg.length !== 0) {
            for (i = 0; i < error_msg.length; i++) {
              error_msg[i].style.display = "block";
            }
          }
        }
      }
      // Perform login form submission logic
    });
  }
  //admin dashboard user table
  var user_table = document.getElementById("user_tbl");
  if (user_table) {
    var user_table_body = document.getElementById("user_tbl_data");
    console.log(user_table_body);
    Promise.resolve(getAllUsers()).then((dat) => {
      dat.map((e, index) => {
        user_table_body.innerHTML += `
        <tr>
          <td class="px-2 py-1">${index + 1}</td>
          <td class="px-2 py-1">${e.name}</td>
          <td class="px-2 py-1">${e.email}</td>
          <td class="px-2 py-1">${e.admin === 1 ? true : false}</td>
          

          <td class="px-2 py-1"><button type="button" class="deleteBtn" aria-id="${
            e.id
          }">Delete</button></td>
        </tr>
      `;
      });

      //delete user

      var deleteBtn = document.getElementsByClassName("deleteBtn");
      Array.prototype.forEach.call(deleteBtn, function (element) {
        element.addEventListener("click", async function (e) {
          let id = e.target.getAttribute("aria-id");
          if (window.confirm("Are you sure you want to delete")) {
            let response = await deleteUser(id);
            if (response) {
              window.location.reload();
            } else {
              window.alert("Error deleting user");
            }
          }
        });
      });
    });
  }

  //edit user

  var update_user = document.getElementById("update_user");
  if (update_user) {
    let id = update_user.getAttribute("aria-id");
    let password = document.getElementById("password");
    let name = document.getElementById("fullname");
    let email = document.getElementById("email");
    let cpassword = document.getElementById("confirm_password");
    let error_msg = document.getElementsByClassName("Error");
    Promise.resolve(getUserById(id)).then((dat) => {
      name.value = dat.name;
      email.value = dat.email;
    });
    update_user.addEventListener("submit", async function (e) {
      e.preventDefault();
      let response = await updateUser(
        id,
        name.value,
        email.value,
        password.value,
        cpassword.value
      );
      if (response.success) {
        window.location.href = "./admin.php";
      } else {
        console.error("User Update Failed.");
        window.alert("Failed");
        if (error_msg.length !== 0) {
          for (i = 0; i < error_msg.length; i++) {
            error_msg[i].style.display = "block";
          }
        }
      }
    });
  }

  //do not touch this one

  //artist table
  var artist_table = document.getElementById("artist_tbl");
  if (artist_table) {
    var artist_table_body = document.getElementById("artist_tbl_data");
    Promise.resolve(getAllArtists()).then((dat) => {
      dat.map((e, index) => {
        artist_table_body.innerHTML += `
        <tr>
          <td class="px-2 py-1">${index + 1}</td>
          <td class="px-2 py-1">${e.name}</td>
          <td class="px-2 py-1"><a href="./admin_edit_artist.php?id=${
            e.id
          }" class="text-white"/>Edit</a></td>
          <td class="px-2 py-1"><button type="button" class="deleteBtn" aria-id="${
            e.id
          }">Delete</button></td>
        </tr>
      `;
      });
      var deleteBtn = document.getElementsByClassName("deleteBtn");
      Array.prototype.forEach.call(deleteBtn, function (element) {
        element.addEventListener("click", async function (e) {
          let id = e.target.getAttribute("aria-id");
          if (window.confirm("Are you sure you want to delete")) {
            let response = await deleteArtist(id);
            if (response) {
              window.location.reload();
            } else {
              window.alert("Error deleting Artist");
            }
          }
        });
      });
    });
  }
});

//songs table
var song_table = document.getElementById("song_tbl");
if (song_table) {
  var song_table_body = document.getElementById("song_tbl_data");
  Promise.resolve(getAllSongs()).then((dat) => {
    dat.map((e, index) => {
      song_table_body.innerHTML += `
        <tr>
          <td class="px-2 py-1">${index + 1}</td>
          <td class="px-2 py-1">${e.name}</td>
          <td class="px-2 py-1">${e.artist}</td>
          <td class="px-2 py-1">${e.genre}</td>
          <td class="px-2 py-1"><a href="./admin_edit_song.php?id=${
            e.id
          }" class="text-white"/>Edit</a></td>
          <td class="px-2 py-1"><button type="button" class="deleteBtn" aria-id="${
            e.id
          }">Delete</button></td>
        </tr>
      `;
    });
    var deleteBtn = document.getElementsByClassName("deleteBtn");
    Array.prototype.forEach.call(deleteBtn, function (element) {
      element.addEventListener("click", async function (e) {
        let id = e.target.getAttribute("aria-id");
        if (window.confirm("Are you sure you want to delete ?")) {
          let response = await deleteSong(id);
          if (response) {
            window.location.reload();
          } else {
            window.alert("Error deleting Song");
          }
        }
      });
    });
  });
}

//genre table
var genre_table = document.getElementById("genre_tbl");
if (genre_table) {
  var genre_table_body = document.getElementById("genre_tbl_data");
  Promise.resolve(getAllGenres()).then((dat) => {
    dat.map((e, index) => {
      genre_table_body.innerHTML += `
        <tr>
          <td class="px-2 py-1">${index + 1}</td>
          <td class="px-2 py-1">${e.name}</td>
          <td class="px-2 py-1"><a href="./admin_edit_genre.php?id=${
            e.id
          }" class="text-white"/>Edit</a></td>
          <td class="px-2 py-1"><button type="button" class="deleteBtn" aria-id="${
            e.id
          }">Delete</button></td>
        </tr>
      `;
    });
    var deleteBtn = document.getElementsByClassName("deleteBtn");
    Array.prototype.forEach.call(deleteBtn, function (element) {
      element.addEventListener("click", async function (e) {
        let id = e.target.getAttribute("aria-id");
        if (window.confirm("Are you sure you want to delete ?")) {
          let response = await deleteGenre(id);
          if (response) {
            window.location.reload();
          } else {
            window.alert("Error deleting Genre");
          }
        }
      });
    });
  });
}

//select genres
let addSongs_form = document.getElementById("add_song");
var editSongs_form = document.getElementById("edit_song");

function bindingSongData(type) {
  var song_name = document.getElementById("song_name").value;
  var song_file = document.getElementById("song_file").files[0];
  if (song_name.length === 0) {
    window.alert("Please fill the song name");
    return false;
  }
  if (select_artist.value.length === 0) {
    window.alert("Please Select The Artist");
    return false;
  }
  if (select_genre.value.length === 0) {
    window.alert("Please Select The Genre");
    return false;
  }

  // Check if a file has been selected
  if (!song_file) {
    window.alert("Please select a file");
    return false;
  }

  let form_data = new FormData();
  if (type === "edit_song_detail") {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");
    if (!id) {
      return false;
    }
    form_data.append("id", id);
  }
  form_data.append(type, true);
  form_data.append("song_name", song_name);
  form_data.append("song_genre", select_genre.value);
  form_data.append("song_artist", select_artist.value);
  form_data.append("song_file", song_file);
  return form_data;
}

if (addSongs_form || editSongs_form) {
  var select_genre = document.getElementById("song_genre");
  var select_artist = document.getElementById("song_artist");
  getAllGenres()
    .then((e) => {
      e.map(
        (dat) =>
          (select_genre.innerHTML += `
        <option value="${dat.id}">${dat.name}</option>
        `)
      );
    })
    .catch((err) => console.error(err));
  getAllArtists()
    .then((e) => {
      e.map(
        (dat) =>
          (select_artist.innerHTML += `<option value="${dat.id}">${dat.name}</option>`)
      );
    })
    .catch((err) => console.error(err));

  if (addSongs_form) {
    //form listenerfor the addsongs
    addSongs_form.addEventListener("submit", (dat) => {
      dat.preventDefault();

      let data = bindingSongData("add_song_detail");
      if (data) {
        song_details(data)
          .then((res) => {
            if (res.success) {
              window.alert("Song added successfully");
            } else {
              window.ErrorEvent("Error Adding the song");
            }
          })
          .catch((err) => console.error(err));
      } else {
        window.alert("Failed to add");
      }
    });
  }
  if (editSongs_form) {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");
    if (!id) {
      window.location.href = `/spotify/admin.php`;
    }
    getSongsById(id)
      .then((dat) => {
        var songName = document.getElementById("song_name");

        songName.value = dat.name;
        select_artist.value = dat.artist;
        select_genre.value = dat.genre;
      })
      .catch((err) => console.error(err));
    //event listener for the editsong section
    editSongs_form.addEventListener("submit", (dat) => {
      dat.preventDefault();

      let data = bindingSongData("edit_song_detail");

      song_details(data)
        .then((res) => {
          if (res.success) {
            window.alert("Song Updated successfully");
          } else {
            window.ErrorEvent("Error Updating the song");
          }
        })
        .catch((err) => console.error(err));
    });
  }
}

//Artist form for admin
function bindArtistDetails(type) {
  var name = document.getElementById("artist_name").value;
  var genre_name = document.getElementById("genre").value;
  var avatar = document.getElementById("artist_avatar").files[0];
  var background = document.getElementById("background").files[0];

  if (name.length === 0) {
    window.alert("Enter the name of the artist");
    return;
  }
  if (genre_name.length === 0) {
    window.alert("Enter the genre of the artist");
    return;
  }

  let form_data = new FormData();
  if (avatar) {
    if (avatar.type.includes("image/")) {
      form_data.append("avatar", avatar);
    } else {
      window.alert("File type not supported");
      return;
    }
  }

  if (background) {
    if (background.type.includes("image/")) {
      form_data.append("background", background);
    } else {
      window.alert("File type not supported");
      return;
    }
  }
  if(type === "edit_artist_detail"){
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");
    if (!id) {
      window.location.href = `/spotify/admin.php`;
    }
    form_data.append('id',id);
  }
  form_data.append(type, true);
  form_data.append("name", name);
  form_data.append("genre", genre_name);
  return form_data;
}
var add_artist_form = document.getElementById("add_artist_form");
var edit_artist_form = document.getElementById("edit_artist_form");

if (add_artist_form || edit_artist_form) {
  var genre = document.getElementById("genre");
  getAllGenres()
    .then((dat) => {
      dat.map(
        (e) => (genre.innerHTML += `<option value="${e.id}">${e.name}</option>`)
      );
    })
    .catch((err) => console.error(err));
  if (add_artist_form) {
    //adding event listener for the form for adding the artist
    add_artist_form.addEventListener("submit", (form) => {
      form.preventDefault();

      let data = bindArtistDetails("add_artist_detail");
      artist_details(data)
        .then((dat) => {
          if (dat.success) {
            window.alert("Data added successfully");
          } else {
            window.alert("Failed to upload data");
            console.error(dat.message);
          }
        })
        .catch((err) => console.error(err));
    });
  }

  if (edit_artist_form) {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");
    if (!id) {
      window.location.href = `/spotify/admin.php`;
    }
    getArtistById(id)
      .then((dat) => {
  var name = document.getElementById("artist_name");
        name.value = dat.name;
        genre.value = dat.genre;
      })
      .catch((err) => console.log(err));

    edit_artist_form.addEventListener("submit", (form) => {
      form.preventDefault();

      let data = bindArtistDetails("edit_artist_detail");
      artist_details(data)
        .then((dat) => {
          console.log(dat);
        })
        .catch((err) => console.error(err));
    });
  }
}
//end of artist form 

//this is for search sections

var searchSong = document.getElementById("home_searchbar");

function divideArrayInto8Chunks(array) {
  const chunkSize = 8;
  const result = [];

  for (let i = 0; i < array.length; i += chunkSize) {
    const chunk = array.slice(i, i + chunkSize);
    result.push(chunk);
  }

  return result;
}

if (searchSong) {
  searchSong.addEventListener("keyup", (e) => {
    let searchValue = e.target.value;

    search_song(searchValue)
      .then((dat) => {
        if (dat) {
          let songsData = divideArrayInto8Chunks(dat);
          var songWrapper = document.getElementById("homepage_song_wrapper");
          songWrapper.innerHTML = ""; // Clear the previous content
          songsData.reverse().forEach(async (val) => {
            let songsHTML = await Promise.all(
              val.map(async (values) => {
                let artistDetails = await getArtistById(values.artist);
                return `
                      <div class="song-wrapper">
                          <img class="song-image" src="./assets/images/${
                            artistDetails.avatar
                              ? artistDetails.avatar
                              : "default_music_icon.jpg"
                          }" alt="${values.name}" onclick="setSong(${
                  values.id
                })"/>
                          <header onclick="setSong(${values.id})">${
                  values.name
                }</header>
                          <header class="text-size14 flex justify-between" >
                          <span onclick="setSong(${values.id})">${
                  artistDetails.name
                }</span><i class="fas fa-heart removefavorite" onclick="toggle(this)" id="removefavorite" value="add" name="add" data-id="${
                  values.id
                }"></i></header>
                      </div>
                  `;
              })
            );
            songWrapper.innerHTML += `
                  <div class="song-container">
                      ${songsHTML.join("")}
                  </div>
              `;
          });
        }
      })
      .catch((error) => console.error(error));
  });
}

var genre_searchElement = document.getElementById("genre_searchbar");

if (genre_searchElement) {
  genre_searchElement.addEventListener("keyup", function (e) {
    let searchValue = e.target.value;
    var wrapper = document.getElementById("genres_wrapper_home");
    wrapper.innerHTML = "";

    search_genre(searchValue)
      .then((res) => {
        res.forEach((dat) => {
          wrapper.innerHTML += `
        <a href="./genre_page.php?id=${dat.id}" class="song-wrapper">
            <img class="song-image" src="./assets/images/${
              dat.filename && dat.filename !== "0"
                ? dat.filename
                : "default_music_icon.jpg"
            }" alt="${dat.name}" />
            <header class="text-white">${dat.name}</header>
          </a>
        `;
        });
      })
      .catch((err) => console.log(err));
  });
}

var artist_searchElement = document.getElementById("artist_searchbar");

if (artist_searchElement) {
  artist_searchElement.addEventListener("keyup", function (e) {
    let searchValue = e.target.value;
    var wrapper = document.getElementById("artist_wrapper_home");
    wrapper.innerHTML = "";

    search_artist(searchValue)
      .then((res) => {
        res.forEach((dat) => {
          wrapper.innerHTML += `
        <a href="./artist_page.php?id=${dat.id}" class="song-wrapper">
            <img class="song-image" src="./assets/images/${
              dat.avatar && dat.avatar !== "0"
                ? dat.avatar
                : "default_music_icon.jpg"
            }" alt="${dat.name}" />
            <header class="text-white">${dat.name}</header>
          </a>
        `;
        });
      })
      .catch((err) => console.log(err));
  });
}

var artist_genre_searchElement = document.getElementById("genre_artist_search");

if (artist_genre_searchElement) {
  artist_genre_searchElement.addEventListener("keyup", function (e) {
    let searchValue = e.target.value;
    var wrapper = document.getElementById("genre_artist_wrapper");
    wrapper.innerHTML = "";
    const url = new URL(window.location.href);

    // Get a specific parameter value
    const id = url.searchParams.get("id");

    search_artist_genre(id, searchValue)
      .then((res) => {
        res.forEach((dat) => {
          wrapper.innerHTML += `
        <a href="./artist_page.php?id=${dat.id}" class="song-wrapper">
            <img class="song-image" src="./assets/images/${
              dat.avatar && dat.avatar !== "0"
                ? dat.avatar
                : "default_music_icon.jpg"
            }" alt="${dat.name}" />
            <header class="text-white">${dat.name}</header>
          </a>
        `;
        });
      })
      .catch((err) => console.log(err));
  });
}

var song_artist_searchElement = document.getElementById("song_artist_search");

if (song_artist_searchElement) {
  song_artist_searchElement.addEventListener("keyup", function (e) {
    let searchValue = e.target.value;
    var wrapper = document.getElementById("song_artist_wrapper");
    wrapper.innerHTML = "";
    const url = new URL(window.location.href);

    // Get a specific parameter value
    const id = url.searchParams.get("id");

    search_song_artist(id, searchValue)
      .then((res) => {
        console.log(res);
        res.forEach((dat) => {
          wrapper.innerHTML += `
        <div class="song-wrapper" onclick="setSong(${dat.id})">

                        <li style="padding-left: 30px;"><header>${dat.name}</header></li>

                    </div>
        `;
        });
      })
      .catch((err) => console.log(err));
  });
}

//favorite button

function toggle(e) {
  const element = e;
  let id = e.getAttribute("data-id");
  if (element.style.color === "grey") {
    element.style.color = "#ff3252";
    add_favorite(id).catch((error) => console.error(error));

  } else {
    element.style.color = "grey";
    remove_favorite(id).catch((error) => console.error(error));

  }
}


// start of the genre


var add_genre_form = document.getElementById("add_genre_form");
var edit_genre_form = document.getElementById("edit_genre_form");

function bindingGenreData(type){
  var genre_name = document.getElementById("genre_name");
  var genre_avatar = document.getElementById("genre_avatar");

  if(!genre_name.value && String(genre_name.value).length===0){
    window.alert("Please fill the genre name");
    return ;
  }
  const form_data = new FormData();

  if(type === "genre_edit_form"){
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");
    if (!id) {
      window.location.href = `/admin.php`;
    }
    form_data.append('id',id);
  }

  if(genre_avatar.files[0]){
    form_data.append('genre_avatar',genre_avatar.files[0]);
  }
  form_data.append('genre_name',genre_name.value);
  form_data.append(type,true);

  return form_data;
}

if (add_genre_form || edit_genre_form) {
  
  //checking if the form element exists
  if(add_genre_form){
    //adding event listener 
    add_genre_form.addEventListener("submit",async(e)=>{
      e.preventDefault();
  
      let data = bindingGenreData("genre_add_form");

      let response =await genre_details(data);
      if(response.success){
        window.alert('data added successfully');
        e.target.reset();
      }else{
        console.error(response.message);
      }

    })
    //end of event listener
  }
  //end of condition checking
  if(edit_genre_form){

    var genre_name = document.getElementById("genre_name");
  var genre_avatar = document.getElementById("genre_avatar");

  const urlParams = new URLSearchParams(window.location.search);
  const id = urlParams.get("id");
  if (!id) {
    window.location.href = `/spotify/admin.php`;
  }

  getGenresById(id).then(dat=>genre_name.value=dat.name).catch(err=>console.log(err));

    edit_genre_form.addEventListener('submit',async(e)=>{
      e.preventDefault();

      let data = bindingGenreData('genre_edit_form');

      let response = await genre_details(data);
      if(response.success){
        window.alert('data added successfully');
        window.location.reload();
      }else{
        console.error(response.message);
      }
    })
  }
}