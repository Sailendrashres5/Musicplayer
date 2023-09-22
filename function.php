<?php
include_once("./db.php");

class User extends Database
{
    private $email;
    private $password;
    private $name;

    public function __construct()
    {
        parent::connect(); // Establish database connection
    }
    public function registerUser($name, $email, $password, $c_password)
    {

        // Perform email, password, and confirm password validation
        if ($this->validateEmail($email) && $this->validatePassword($password) && $this->validateConfirmPassword($password, $c_password)) {
            $this->name = $name;
            $this->email = $email;
            $this->password = $password;

            // Hash the password before storing it in the database
            $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

            // Insert the user data into the database
            $sql = "INSERT INTO user (name, email, password) VALUES (?, ?, ?)";
            $stmt = $this->prepare($sql);
            $stmt->bind_param("sss", $this->name, $this->email, $hashedPassword);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function loginUser($email, $password)
    {
        // Retrieve the user data from the database
        $sql = "SELECT * FROM user WHERE email = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Set sessions upon successful login
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_admin'] = $user['admin'];

                return true;
            }
        }

        return false;
    }
    public function updateUser($id, $name, $email, $password, $cpassword)
    {
        // Validate email and confirm password
        if ($this->validateEmail($email) && $this->validateConfirmPassword($password, $cpassword)) {
            // Check if the password is null or empty
            if ($password !== null && $password !== '') {
                // Validate the password
                if (!$this->validatePassword($password)) {
                    return false;
                }
                // Hash the password before storing it in the database
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            } else {
                // If password is null or empty, set it to null
                $hashedPassword = null;
            }

            // Update the user data in the database
            $sql = "UPDATE user SET name = ?, email = ?";
            $params = array($name, $email);
            if ($hashedPassword !== null) {
                // Include password update in the SQL query if the password is not null
                $sql .= ", password = ?";
                $params[] = $hashedPassword;
            }
            $sql .= " WHERE id = ?";
            $params[] = $id;

            $stmt = $this->prepare($sql);
            $stmt->bind_param(str_repeat('s', count($params)), ...$params);
            $result = $stmt->execute();

            if ($result) {
                // Update the session if the logged-in user's information is being updated
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    public function getAllUsers()
    {
        $sql = "SELECT * FROM user";
        $stmt = $this->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $users = array();
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            return $users;
        }

        return [];
    }

    public function getUserById($userId)
    {
        $sql = "SELECT * FROM user WHERE id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            return $user;
        }

        return null;
    }
    public function deleteUser($userId)
    {
        $sql = "DELETE FROM user WHERE id =?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            return array("success" => true);
        } else {
            return array("success" => false);
        }
    }
    private function validateEmail($email)
    {
        // Split the email into username and domain parts
        $emailParts = explode('@', $email);

        if (count($emailParts) !== 2) {
            // Invalid email format
            return false;
        }

        // Extract the domain part from the email
        $domain = $emailParts[1];

        // List of allowed email service provider domains
        $allowedDomains = ['gmail.com', 'outlook.com', 'hotmail.com'];

        // Check if the domain is in the allowed domains list
        if (!in_array($domain, $allowedDomains)) {
            // Invalid email domain
            return false;
        }

        return true;
    }

    private function validatePassword($password)
    {
        // Check the password length
        if (strlen($password) < 8) {
            // Password is too short
            return false;
        }

        // Check if the password contains at least one uppercase letter, one number, and one character
        if (!preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*[^\w\d\s])/", $password)) {
            // Password does not meet the requirements
            return false;
        }

        return true;
    }

    private function validateConfirmPassword($password, $c_password)
    {
        // Check if the confirm password matches the original password
        if ($password !== $c_password) {
            // Confirm password does not match
            return false;
        }

        return true;
    }

    // Other methods and functions for your User class...




} //end of class User extends Database


class Artist extends Database
{

    //this is for fetching artists
    public function __construct()
    {
        parent::connect(); // Establish database connection
    }
    public function addArtists($name, $genre, $avatar, $background)
    {
        $sql = "INSERT INTO `artist`(`name`,`avatar`,`background`,`genre`) VALUES (?,?,?,?);";
        $stmt = $this->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssss", $name, $avatar, $background, $genre);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                return array("success" => true, "message" => "Artist added successfully.");
            } else {
                return array("success" => false, "message" => "Failed to add song.");
            }
        } else {
            return array("success" => false, "message" => "Error preparing statement.");
        }
    }
    public function editArtist($id, $name, $genre, $avatar, $background)
    {
        $sql = "UPDATE `artist` SET `name` = ?, `genre` = ?";
        $params = array($name, $genre);

        if ($avatar) {
            $sql .= ", `avatar` = ?";
            $params[] = $avatar;
        }

        if ($background) {
            $sql .= ", `background` = ?";
            $params[] = $background;
        }

        $sql .= " WHERE `id` = ?";
        $params[] = $id;

        $stmt = $this->prepare($sql);
        if ($stmt) {
            $paramTypes = str_repeat("s", count($params));
            $stmt->bind_param($paramTypes, ...$params);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    return array("success" => true, "message" => "Artist updated successfully.");
                } else {
                    return array("success" => false, "message" => "Failed to update artist.");
                }
            } else {
                // Log or handle the database execution error appropriately.
                return array("success" => false, "message" => "Execution error: ");
            }
        } else {
            // Log or handle the statement preparation error appropriately.
            return array("success" => false, "message" => "Error preparing statement: ");
        }
    }


    public function getAllArtists()
    {
        $sql = "SELECT * FROM `artist`";
        $stmt = $this->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $artists = array();
            while ($row = $result->fetch_assoc()) {
                $artists[] = $row;
            }
            return $artists;
        }

        return [];
    }


    public function getArtistById($artistId)
    {
        $sql = "SELECT * FROM `artist` WHERE id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $artistId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $artist = $result->fetch_assoc();
            return $artist;
        }

        return [];
    }

    //get artist by genres
    public function getArtistByGenres($genreId)
    {
        $sql = "SELECT * FROM `artist` WHERE `genre` = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $genreId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $artists = array();
            while ($row = $result->fetch_assoc()) {
                $artists[] = $row;
            }
            return $artists;
        }

        return [];
    }

    public function searchArtist($search)
    {
        $searchTerm = "%" . $search . "%";
        $sql = "SELECT * FROM artist WHERE `name` LIKE ?";

        // Assuming you're using PDO to connect to the database
        $stmt = $this->prepare($sql);
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $artist = array();
            while ($row = $result->fetch_assoc()) {
                $artist[] = $row;
            }
            return $artist;
        }

        return [];
    }

    public function searchSongByArtist($id, $search)
    {
        $searchTerm = "%" . $search . "%";
        $sql = "SELECT * FROM song WHERE `artist` = ? AND `name` LIKE ?"; // Fixed the SQL query

        // Assuming you're using PDO to connect to the database
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ss", $id, $searchTerm); // Assuming 'artist' column is of type string
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $songs = array();
            while ($row = $result->fetch_assoc()) {
                $songs[] = $row;
            }
            return $songs;
        }

        return [];
    }

    public function deleteArtist($artistId)
    {
        $sql = "DELETE FROM `artist` WHERE id =?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $artistId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            return array("success" => true);
        } else {
            return array("success" => false);
        }
    }
}

//
class Song extends Database
{

    //this is for fetching songs

    public function __construct()
    {
        parent::connect(); // Establish database connection
    }

    public function addSong($name, $artist, $genre, $filename)
    {
        $sql = "INSERT INTO `song` (`name`, `artist`, `genre`, `filename`) VALUES (?, ?, ?, ?)";
        $stmt = $this->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssss", $name, $artist, $genre, $filename);
            $stmt->execute();

            // Check if the insert was successful
            if ($stmt->affected_rows > 0) {
                return array("success" => true, "message" => "Song added successfully.");
            } else {
                return array("success" => false, "message" => "Failed to add song.");
            }
        } else {
            return array("success" => false, "message" => "Error preparing statement.");
        }
    }
    public function updateSongs($id, $name, $artist, $genre, $filename)
    {
        $sql = "UPDATE `song` SET `name` = ?, `artist` = ?, `genre` = ?";
        $params = array($name, $artist, $genre);

        // Check if a new filename is provided
        if ($filename) {
            $sql .= ", `filename` = ?";
            $params[] = $filename;
        }

        $sql .= " WHERE `id` = ?";
        $params[] = $id;

        $stmt = $this->prepare($sql);

        if ($stmt) {
            $stmt->bind_param(str_repeat('s', count($params)), ...$params);
            $stmt->execute();

            // Check if the update was successful
            if ($stmt->affected_rows > 0) {
                return array("success" => true, "message" => "Song updated successfully.");
            } else {
                return array("success" => false, "message" => "Failed to update song.");
            }
        } else {
            return array("success" => false, "message" => "Error preparing statement.");
        }
    }
    public function getAllSongs()
    {
        $sql = "SELECT * FROM `song` ORDER BY `id` DESC";
        $stmt = $this->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $songs = array();
            while ($row = $result->fetch_assoc()) {
                $songs[] = $row;
            }
            return $songs;
        }

        return [];
    }

    public function getSongById($songId)
    {
        $sql = "SELECT * FROM `song` WHERE id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $songId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $song = $result->fetch_assoc();
            return $song;
        }

        return null;
    }

    //getting the songs using the artist id
    public function getSongsByArtist($artistId)
    {
        $sql = "SELECT * FROM `song` WHERE `artist` = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $artistId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $songs = array();
            while ($row = $result->fetch_assoc()) {
                $songs[] = $row;
            }
            return $songs;
        }

        return [];
    }

    public function searchSong($search)
    {
        $searchTerm = "%" . $search . "%";
        $sql = "SELECT * FROM song WHERE `name` LIKE ?";

        // Assuming you're using PDO to connect to the database
        $stmt = $this->prepare($sql);
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $songs = array();
            while ($row = $result->fetch_assoc()) {
                $songs[] = $row;
            }
            return $songs;
        }

        return [];
    }


    public function add_count($id)
    {
        $user_id = $_SESSION['user_id'];
        $sql1 = "SELECT * FROM `song` WHERE `id`=?";
        $stmt1 = $this->prepare($sql1);
        $stmt1->bind_param("i",$id);
        $stmt1->execute();
        $result = $stmt1->get_result();
        while($data=$result->fetch_assoc()){
            $aid = $data['artist'];
            $sql2 = "SELECT * FROM `monthly` WHERE `aid` = ? and `uid` = ?";

            $stmt2= $this->prepare($sql2);
            $stmt2->bind_param("ii",$aid,$user_id);
            $stmt2->execute();
            $response1 = $stmt2->get_result();
            $count = $response1->num_rows;
            if($count == 0){
                $sql3="INSERT INTO `monthly`(`aid`,`uid`) VALUES (?,?)";
                $stmt3=$this->prepare($sql3);
                $stmt3->bind_param("ii",$aid,$user_id);
                $stmt3->execute();
                $sql4="UPDATE `artist` SET `total`=`total`+1 WHERE `id`=?";
                $stmt4 = $this->prepare($sql4);
                $stmt4->bind_param("i",$aid);
                $stmt4->execute();
            }
        }
        $sql = "UPDATE `song` SET `total`= `total`+1 WHERE `id`= ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->affected_rows;
        if ($result) {
            return json_encode(array("success" => true));
        } else {
            return json_encode(array("success" => false));
        }
    }

    public function deleteSong($songId)
    {
        $sql = "DELETE FROM `song` WHERE id =?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $songId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            return array("success" => true);
        } else {
            return array("success" => false);
        }
    }
}


//Genre Class
class Genre extends Database
{

    //this is for fetching genre

    public function __construct()
    {
        parent::connect(); // Establish database connection
    }

    public function addGenres($genre, $filename = null)
    {
        $sql = "INSERT INTO `genre` (`name`, `filename`) VALUES (?, ?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ss", $genre, $filename);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = array("success" => true, "message" => "Genre added successfully");
        } else {
            $response = array("success" => false, "message" => "Failed to add genre");
        }

        $stmt->close();

        return json_encode($response);
    }


    public function editGenre($genreId, $genre, $filename = null)
    {
        // Check if the filename is provided and not null
        if ($filename !== null) {
            $sql = "UPDATE `genre` SET `name` = ?, `filename` = ? WHERE `id` = ?";
            $stmt = $this->prepare($sql);
            $stmt->bind_param("ssi", $genre, $filename, $genreId);
        } else {
            $sql = "UPDATE `genre` SET `name` = ? WHERE `id` = ?";
            $stmt = $this->prepare($sql);
            $stmt->bind_param("si", $genre, $genreId);
        }

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = array("success" => true, "message" => "Genre updated successfully");
        } else {
            $response = array("success" => false, "message" => "Failed to update genre");
        }

        return json_encode($response);
    }
    public function getAllGenres()
    {
        $sql = "SELECT * FROM `genre`";
        $stmt = $this->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $genres = array();
            while ($row = $result->fetch_assoc()) {
                $genres[] = $row;
            }
            return $genres;
        }

        return [];
    }

    public function getGenreById($genreId)
    {
        $sql = "SELECT * FROM `genre` WHERE id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $genreId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $genre = $result->fetch_assoc();
            return $genre;
        }

        return [];
    }

    public function searchGenre($search)
    {
        $searchTerm = "%" . $search . "%";
        $sql = "SELECT * FROM genre WHERE `name` LIKE ?";

        // Assuming you're using PDO to connect to the database
        $stmt = $this->prepare($sql);
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $genre = array();
            while ($row = $result->fetch_assoc()) {
                $genre[] = $row;
            }
            return $genre;
        }

        return [];
    }

    public function searchByGenre($id, $search)
    {
        $searchTerm = "%" . $search . "%";
        $sql = "SELECT * FROM artist WHERE `genre` = ? AND `name` LIKE ?"; // Fixed the SQL query

        // Assuming you're using PDO to connect to the database
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ss", $id, $searchTerm); // Assuming 'genre' column is of type string
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $genre = array();
            while ($row = $result->fetch_assoc()) {
                $genre[] = $row;
            }
            return $genre;
        }

        return [];
    }


    public function deleteGenre($genreId)
    {
        $sql = "DELETE FROM `genre` WHERE id =?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $genreId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            return array("success" => true);
        } else {
            return array("success" => false);
        }
    }
}

//for algorithm
class BayesianMonthlyListenersCalculator
{
    private $songs;

    public function __construct(array $songs)
    {
        $this->songs = $songs;
    }

    private function bayesianAverage($listeners, $totalListeners, $totalSongs)
    {
        $C = 1500; // The average number of listeners that a song is expected to have
        $K = 50;   // A constant that regulates the effect of small sample sizes

        if ($totalListeners === 0 || $totalSongs === 0) {
            return 0; // Handle potential division by zero
        }

        $averageListeners = $listeners / $totalSongs;
        $bayesianListeners = ($totalListeners / ($totalListeners + $totalSongs)) * $averageListeners + ($totalSongs / ($totalListeners + $totalSongs)) * ($C / ($C + $K));

        // Scale the bayesianListeners value to the range [0, totalListeners]
        $bayesianListeners = $bayesianListeners * $listeners;

        // Ensure the monthly listeners score is within the range [0, totalListeners]
        $bayesianListeners = max(0, min($listeners, $bayesianListeners));

        return $bayesianListeners;
    }

    public function listenersToStarRating($listeners, $totalListeners)
    {
        // Map the monthly listeners score to a popularity (adjust as needed)
        $maxRating = 5; // Maximum popularity
        $rating = round($listeners * $maxRating / max(1, $totalListeners), 1); // Round to one decimal place

        return $rating;
    }

    public function calculateListeners()
    {
        $totalListeners = array_sum(array_column($this->songs, 'total'));
        $totalSongs = count($this->songs);

        foreach ($this->songs as &$song) {
            $song['monthly_listeners'] = $this->bayesianAverage($song['total'], $totalListeners, $totalSongs);

            // Calculate the star rating for each song based on its monthly listeners
            $song['star_rating'] = $this->listenersToStarRating($song['monthly_listeners'], $totalListeners);
        }

        // Sort songs by monthly listeners in descending order
        usort($this->songs, function ($a, $b) {
            return $b['monthly_listeners'] <=> $a['monthly_listeners'];
        });

        return $this->songs;
    }
}

class Favorite extends Database
{
    private $id; // Moved the initialization to the constructor

    public function __construct($id)
    {
        parent::connect(); // Establish database connection

        // Initialize the user ID from the session
        $this->id = $id;
    }

    public function addFavorite($sid)
    {
        $sql = 'INSERT INTO `favorite`(`user`, `song`) VALUES (?, ?);';
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ii", $this->id, $sid);

        return $stmt->execute(); // Directly return the result of execute()
    }

    public function getFavorite()
    {
        $favorites = array();

        $sql = 'SELECT s.* FROM `favorite` AS f
        INNER JOIN `song` AS s ON f.`song` = s.`id`
        WHERE f.`user` = ?;';

        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $favorites[] = $row; // Store the entire row (song data) in the favorites array
        }

        return $favorites;
    }


    public function removeFavorite($sid)
    {
        $sql = 'DELETE FROM `favorite` WHERE `user` = ? AND `song` = ?;';
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ii", $this->id, $sid);

        return $stmt->execute(); // Directly return the result of execute()
    }
}


class BayesianMonthlyListenersEstimator extends Database {
    protected $data =array();

    public function __construct() {
        parent::connect(); // Establish database connection
    }

    public function estimateAverageMonthlyListeners() {
        // Fetch data from the database (total plays for each artist)
        $sql = "SELECT artist.*, COUNT(DISTINCT monthly.uid) AS total_plays
                FROM artist 
                LEFT JOIN monthly ON artist.id = monthly.aid 
                GROUP BY artist.id";
                
        $stmt = $this->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result(); 

        while ($row = $result->fetch_assoc()) {
          array_push($this->data, $row);
        }
        array_push($this->data);

        $prior_parameter = 1000;
        $hs = 1/$prior_parameter;
        $data = array();
        foreach ($this->data as $dat) {
          $likehood = ($prior_parameter+$dat["total_plays"])/2;
          $bayesian = ($likehood*$hs)/1;
         $dat["average"]= round($bayesian);
         array_push($data,$dat);
        }
        return $data;
    }
}

?>
