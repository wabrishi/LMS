<?php
class UserController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function register() {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $username_err = $email_err = $password_err = "";

        if(empty($username)){
            $username_err = "Please enter a username.";
        } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', $username)){
            $username_err = "Username can only contain letters, numbers, and underscores.";
        } else{
            // Prepare a select statement
            $sql = "SELECT id FROM users WHERE username = ?";

            if($stmt = mysqli_prepare($this->db, $sql)){
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                $param_username = $username;
                if(mysqli_stmt_execute($stmt)){
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) == 1){
                        $username_err = "This username is already taken.";
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
                mysqli_stmt_close($stmt);
            }
        }

        if(empty($email)){
            $email_err = "Please enter an email.";
        } else {
            // Prepare a select statement
            $sql = "SELECT id FROM users WHERE email = ?";

            if($stmt = mysqli_prepare($this->db, $sql)){
                mysqli_stmt_bind_param($stmt, "s", $param_email);
                $param_email = $email;
                if(mysqli_stmt_execute($stmt)){
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) == 1){
                        $email_err = "This email is already taken.";
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
                mysqli_stmt_close($stmt);
            }
        }

        if(empty($password)){
            $password_err = "Please enter a password.";
        } elseif(strlen($password) < 6){
            $password_err = "Password must have atleast 6 characters.";
        }

        if(empty($username_err) && empty($email_err) && empty($password_err)){
            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            if($stmt = mysqli_prepare($this->db, $sql)){
                mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_email, $param_password);

                $param_username = $username;
                $param_email = $email;
                $param_password = password_hash($password, PASSWORD_DEFAULT);

                if(mysqli_stmt_execute($stmt)){
                    $user_id = mysqli_insert_id($this->db);
                    // Assign default role to user
                    $sql_role = "INSERT INTO user_roles (user_id, role_id) VALUES (?, (SELECT id FROM roles WHERE name = 'Student'))";
                    if($stmt_role = mysqli_prepare($this->db, $sql_role)){
                        mysqli_stmt_bind_param($stmt_role, "i", $user_id);
                        mysqli_stmt_execute($stmt_role);
                        mysqli_stmt_close($stmt_role);
                    }
                    return true;
                } else{
                    return ["Oops! Something went wrong. Please try again later."];
                }

                mysqli_stmt_close($stmt);
            }
        }

        return [
            'username_err' => $username_err,
            'email_err' => $email_err,
            'password_err' => $password_err,
            'username' => $username,
            'email' => $email,
        ];
    }

    public function login() {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        $username_err = $password_err = $login_err = "";

        if(empty($username)){
            $username_err = "Please enter username.";
        }

        if(empty($password)){
            $password_err = "Please enter your password.";
        }

        if(empty($username_err) && empty($password_err)){
            $sql = "SELECT id, username, password FROM users WHERE username = ?";
            if($stmt = mysqli_prepare($this->db, $sql)){
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                $param_username = $username;
                if(mysqli_stmt_execute($stmt)){
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) == 1){
                        mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                        if(mysqli_stmt_fetch($stmt)){
                            if(password_verify($password, $hashed_password)){
                                session_start();
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;

                                // Get user role
                                $sql_role = "SELECT r.name FROM roles r JOIN user_roles ur ON r.id = ur.role_id WHERE ur.user_id = ?";
                                if($stmt_role = mysqli_prepare($this->db, $sql_role)){
                                    mysqli_stmt_bind_param($stmt_role, "i", $id);
                                    mysqli_stmt_execute($stmt_role);
                                    mysqli_stmt_bind_result($stmt_role, $role_name);
                                    mysqli_stmt_fetch($stmt_role);
                                    $_SESSION["role"] = $role_name;
                                    mysqli_stmt_close($stmt_role);
                                }

                                return true;
                            } else{
                                $login_err = "Invalid username or password.";
                            }
                        }
                    } else{
                        $login_err = "Invalid username or password.";
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
                mysqli_stmt_close($stmt);
            }
        }

        return [
            'username_err' => $username_err,
            'password_err' => $password_err,
            'login_err' => $login_err,
            'username' => $username,
        ];
    }
}
?>
