<?php

include_once ROOT . '/models/User.php';

/**
* 
*/
class UserController
{


    public function actionIndex()
    {
        require_once(ROOT . '/views/user/index.php');

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
            }
            if (User::email_occupied($email)) {
                $errmsg .= 'This email is occupied!<br>';
            }
            if ($_POST['password'] !== $_POST['password-repeat']) {
                $errmsg .= 'Passwords do not match!<br>';
            }
//            else if (!User::password_is_complex($_POST['password'])) {
//                $errmsg .= 'Password should be at least 8 characters long, has 1 number and 1 character.';
//            }

            if (empty($errmsg)) {
                $db = DBConnection::getConnection();
                $validation_key = md5('42' . $email);
                $validation_link = $_SERVER['HTTP_ORIGIN'] . "/validate?key=$validation_key";
                $mailSubject = "Signing up to camagru - validate your account!";
                $mailBody = "Hi, $username!\n\n To validate your account click the following link: $validation_link";
                if (mail($email, $mailSubject, $mailBody)) {
                    $db->query("INSERT INTO users(username,email,password) VALUES('".$username."','".$email."','".hash('whirlpool', $_POST['password'])."')");
                    $message = "Signup Sucessfully! To finish registration check your email!";
                }
                else {
                    $errmsg .= "Sign up failed! Some error with sending email to your address. Try again later.";
                }
            }

        }

        require_once(ROOT . '/views/user/signup.php');

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
            require_once(ROOT . '/views/user/validate.php');
        }
        else {
            //redirect home or message smth
        }

        return true;
    }

    public function actionLogin()
    {
        if (!empty($_POST['username']) && !empty($_POST['password'])) {
            $user = new User($_POST['username']);
            $pwd = $_POST['password'];

            if ($user->username && $user->password_correct($pwd)) {
                if ($user->active) {
                    $_SESSION['logged'] = $user->username;

                }
                else {
                    $err_msg = "This account isn't activated yet. Check your email and activate again";
                }
            }
            else {
                $err_msg = "Incorrect username or password!";
            }
        }

        require_once(ROOT . '/views/user/login.php');

        return true;
    }

    public function actionLogout() {
        session_destroy();

        // redirects to the /login page with using s JS.
        echo '<script>window.location="/login"</script>';

        return true;
    }

    public function actionSettings()
    {
        require_once(ROOT . '/views/user/settings.php');

        return true;
    }

	function __construct()
	{
		# code...
	}
}