<?php
class User
{
    private $conn;

    // Constructor to initialize the database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create a new user
    public function createUser($email, $name, $password)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (email, name, password) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssss", $email, $name, $password);
            if ($stmt->execute()) {
                $stmt->close();
                return true;
            } else {
                return "Error: " . $stmt->error;
            }
        } else {
            return "Error: " . $this->conn->error;
        }
    }

    // Read all users
    public function getUsers()
    {
        $sql = "SELECT email, name, role FROM users";
        $result = $this->conn->query($sql);
        if ($result) {
            return $result;
        } else {
            return "Error: " . $this->conn->error;
        }
    }

    // Read a single user by email
    public function getUser($email)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();

            return $user;
        } else {
            return "Error: " . $this->conn->error;
        }
    }

    // Update a user's information
    public function updateUser($email, $name)
    {
        $sql = "UPDATE users SET name = ? WHERE email = ?";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sss", $name, $email);
            if ($stmt->execute()) {
                $stmt->close();
                return true;
            } else {
                return "Error: " . $stmt->error;
            }
        } else {
            return "Error: " . $this->conn->error;
        }
    }

    // Delete a user by email
    public function deleteUser($email)
    {
        $sql = "DELETE FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $email);
            if ($stmt->execute()) {
                $stmt->close();
                return true;
            } else {
                return "Error: " . $stmt->error;
            }
        } else {
            return "Error: " . $this->conn->error;
        }
    }
        public function register($email, $name, $password) {
            // Check if the user already exists
            $sql = "SELECT email FROM users WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();
    
                if ($stmt->num_rows > 0) {
                    $stmt->close();
                    return "User already exists.";
                }
    
                $stmt->close();
            } else {
                return "Error: " . $this->conn->error;
            }
             // Create the user
        return $this->createUser($email, $name, $password);
    }
}
?>
