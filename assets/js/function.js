//default location of the api file path or the action page that has been will be used throught the document
const actionURI = "/spotify/action.php";
// function for login that takes email and password for verification
async function login(email, password) {
  if (email.length === 0) {
    return false;
  }
  if (password.length === 0) {
    return false;
  }
  const formData = new FormData();
  formData.append("email", email);
  formData.append("password", password);
  formData.append("login", true);

  try {
    let response = await fetch(`${actionURI}`, {
      method: "POST",
      body: formData,
    });

    if (response.ok) {
      // Request successful, parse the response data
      let data = await response.json();
      if (data.success) {
        // Login successful
        return true;
      } else {
        // Login failed
        return false;
      }
    } else {
      // Request failed with non-2xx status
      console.error("Login request failed with status: " + response.status);
      response = await response.text();
      return false;
    }
  } catch (error) {
    // Error occurred during the request
    console.error("Login request failed with error:", error);
    return false;
  }
}

//Creating User using name, email, password and confirm password
async function signup(name, email, password, cpassword) {
  if (email.length === 0) {
    return false;
  }
  if (password.length === 0) {
    return false;
  }
  if (cpassword.length === 0) {
    return false;
  }
  if (name.length === 0) {
    return false;
  }
  const formData = new FormData();
  formData.append("email", email);
  formData.append("name", name);
  formData.append("password", password);
  formData.append("cpassword", cpassword);
  formData.append("signup", true);

  try {
    let response = await fetch(`${actionURI}`, {
      method: "POST",
      body: formData,
    });
    if (response.ok) {
      // Request successful, parse the response data
      let data = await response.json();

      if (data.success) {
        // Login successful
        return true;
      } else {
        // Login failed
        return false;
      }
    } else {
      // Request failed with non-2xx status
      console.error("Login request failed with status: " + response.status);
      return false;
    }
  } catch (error) {
    // Error occurred during the request
    console.error("Login request failed with error:", error);
    return false;
  }
}

//Getting all the user data only for admins
async function getAllUsers() {
  let response = await fetch(`${actionURI}?getAllUser=true`, {
    method: "GET",
  });
  response = await response.json();
  return response;
}

//Deleteing the user data using the id of the data only for admins
async function deleteUser(id) {
  let response = await fetch(`${actionURI}?deleteUser=${id}`, {
    method: "GET",
  });
  response = await response.json();
  return response;
}

//Get the certain user data using the id
async function getUserById(id) {
  let response = await fetch(`${actionURI}?getUserById=${id}`, {
    method: "GET",
  });
  if (response.ok) {
    response = await response.json();
    return response;
  } else {
    console.error("Error getting response");
    return false;
  }
}

//Update the user
async function updateUser(id, name, email, password, cpassword) {
  let formData = new FormData();
  formData.append("id", id);
  formData.append("name", name);
  formData.append("email", email);
  formData.append("password", password);
  formData.append("cpassword", cpassword);
  formData.append("updateUser", true);
  let response = await fetch(`${actionURI}`, {
    method: "POST",
    body: formData,
  });
  if (response.ok) {
    response = await response.json();
    return response;
  } else {
    console.error("Error getting response");
    return false;
  }
}

//fetch all the artist data
async function getAllArtists() {
  let response = await fetch(`${actionURI}?getAllArtists=true`, {
    method: "GET",
  });
  response = await response.json();
  return response;
}

//delete the artist using the id
async function deleteArtist(id) {
  let response = await fetch(`${actionURI}?deleteArtist=${id}`, {
    method: "GET",
  });
  response = await response.json();
  return response;
}

//getting artist data using the id
async function getArtistById(id) {
  let response = await fetch(`${actionURI}?getArtistById=${id}`, {
    method: "GET",
  });
  if (response.ok) {
    response = await response.json();
    return response;
  } else {
    console.error("Error getting response");
    return false;
  }
}

//fetch all songs data only for admins
async function getAllSongs() {
  let response = await fetch(`${actionURI}?getAllSongs=true`, {
    method: "GET",
  });
  response = await response.json();
  return response;
}

//Deleteing the song using the id of the song
async function deleteSong(id) {
  let response = await fetch(`${actionURI}?deleteSongs=${id}`, {
    method: "GET",
  });
  response = await response.json();
  return response;
}

//getting the song details using the id of the song
async function getSongsById(id) {
  let response = await fetch(`${actionURI}?getSongsById=${id}`, {
    method: "GET",
  });
  if (response.ok) {
    response = await response.json();
    return response;
  } else {
    console.error("Error getting response");
    return false;
  }
}

//fetch all genre data
async function getAllGenres() {
  let response = await fetch(`${actionURI}?getAllGenres=true`, {
    method: "GET",
  });
  response = await response.json();
  return response;
}

//deleteing the data using the genre id
async function deleteGenre(id) {
  let response = await fetch(`${actionURI}?deleteGenres=${id}`, {
    method: "GET",
  });
  response = await response.json();
  return response;
}

//getting the genre data using the id
async function getGenresById(id) {
  let response = await fetch(`${actionURI}?getGenresById=${id}`, {
    method: "GET",
  });
  if (response.ok) {
    response = await response.json();
    return response;
  } else {
    console.error("Error getting response");
    return false;
  }
}

//adding the data of the song
async function song_details(data) {
  let response = await fetch(`${actionURI}`, {
    method: "POST",
    body: data,
  });
  response = await response.json();
  return response;
}

//adding the details of the artist
async function artist_details(data) {
  let response = await fetch(`${actionURI}`, {
    method: "POST",
    body: data,
  });
  response = await response.json();
  return response;
}
//adding the data of the genre
async function genre_details(data){
  let response = await fetch(`${actionURI}`,{
    method:"POST",
    body:data
  });
  response = await response.json();
  return response;
}
//function to add the count of the song that has been listened
async function addCountToSong(id){
  let response = await fetch(`${actionURI}?addCountToSong=true&id=${id}`,{
    method:"GET"
  });
  response = await response.json();
  return response;
}


async function search_song(search){
  let response = await fetch(`${actionURI}?search_songs=${search}`,{method:"GET"});
  response = await response.json();
  return response;
}

async function search_genre(search){
  let response = await fetch(`${actionURI}?search_genre=${search}`,{method:"GET"});
  response = await response.json();
  return response;
}

async function search_artist(search){
  let response = await fetch(`${actionURI}?search_artist=${search}`,{method:"GET"});
  response = await response.json();
  return response;
}
async function search_song_artist(id,search){
  let response = await fetch(`${actionURI}?search_song_artist=${search}&id=${id}`,{method:"GET"});
  response = await response.json();
  return response;
}
async function search_artist_genre(id,search){
  let response = await fetch(`${actionURI}?search_artist_genre=${search}&id=${id}`,{method:"GET"});
  response = await response.json();
  return response;
}

async function add_favorite(id){
  let formData = new FormData();
  formData.append("add_song_favorite",id);
  let response = await fetch(`${actionURI}`,{
    method:"POST",
    body:formData
  });
  response = await response.json();
  console.log(response)
  return response;
}

async function remove_favorite(id){
  let formData = new FormData();
  formData.append("remove_song_favorite",id);
  let response = await fetch(`${actionURI}`,{
    method:"POST",
    body:formData
  });
  response = await response.json();
  console.log(response)
  return response;
}