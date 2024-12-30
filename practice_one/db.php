<?php
include('config.php');
// Create a connection to the database using constants
Class Db{

    public $conn;
    function __construct(){
        $this->get_connection();
    }

    private function get_connection(){
        $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $this->conn =$conn;
    }

    public function check_email($email){
        $email_check_sql = "SELECT * FROM users WHERE email = '$email'";
        $email_check_result = $this->conn->query($email_check_sql);
        if ($email_check_result->num_rows > 0) {
           return true;
        }
        return false;
    }

    public function check_phone($phone){
        $phone_check_sql = "SELECT * FROM users WHERE phone = '$phone'";
        $phone_check_result = $this->conn->query($phone_check_sql);
        if ($phone_check_result->num_rows > 0) {
           return true;
        }
        return false;
    }

    public function check_password($password){
        $password_check_sql = "SELECT * FROM users WHERE password = '$password'";
        $password_check_result = $this->conn->query($password_check_sql);
        if ($password_check_result->num_rows > 0) {
           return true;
        }
        return false;
    }

    public function add_user($post_data){
        $sql_users = "INSERT INTO users (name, phone, email, gender, password, dob, created_at, profile_image)
            VALUES (
                '" . $post_data['name'] . "',
                '" . $post_data['phone'] . "',
                '" . $post_data['email'] . "',
                '" . $post_data['gender'] . "',
                '" . $post_data['password'] . "',
                '" . date("Y-m-d", strtotime($post_data['dob'])) . "',
                '" . date("Y-m-d H:i:s") . "',
                '" . $post_data['profile_image'] . "'
            )";

        if ($this->conn->query($sql_users) === TRUE) {
            $user_id = $this->conn->insert_id; 

            $interests = implode(',', $post_data['interests']);
            $sql_details = "INSERT INTO user_details (user_id, country, document, interests)
                            VALUES (
                                '" . $user_id . "',
                                '" . $post_data['country'] . "',
                                '" . $post_data['document'] . "',
                                '" . $interests . "'
                            )";
            if (!$this->conn->query($sql_details) === TRUE) {
                return "Error inserting into user_details: " . $this->conn->error;
            }
            return 'Added Successfully';
        }
        else {
            return "Error inserting into users: " . $this->conn->error;
        }
    }  
    
    public function get_all_users_count() {
        $sql = "SELECT * FROM users";
        $result = $this->conn->query($sql);
        return $result->num_rows;
    }
    public function get_user_by_id($user_id) {
        $sql_user = "SELECT * FROM users WHERE id = '$user_id '";
        $result_user = $this->conn->query($sql_user);
        if ($result_user->num_rows > 0) {
            return $result_user->fetch_assoc();
        }
        return null;
    }

    public function change_password($id, $new_password,$confirm_password) {
        $change_password_sql = "UPDATE users SET password = '$new_password' WHERE id = '$id'";
        return $this->conn->query($change_password_sql);
    }

    public function ajax_delete($userId) {
        $delete_user_details_sql = "DELETE FROM user_details WHERE user_id = '$userId'";
        if ($this->conn->query($delete_user_details_sql) === TRUE) {
            $delete_user_sql = "DELETE FROM users WHERE id = '$userId'";
            if ($this->conn->query($delete_user_sql) === TRUE) {
                return ['status' => true, 'message' => "User deleted successfully!"];
            } else {
                return ['status' => false, 'message' => "Error deleting user: " . $this->conn->error];
            }
        } else {
            return ['status' => false, 'message' => "Error deleting user details: " . $this->conn->error];
        }
    }

    public function ajax_status($id, $status) {
        $status_update_sql = "UPDATE users SET status = '$status' WHERE id = '$id'";
        if ($this->conn->query($status_update_sql) === TRUE) {
            return ['status' => true, 'message' => "Status updated successfully!"];
        } else {
            return ['status' => false, 'message' => "Error updating status: " . $this->conn->error];
        }
    }

    public function forgotpassword($email) {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $new_password = bin2hex(random_bytes(5)); 
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

            $update_sql = "UPDATE users SET password = '$hashed_password' WHERE email = '$email'";

            if ($this->conn->query($update_sql) === TRUE) {
                return "Your new password is: <strong>$new_password</strong>";
            } else {
                return "Something went wrong. Please try again.";
            }
        } else {
            return "Email ID does not exist.";
        }
    }

    public function getTotalUsers_list() {
        $sql = "SELECT COUNT(*) as total FROM users";
        $result = $this->conn->query($sql);
        $data = $result->fetch_assoc();
        return $data['total'];
    }
    public function list_pagination($users_per_page, $offset) {
        $sql = "SELECT u.*, ud.document, ud.interests, ud.country, ud.about 
                FROM users u
                LEFT JOIN user_details ud ON u.id = ud.user_id";
               // LIMIT $users_per_page OFFSET $offset";

        $result = $this->conn->query($sql);
        $users = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        return $users;
    }

    public function register($name, $gender, $phone, $dob, $email, $password) {
        $created_at = date("Y-m-d H:i:s");
        $sql = "INSERT INTO users (`name`, `gender`, `phone`, `dob`, `email`, `password`, `created_at`) 
                VALUES ('$name', '$gender', '$phone', '$dob', '$email', '$password', '$created_at')";

        if ($this->conn->query($sql) === TRUE) {
            $user_id = $this->conn->insert_id;

            $sql_details = "INSERT INTO user_details (user_id) VALUES ('$user_id')";
            if ($this->conn->query($sql_details) === TRUE) {
                return true;
            } else {
                return "Error inserting into user details: " . $this->conn->error;
            }
        } else {
            return "Error inserting into users: " . $this->conn->error;
        }
    }

    public function view($user_id) {
        $sql = "SELECT users.*, user_details.country, user_details.interests, user_details.about, user_details.document 
                FROM users 
                LEFT JOIN user_details ON users.id = user_details.user_id 
                WHERE users.id = '$user_id'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function edit($id, $post_data, $profile_image = '', $document = '', $interests = '') {
        $sql = "UPDATE users 
                JOIN user_details ON user_details.user_id = users.id 
                SET 
                    `name` = '" . $post_data['name'] . "',
                    phone = '" . $post_data['phone'] . "',
                    email = '" . $post_data['email'] . "',
                    gender = '" . $post_data['gender'] . "',
                    dob = '" . date("Y-m-d", strtotime($post_data['dob'])) . "',
                    country = '" . $post_data['country'] . "',
                    about = '" . $post_data['about'] . "',
                    interests = '$interests'";
        
        if (!empty($profile_image)) {
            $sql .= ", profile_image = '$profile_image'";
        }
        
        if (!empty($document)) {
            $sql .= ", document = '$document'";
        }
        
        $sql .= " WHERE users.id = '$id'";
    
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return "Error updating record: " . $this->conn->error;
        }
    }
    public function edit_user($id) {
        $id = $this->conn->real_escape_string($id);
        $sql = "SELECT * FROM users JOIN user_details ON user_details.user_id = users.id WHERE users.id = '$id'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $user['interests'] = isset($user['interests']) ? explode(',', $user['interests']) : [];
            return $user;
        } else {
            return null; 
        }
    }
    
}
?>
