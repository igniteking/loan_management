<?php

function Login($conn, $email, $pwd)
{
    if (empty($email) || empty($pwd)) {
        Toast('info', 'Username and Password are Empty!');
    } else {
        $sql = "SELECT * FROM user_data WHERE user_email='$email'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck < 1) {
            echo "<p style='padding: 10px; margin: 10px; font-size: 14px; color: #fff; font-weight: 600; border-radius: 8px; text-align: center; background: #ff7474;'>E-mail is Incorrect!</p>";
        } else {
            if ($row = mysqli_fetch_assoc($result)) {
                $id_login = $row['id'];
                $email_login = $row['user_email'];
                $password_login = $row['user_password'];
                //dehashing the password        
                $hashedPwdCheck = password_verify($pwd, $row['user_password']);
                if ($hashedPwdCheck == false) {
                    echo "<p style='padding: 10px; margin: 10px; font-size: 14px; color: #fff; font-weight: 600; border-radius: 8px; text-align: center; background: #ff7474;'>Password is Incorrect!!</p>";
                } elseif ($hashedPwdCheck == true) {
                    $session_token = md5(time() . $email_login);
                    $_SESSION['id'] = $id_login;
                    $_SESSION['user_email'] = $email_login;
                    $_SESSION['user_password'] = $password_login;
                    echo "<meta http-equiv=\"refresh\" content=\"0; url=../index.php?status=1\">";
                    exit();
                }
            } else {
                echo "ERROR";
            }
        }
    }
}

function Register($user_type, $username, $password, $r_pswd, $conn, $email, $ip)
{
    if (filter_var($ip, FILTER_VALIDATE_IP)) {
        if ($username && $password && $r_pswd && $user_type) {
            $user_check2 = "SELECT user_email from user_data WHERE user_email='$email'";
            $result2 = mysqli_query($conn, $user_check2);
            $result_check2 = mysqli_num_rows($result2);
            if (!$result_check2 > 0) {
                if ($password == $r_pswd) {
                    if (preg_match("/\d/", $password)) {
                        if (preg_match("/[A-Z]/", $password)) {
                            if (preg_match("/[a-z]/", $password)) {
                                if (preg_match("/\W/", $password)) {
                                    $date = date('Y-m-d H:i:s');
                                    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                                    mysqli_query($conn, "INSERT INTO `user_data`(`id`, `user_name`, `user_email`, `user_password`, `user_type`, `ip`, `created_at`) VALUES 
                                (NULL,'$username','$email','$hashedPwd','$user_type', '$ip', '$date')");
                                    echo "<meta http-equiv=\"refresh\" content=\"0; url=login.php?status=1\">";
                                } else {
                                    echo "<div class='error-styler'><center>
                                        <p style='padding: 10px; margin: 10px; font-size: 14px; color: #fff; font-weight: 600; border-radius: 8px; text-align: center; background: #ff7474;'>Password should contain at least one special character!</p>;
                                        </center></div>";
                                }
                            } else {
                                echo "<div class='error-styler'><center>
                                    <p style='padding: 10px; margin: 10px; font-size: 14px; color: #fff; font-weight: 600; border-radius: 8px; text-align: center; background: #ff7474;'>Password should contain at least one small Letter</p>
                </center></div>";
                            }
                        } else {
                            echo "<div class='error-styler'><center>
                                <p style='padding: 10px; margin: 10px; font-size: 14px; color: #fff; font-weight: 600; border-radius: 8px; text-align: center; background: #ff7474;'>Password should contain at least one Capital Letter</p>
                </center></div>";
                        }
                    } else {
                        echo "<div class='error-styler'><center>
                            <p style='padding: 10px; margin: 10px; font-size: 14px; color: #fff; font-weight: 600; border-radius: 8px; text-align: center; background: #ff7474;'>Password should contain at least one digit</p>
            </center></div>";
                    }
                } else {
                    echo "<div class='error-styler'><center>
                        <p style='padding: 10px; margin: 10px; font-size: 14px; color: #fff; font-weight: 600; border-radius: 8px; text-align: center; background: #ff7474;'>Both Password's Dont Match!</p>
            </center></div>";
                }
            } else {
                echo "<div class='error-styler'><center>
                    <p style='padding: 10px; margin: 10px; font-size: 14px; color: #fff; font-weight: 600; border-radius: 8px; text-align: center; background: #ff7474;'>E-mail already exist!</p>
            </center></div>";
            }
        } else {
            echo "<div class='error-styler'><center>
                <p style='padding: 10px; margin: 10px; font-size: 14px; color: #fff; font-weight: 600; border-radius: 8px; text-align: center; background: #ff7474;'>Please Fill In All Fields!</p>
            </center></div>";
        }
    }
}

function Logout()
{
    include("includes/connection.php");
    session_start();
    session_unset();
    session_destroy();
    header("Location: login.php");
}

function Notifications($notificationType, $title, $message)
{
    echo "<script>
    $(function() {
        $(document).Toasts('create', {
            class: 'bg-$notificationType',
            title: '$title',
            body: '$message',
        });
    })
</script>";
}

function Toast($notificationType, $message)
{
    echo "
    <script>
        Toastify({
            text: '$message',
            duration: 3000,
            close: true,
            gravity: 'top',
            position: 'center',
            stopOnFocus: true, // Prevents dismissing of toast on hover
            backgroundColor: '#4fbe87',
            onClick: function() {} // Callback after click
        }).showToast();
    </script>";
}

// delete all files and sub-folders from a folder
function deleteAll($dir)
{
    foreach (glob($dir . '/*') as $file) {
        if (is_dir($file))
            deleteAll($file);
        else
            unlink($file);
    }
    rmdir($dir);
}

function security_check($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
