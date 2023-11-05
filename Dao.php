<?php

class Dao {
    private $host = "l6glqt8gsx37y4hs.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
    private $db = "pzuvo5clr9xvobwh";
    private $user = "u8b5s6qsh7tj80n2";
    private $pass = "fl2sibhflckdr9vh";

    public function getConnection () {
        return
            new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user,
                $this->pass);
    }

    public function isUsernameTaken($username) {
        $conn = $this->getConnection();

        $query = "SELECT id FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO:: FETCH_ASSOC);

        return (bool)$user;
    }

    public function registerUser($first, $last, $username, $password) {
        $conn = $this->getConnection();

        // Hash the password before storing it in the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (first_name, last_name, username, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        // Use the hashed password
        $success = $stmt->execute([$first, $last, $username, $hashedPassword]);

        return $success;
    }

    public function authenticate($first, $last, $username, $password) {
        $conn = $this->getConnection();

        // Query database to see if user exists
        $query = "SELECT id FROM users WHERE first_name = ? AND last_name = ? AND username = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$first, $last, $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password
        if ($user) {
            // User exists with the provided first name, last name, and username.
            $user_id = $user['id']; // Retrieve the user's ID
            $_SESSION['user_id'] = $user_id; // Store the user's ID in the session
            // Now, verify the password.
            $query = "SELECT password FROM users WHERE username = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$username]);
            $storedHashedPassword = $stmt->fetchColumn();

            if ($storedHashedPassword !== false && password_verify($password, $storedHashedPassword)) {
                // Password is correct
                return true;
            }
        }

        // User is not authenticated
        return false;
    }

    public function getUserInfo($user_id) {
        $conn = $this->getConnection();
        $query = "SELECT first_name FROM users WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function saveVideo($title, $link, $date) {
        $conn = $this->getConnection();
        $user_id = $_SESSION['user_id'];
        $saveQuery = "INSERT INTO videos 
                        (title, link, user_id, date) 
                        VALUES (:title, :link, :user_id, :date)";
        $stmt = $conn->prepare($saveQuery);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":link", $link);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":date", $date);
        $stmt->execute();
    }

    public function getVideos() {
        $conn = $this->getConnection();
        $user_id = $_SESSION['user_id'];
        $query = "SELECT title, link FROM videos WHERE user_id = :user_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVideosByDate($selectedDate) {
        $conn = $this->getConnection();
        $user_id = $_SESSION['user_id'];
        $query = "SELECT title, link FROM videos WHERE user_id = :user_id AND date = :selectedDate";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":selectedDate", $selectedDate);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteVideos($title) {
        $conn = $this->getConnection();
        $deleteVideo =
            "DELETE FROM videos
            WHERE title = :title";
        $q = $conn->prepare($deleteVideo);
        $q->bindParam(":title", $title);
        $q->execute();
    }

    public function videoExists($title) {
        $conn = $this->getConnection();

        $checkVideoExists = "SELECT COUNT(*) FROM videos WHERE title = :title";
        $q = $conn->prepare($checkVideoExists);
        $q->bindParam(":title", $title);
        $q->execute();

        $count = $q->fetchColumn();

        // If the count is greater than 0, the video with the given title exists
        return $count > 0;
    }

    public function saveImage($title, $link, $date) {
        $conn = $this->getConnection();
        $user_id = $_SESSION['user_id'];
        $saveQuery = "INSERT INTO images 
                        (title, link, user_id, date) 
                        VALUES (:title, :link, :user_id, :date)";
        $stmt = $conn->prepare($saveQuery);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":link", $link);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":date", $date);
        $stmt->execute();
    }

    public function getImages() {
        $conn = $this->getConnection();
        $user_id = $_SESSION['user_id'];
        $query = "SELECT title, link FROM images WHERE user_id = :user_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getImagesByDate($selectedDate) {
        $conn = $this->getConnection();
        $user_id = $_SESSION['user_id'];
        $query = "SELECT title, link FROM images WHERE user_id = :user_id AND date = :selectedDate";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":selectedDate", $selectedDate);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteImage($title) {
        $conn = $this->getConnection();
        $deleteImage =
            "DELETE FROM images
            WHERE title = :title";
        $q = $conn->prepare($deleteImage);
        $q->bindParam(":title", $title);
        $q->execute();
    }

    public function imageExists($title) {
        $conn = $this->getConnection();

        $checkImageExists = "SELECT COUNT(*) FROM images WHERE title = :title";
        $q = $conn->prepare($checkImageExists);
        $q->bindParam(":title", $title);
        $q->execute();

        $count = $q->fetchColumn();

        // If the count is greater than 0, the video with the given title exists
        return $count > 0;
    }

    public function saveDocument($subject, $link, $name, $date) {
        $conn = $this->getConnection();
        $user_id = $_SESSION['user_id'];
        $saveQuery = "INSERT INTO lesson_plans (subject, link, name, user_id, date) 
                        VALUES (:subject, :link, :name, :user_id, :date)"; //user
        $stmt = $conn->prepare($saveQuery);
        $stmt->bindParam(":subject", $subject);
        $stmt->bindParam(":link", $link);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":date", $date);
        $stmt->execute();
    }

    public function getDocumentsBySubjectAndDate($subject, $date) {
        $conn = $this->getConnection();
        $user_id = $_SESSION['user_id'];

        // Check if a date is provided
        if (empty($date)) {
            return []; // Return an empty array if no date is selected
        }

        $query = "SELECT document_link, name FROM lesson_plans WHERE subject = :subject AND user_id = :user_id AND date = :date";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":subject", $subject);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":date", $date);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function deleteDocument($name) {
        $conn = $this->getConnection();
        $deleteQuery = "DELETE FROM lesson_plans WHERE name = :name";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bindParam(":name", $name);
        return $stmt->execute();
    }

    public function documentExists($name) {
        $conn = $this->getConnection();
        $selectQuery = "SELECT name FROM lesson_plans WHERE name = :name";
        $stmt = $conn->prepare($selectQuery);
        $stmt->bindParam(":name", $name);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($result !== false);
    }

    public function saveResource($subject, $documentPath, $name) {
        $conn = $this->getConnection();
        $user_id = $_SESSION['user_id'];
        $saveQuery = "INSERT INTO resources (subject, document_path, user_id, name) 
                        VALUES (:subject, :documentPath, :user_id, :name)";
        $stmt = $conn->prepare($saveQuery);
        $stmt->bindParam(":subject", $subject);
        $stmt->bindParam(":documentPath", $documentPath);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":name", $name);
        $stmt->execute();
    }

    public function getDocumentsByRow($subject) {
        $conn = $this->getConnection();
        $user_id = $_SESSION['user_id'];
        $query = "SELECT document_path, name FROM resources WHERE subject = :subject AND user_id = :user_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":subject", $subject);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteResource($name) {
        $conn = $this->getConnection();
        $deleteQuery = "DELETE FROM resources WHERE name = :name";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bindParam(":name", $name);
        return $stmt->execute();
    }

    public function resourceExists($name) {
        $conn = $this->getConnection();
        $selectQuery = "SELECT name FROM resources WHERE name = :name";
        $stmt = $conn->prepare($selectQuery);
        $stmt->bindParam(":name", $name);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($result !== false);
    }

}
