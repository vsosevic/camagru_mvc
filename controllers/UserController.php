<?php

include_once ROOT . '/models/User.php';

/**
* 
*/
class UserController
{

    public function actionIndex()
    {
        if (empty($_SESSION['logged_id_user'])) {
            header('location: /login');
            return;
        }

        include_once (ROOT . '/views/layouts/header.php');
        require_once(ROOT . '/views/user/index.php');
        include_once (ROOT . '/views/layouts/footer.php');

        return true;
    }

    public function actionSignup()
    {
        if (!empty($_POST)) {
            $username = User::string_delete_db_injection($_POST['username']);
            $email = User::string_delete_db_injection($_POST['email']);
            $errmsg = '';

            if (User::username_occupied($username)) {
                $errmsg .= 'This usernmae is occupied!<br>';
                unset($_POST['username']);
            }
            if (User::email_occupied($email)) {
                $errmsg .= 'This email is occupied!<br>';
                unset($_POST['email']);
            }
            if ($_POST['password'] !== $_POST['password-repeat']) {
                $errmsg .= 'Passwords do not match!<br>';
            }
            else if (!User::password_is_complex($_POST['password'])) {
                $errmsg .= 'Password should be at least 8 characters long, has 1 number and 1 character.';
            }

            if (empty($errmsg)) {
                $db = DBConnection::getConnection();
                $validation_key = md5('42' . $email);
                $validation_link = $_SERVER['HTTP_ORIGIN'] . "/validate/$validation_key";
                $mailSubject = "Signing up to camagru - validate your account!";
                $mailBody = "Hi, $username!\n\n To validate your account click the following link: $validation_link";
                if (mail($email, $mailSubject, $mailBody)) {
                    $db->query("INSERT INTO users(username,email,password) VALUES('$username','$email','".hash('whirlpool', $_POST['password'])."')");
                    $message = "Signup Sucessfully! To finish registration check your email!";
                }
                else {
                    $errmsg .= "Sign up failed! Some error with sending email to your address. Try again later.";
                }
            }
        }

        include_once (ROOT . '/views/layouts/header.php');
        require_once(ROOT . '/views/user/signup.php');
        include_once (ROOT . '/views/layouts/footer.php');

        return true;
    }

    public function actionValidate($validation_key = NULL) {
        if (!empty($validation_key)) {
            $db = DBConnection::getConnection();
            $q = $db->prepare("SELECT * FROM users WHERE md5(concat(\"42\", email))=?");
            $q->execute(array($validation_key));
            $user = $q->fetch(PDO::FETCH_OBJ);

            if (isset($user->email)) {
                $email = "'" . $user->email . "'";
                $db->query("UPDATE users SET active=1 WHERE email=$email");
            }
            else {
                $errmsg = "Invalid validation key!";
            }

            include_once (ROOT . '/views/layouts/header.php');
            require_once(ROOT . '/views/user/validate.php');
            include_once (ROOT . '/views/layouts/footer.php');
        }

        return true;
    }

    public function actionLogin()
    {
        if (!empty($_POST['username']) && !empty($_POST['password'])) {

            $id_user = User::get_user_id_by_username($_POST['username']);

            $user = new User($id_user);
            $pwd = $_POST['password'];

            if ($user->username && $user->password_correct($pwd)) {
                if ($user->active) {
                    $_SESSION['logged_id_user'] = $user->id_user;
                }
                else {
                    $err_msg = "This account isn't activated yet. Check your email and activate again";
                }
            }
            else {
                $err_msg = "Incorrect username or password!";
            }
        }

        include_once (ROOT . '/views/layouts/header.php');
        require_once(ROOT . '/views/user/login.php');
        include_once (ROOT . '/views/layouts/footer.php');

        return true;
    }

    public function actionForgot() {
        include_once (ROOT . '/views/layouts/header.php');
        require_once(ROOT . '/views/user/forgot.php');
        include_once (ROOT . '/views/layouts/footer.php');
    }

    public function actionForgotReset($email = NULL) {
        if (isset($_POST['email']) || $email !== NULL) {

            if (isset($_POST['email'])) {
                $email = User::string_delete_php_injection($_POST['email']);
            }

            $reset_key = User::generate_reset_key($email);
            $mailSubject = "Camagru - reset password.";
            $mailBody = "You have requested to reset your password to your account. Your reset key: $reset_key";
            if (mail($email, $mailSubject, $mailBody)) {
                $message = "Check your email to enter reset key here.";
            }
            else {
                $errmsg = "Some error occurred with sending email to your address. Try again later or contact admin";
            }
        }
        if (isset($_POST['new-password']) && isset($_POST['reset-key'])) {
            if (User::password_is_complex($_POST['new-password'])) {
                User::change_password_by_reset_key($_POST['new-password'], $_POST['reset-key']);
                $message = "Password changed successfully!";
                $message .= empty($_SESSION['logged_id_user']) ?  "Now you can try to <a href='/login'>Login</a>" : '';
            }
            else {
                $errmsg = "Password should be at least 8 characters long, has 1 number and 1 character.";
            }
        }

        include_once (ROOT . '/views/layouts/header.php');
        require_once(ROOT . '/views/user/forgot-reset.php');
        include_once (ROOT . '/views/layouts/footer.php');
    }

    public function actionLogout() {
        session_destroy();

        // redirects to the /login page with using s JS.
        echo '<script>window.location="/login"</script>';

        return true;
    }

    public function actionSettings()
    {
        if (empty($_SESSION['logged_id_user'])) {
            header('location: /login');
            return;
        }

        if (!empty($_POST['email']) && !empty($_POST['username'])) {
            $db = DBConnection::getConnection();

            $id_user = $_SESSION['logged_id_user'];
            $username = User::string_delete_db_injection($_POST['username']);
            $email = User::string_delete_db_injection($_POST['email']);
            $receive_notifications = isset($_POST['receive-notifications']) ? 1 : 0;
            $errmsg = '';
            $message = '';

            $old_user = new User($id_user);

            if ($old_user->email == $email) { // no changes made
                // do nothing
            }
            else if (!User::email_occupied($email)) {
                $db->query("UPDATE users SET email='$email' WHERE id_user=$id_user");
                $message .= "Email changed successfully! <br>";
            }
            else {
                $errmsg .= "This email is occupied! <br>";
            }

            if ($old_user->username == $username) { // no changes made
                //do nothing
            }
            else if (!User::username_occupied($username)) {
                $db->query("UPDATE users SET username='$username' WHERE id_user=$id_user");
                $message .= "Username changed successfully! <br>";
            }
            else {
                $errmsg .= "This username is occupied! <br>";
            }

            if ($old_user->receive_notifications != $receive_notifications) {
                $db->query("UPDATE users SET receive_notifications='$receive_notifications' WHERE id_user=$id_user");
                $message .= "Settings were saved!";
            }

        }

        $user = new User($_SESSION['logged_id_user']);

        include_once (ROOT . '/views/layouts/header.php');
        require_once(ROOT . '/views/user/settings.php');
        include_once (ROOT . '/views/layouts/footer.php');

        return true;
    }

}