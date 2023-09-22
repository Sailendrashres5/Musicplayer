<?php
session_start();

include_once('./function.php');

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

//adding the favorites here 
if(isset($_POST['add_song_favorite'])){
    $id = $_POST['add_song_favorite'];
    $uid = $_SESSION['user_id'];
    $favorite = new Favorite($uid);
    if($favorite->addFavorite($id)){
        echo json_encode(['status'=>'true','msg'=>"Song added to your favorite"]);
    } else{
        echo json_encode(["status"=>"false","msg"=>'Error occured while saving']);
    } 
    exit();
}

if(isset($_POST['remove_song_favorite'])){
    $id = $_POST['remove_song_favorite'];
    $uid = $_SESSION['user_id'];
    $favorite = new Favorite($uid);
    if($favorite->removeFavorite($id)){
        echo json_encode(['status'=>'true','msg'=>"Song removed to your favorite"]);
    } else{
        echo json_encode(["status"=>"false","msg"=>'Error occured while saving']);
    } 
    exit();
}

    //genre adding form submittion 

    if(isset($_POST['genre_add_form']) || isset($_POST['genre_edit_form'])){
        include_once('./check_admin.php');
        $name = $_POST['genre_name'];
        $avatar_file = isset($_FILES['genre_avatar']) ? $_FILES['genre_avatar']['name'] : null;


        $id = null;

    if (isset($_POST['genre_edit_form'])) {
        // If it's the edit form, retrieve the genre ID from the post request data
        $id = $_POST['id'];
    }
        //uploading files 
        if ($avatar_file) {
            $avatarFileType = strtolower(pathinfo($avatar_file, PATHINFO_EXTENSION));
            if ($avatarFileType != "jpg" && $avatarFileType != "jpeg" && $avatarFileType != "png" && $avatarFileType != "gif") {
                echo json_encode(array('success' => false, 'message' => "File type not supported"));
                exit();
            } else {
                if (!file_exists("./assets/images/" . $avatar_file)) {
                    $tempName = $_FILES['genre_avatar']['tmp_name'];
                    if (!move_uploaded_file($tempName,"./assets/images/" . basename($avatar_file))) {
                        echo json_encode(array('success' => false, 'message' => 'Error uploading avatar file'));
                    }                
                }
            }
        }

        $genre = new Genre();
        if (isset($_POST['genre_edit_form'])) {
            // If it's the edit form, call the editGenre method with the retrieved genre ID
            $response = $genre->editGenre($id, $name, $avatar_file);
        } else {
            // If it's the add form, call the addGenres method
            $response = $genre->addGenres($name, $avatar_file);
        }
        echo $response;
        exit();
    }



    //add artists 
    if (isset($_POST['add_artist_detail'])) {
        include_once('./check_admin.php');
        $name = $_POST['name'];
        $genre = $_POST['genre'];
        $avatar_file = isset($_FILES['avatar']) ? $_FILES['avatar']['name'] : null;
        $background_file = isset($_FILES['background']) ? $_FILES['background']['name'] : null;

        if ($avatar_file) {
            $avatarFileType = strtolower(pathinfo($avatar_file, PATHINFO_EXTENSION));
            if ($avatarFileType != "jpg" && $avatarFileType != "jpeg" && $avatarFileType != "png" && $avatarFileType != "gif") {
                echo json_encode(array('success' => false, 'message' => "File type not supported"));
                exit();
            } else {
                if (!file_exists("./assets/images/" . $avatar_file)) {
                    $tempName = $_FILES['avatar']['tmp_name'];
                    if (!move_uploaded_file($tempName,"./assets/images/" . basename($avatar_file))) {
                        echo json_encode(array('success' => false, 'message' => 'Error uploading avatar file'));
                    }                
                }
            }
        }
        if ($background_file) {
            $backgroundFileType = strtolower(pathinfo($avatar_file, PATHINFO_EXTENSION));
            if ($backgroundFileType != "jpg" && $backgroundFileType != "jpeg" && $backgroundFileType != "png" && $backgroundFileType != "gif") {
                echo json_encode(array('success' => false, 'message' => "File type not supported"));
                exit();
            } else {
                if (!file_exists("./assets/images/" . $background_file)) {
                    $tempName = $_FILES['background']['tmp_name'];
                    if (!move_uploaded_file($tempName, "./assets/images/" . basename($background_file))) {
                        echo json_encode(array('success' => false, 'message' => 'Error uploading background file'));
                        exit();
                    }
                }
            }
        }
        $artist = new Artist();

        $result = $artist->addArtists($name, $genre, $avatar_file, $background_file);

        if ($result["success"]) {
            echo json_encode(["success" => true, "message" => "Artist added successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to add song."]);
        }
    }
    
    //Updating the artist data
    if (isset($_POST['edit_artist_detail'])) {
        include_once('./check_admin.php');
        $id = $_POST['id'];
        $name = $_POST['name'];
        $genre = $_POST['genre'];
        $avatar_file = isset($_FILES['avatar']) ? $_FILES['avatar']['name'] : null;
        $background_file = isset($_FILES['background']) ? $_FILES['background']['name'] : null;

        if ($avatar_file) {
            $avatarFileType = strtolower(pathinfo($avatar_file, PATHINFO_EXTENSION));
            if ($avatarFileType != "jpg" && $avatarFileType != "jpeg" && $avatarFileType != "png" && $avatarFileType != "gif") {
                echo json_encode(array('success' => false, 'message' => "File type not supported"));
                exit();
            } else {
                if (!file_exists("./assets/images/" . $avatar_file)) {
                    $tempName = $_FILES['avatar']['tmp_name'];
                    if (!move_uploaded_file($tempName,"./assets/images/" . basename($avatar_file))) {
                        echo json_encode(array('success' => false, 'message' => 'Error uploading avatar file'));
                    }                
                }
            }
        }
        if ($background_file) {
            $backgroundFileType = strtolower(pathinfo($avatar_file, PATHINFO_EXTENSION));
            if ($backgroundFileType != "jpg" && $backgroundFileType != "jpeg" && $backgroundFileType != "png" && $backgroundFileType != "gif") {
                echo json_encode(array('success' => false, 'message' => "File type not supported"));
                exit();
            } else {
                if (!file_exists("./assets/images/" . $background_file)) {
                    $tempName = $_FILES['background']['tmp_name'];
                    if (!move_uploaded_file($tempName, "./assets/images/" . basename($background_file))) {
                        echo json_encode(array('success' => false, 'message' => 'Error uploading background file'));
                        exit();
                    }
                }
            }
        }

        
        $artist = new Artist();

        $result = $artist->editArtist($id,$name, $genre, $avatar_file, $background_file);
        echo json_encode($result);
        exit();
        if ($result["success"]) {
            echo json_encode(["success" => true, "message" => "Artist added successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to add artist."]);
        }
    }

    //adding songs details 
    if (isset($_POST['add_song_detail'])) {
        include_once("./check_admin.php");
        $name = $_POST['song_name'];
        $genre = $_POST['song_genre'];
        $artist = $_POST['song_artist'];
        $song_file = isset($_FILES['song_file']) ? $_FILES['song_file']['name'] : null;
        

        if ($song_file) {
            $avatarFileType = strtolower(pathinfo($song_file , PATHINFO_EXTENSION));
            $allowedFileTypes = array("mp3", "wav", "flac");
        
            if (!in_array($avatarFileType, $allowedFileTypes)) {
                echo json_encode(array('success' => false, 'message' => "File type not supported"));
                exit();
            } else {
                $destinationPath = "./assets/songs/" . basename($song_file);
                
                if (!file_exists($destinationPath)) {
                    if (!move_uploaded_file($_FILES['song_file']['tmp_name'], $destinationPath)) {
                        echo json_encode(array('success' => false, 'message' => 'Error uploading song file'));
                        exit();
                    }
                }
            }
        }


        $song = new Song();
        $result = $song->addSong($name, $artist, $genre,$song_file);

        if ($result["success"]) {
            echo json_encode(["success" => true, "message" => "Song added successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to add song."]);
        }
    }
    if (isset($_POST['edit_song_detail'])) {
        include_once('./check_admin.php');
        $id = $_POST['id'];
        $name = $_POST['song_name'];
        $genre = $_POST['song_genre'];
        $artist = $_POST['song_artist'];
        $song_file = isset($_FILES['song_file']) ? $_FILES['song_file']['name'] : null;


        if ($song_file) {
            $avatarFileType = strtolower(pathinfo($song_file , PATHINFO_EXTENSION));
            $allowedFileTypes = array("mp3", "wav", "flac");
        
            if (!in_array($avatarFileType, $allowedFileTypes)) {
                echo json_encode(array('success' => false, 'message' => "File type not supported"));
                exit();
            } else {
                $destinationPath = "./assets/songs/" . basename($song_file);
                
                if (!file_exists($destinationPath)) {
                    if (!move_uploaded_file($_FILES['song_file']['tmp_name'], $destinationPath)) {
                        echo json_encode(array('success' => false, 'message' => 'Error uploading song file'));
                        exit();
                    }
                }
            }
        }

        $song = new Song();
        $result = $song->updateSongs($id, $name, $artist, $genre,$song_file);

    
        if ($result["success"]) {
            echo json_encode(["success" => true, "message" => "Song added successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to add song."]);
        }
        exit();
    }
    //this is for login
    if (isset($_POST['login'])) {
        $username = $_POST['email'];
        $password = $_POST['password'];

        // Create an instance of the User class
        $user = new User();

        // Perform the login verification
        $loginSuccessful = $user->loginUser($username, $password);

        if ($loginSuccessful) {
            // Login successful
            $response = array('success' => true);
        } else {
            // Login failed
            $response = array('success' => false);
        }

        // Return the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
    if (isset($_POST['signup'])) {
        $username = $_POST['email'];
        $name = $_POST['name'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];


        // Create an instance of the User class
        $user = new User();

        // Perform the login verification
        $CreateSuccessful = $user->registerUser($name, $username, $password, $cpassword);

        if ($CreateSuccessful) {
            // Login successful
            $response = array('success' => true);
        } else {
            // Login failed
            $response = array('success' => false);
        }

        // Return the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    if (isset($_POST['updateUser'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];

        // Create an instance of the User class
        $user = new User();

        // Perform the login verification
        $updateSuccessful = $user->updateUser($id, $name, $email, $password, $cpassword);

        if ($updateSuccessful) {
            // Login successful
            $response = array('success' => true);
        } else {
            // Login failed
            $response = array('success' => false);
        }

        // Return the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
}
//End of POST

//request to get all artists

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    //getting the data of genre using id 
    if (isset($_GET["getGenresById"])) {
        include_once('./check_admin.php');
        $id = $_GET['getGenresById'];
        try {
            $genre = new Genre();
            $response = $genre->getGenreById($id);
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(array('error' => $e->getMessage()));
            exit();
        }
    }
    if (isset($_GET["getArtistById"])) {
        $id = $_GET['getArtistById'];
        try {
            $artist = new Artist();
            $response = $artist->getArtistById($id);
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(array('error' => $e->getMessage()));
            exit();
        }
    }
    if (isset($_GET["getSongsById"])) {
        include_once('./check_admin.php');
        $id = $_GET['getSongsById'];
        

        try {
            $song = new Song();
            $response = $song->getSongById($id);
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(array('error' => $e->getMessage()));
            exit();
        }
    }
    if (isset($_GET['getAllArtists'])) {
        include_once('./check_admin.php');
        try {
            $artist = new Artist();
            $response = $artist->getAllArtists();
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(array('error' => $e->getMessage()));
            exit();
        }
    }

    //request to get all songs
    if (isset($_GET['getAllSongs'])) {
        
        try {
            $song = new Song();
            $response = $song->getAllSongs();
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(array('error' => $e->getMessage()));
            exit();
        }
    }

    //request to get all genres
    if (isset($_GET['getAllGenres'])) {
        include_once('./check_admin.php');
        try {
            $genre = new Genre();
            $response = $genre->getAllGenres();
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(array('error' => $e->getMessage()));
            exit();
        }
    }


    //adding count to song for the watch count
    if(isset($_GET['addCountToSong'])){
        include_once('./check_login.php');
        try{
            $id=$_GET['id'];
            $song = new Song();
            $result = $song->add_count($id);
            // echo json_encode(array("test123"=>$id));
            echo $result;
            exit();
        }catch(Exception $err){
            echo json_encode(array("success"=>false,"message"=>$err));
            exit();
        }
    }


    //request to get all users

    if (isset($_GET['getAllUser'])) {
        include_once('./check_admin.php');
        try {
            $user = new User();
            $response = $user->getAllUsers();
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(array('error' => $e->getMessage()));
            exit();
        }
    }
    if (isset($_GET["deleteUser"])) {
        include_once('./check_admin.php');
        try {
            $id = $_GET['deleteUser'];
            $user = new User();
            $response = $user->deleteUser($id);
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(array('error' => $e->getMessage()));
            exit();
        }
    }
    if (isset($_GET['getUserById'])) {
        include_once('./check_admin.php');
        try {
            $id = $_GET['getUserById'];
            $user = new User();
            $response = $user->getUserById($id);
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(array('error' => $e->getMessage()));
            exit();
        }
    }

    if(isset($_GET["search_songs"])){
        try {
            $search = $_GET['search_songs'];
            $song = new Song();
            $response = $song->searchSong($search);
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(array('error' => $e->getMessage()));
            exit();
        }
    }
    if(isset($_GET["search_genre"])){
        try {
            $search = $_GET['search_genre'];
            $genre = new Genre();
            $response = $genre->searchGenre($search);
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(array('error' => $e->getMessage()));
            exit();
        }
    }
    
    if(isset($_GET["search_artist"])){
        try {
            $search = $_GET['search_artist'];
            $artist = new Artist();
            $response = $artist->searchArtist($search);
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(array('error' => $e->getMessage()));
            exit();
        }
    }

    if(isset($_GET["search_artist_genre"])){
        try {
            $search = $_GET['search_artist_genre'];
            $id = $_GET['id'];
            $genre = new Genre();
            $response = $genre->searchByGenre($id,$search);
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(array('error' => $e->getMessage()));
            exit();
        }
    }

    if(isset($_GET["search_song_artist"])){
        try {
            $search = $_GET['search_song_artist'];
            $id = $_GET['id'];
            $artist = new Artist();
            $response = $artist->searchSongByArtist($id,$search);
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(array('error' => $e->getMessage()));
            exit();
        }
    }
}
