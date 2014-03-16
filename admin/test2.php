<?php
//require_once("../inc/application.php");
require_once('../inc/setup.inc.php');


$page = new Page();


// phpinfo();
 // if (session_status() == PHP_SESSION_NONE) {
    // session_start();
// }

// setcookie('test1', 'value', time()+60*60*24*365, '/');



// print_r(session_get_cookie_params());

// if ( !is_writable(session_save_path()) ) {
//    echo 'Session save path "'.session_save_path().'" is not writable!'; 
// }

//echo 'session id: '.session_id();

//   print_r($_SESSION);
//   if (!array_key_exists('test', $_SESSION)) {
//     echo 'setting test';
//     $_SESSION['test'] = 'foo';
//   }

// exit();
  // Remember to copy files from the SDK's src/ directory to a
  // directory in your application on the server, such as php-sdk/
  require_once('../inc/facebook-sdk/facebook.php');

  $config = array(
    'appId' => '405216726278675',
    'secret' => '1e677d512a76fac8ea474f5df4445268',
    'allowSignedRequest' => false // optional but should be set to false for non-canvas apps
  );
try {
  $facebook = new Facebook($config);
  $user_id = $facebook->getUser();
} catch (Exception $e) {
  print_r($e);
}
print_r($user_id);

?>
<html>
  <head></head>
  <body>

  <?php
    if($user_id) {

      // We have a user ID, so probably a logged in user.
      // If not, we'll get an exception, which we handle below.
      try {

        $user_profile = $facebook->api('/me','GET');
        echo "Name: " . $user_profile['name'];
        print_r($user_profile);
      } catch(FacebookApiException $e) {
        // If the user is logged out, you can have a 
        // user ID even though the access token is invalid.
        // In this case, we'll get an exception, so we'll
        // just ask the user to login again here.
        $login_url = $facebook->getLoginUrl(); 
        

        echo 'Please <a href="' . $login_url . '">login.</a>';
        error_log($e->getType());
        error_log($e->getMessage());
      }   
    } else {

      // No user, print a link for the user to login
      $login_url = $facebook->getLoginUrl();
      echo 'Please <a href="' . $login_url . '">login.</a>';
    }
$ret = $facebook->api('/me', 'GET', array('fields'=>array('picture')));
  print_r($ret);
  ?>

  <img src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-prn1/50100_1181255135_8931_q.jpg" />

<?php
$page->end();
?>
