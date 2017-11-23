<?php
require_once 'sections/header.php';
session_start();
# Autoload the required files
require_once __DIR__ . '/vendor/autoload.php';

$fb = new Facebook\Facebook([
    'app_id' => '369854136802846',
    'app_secret' => '054c5df47ed5fdb2f65120649e163cb4',
    'default_graph_version' => 'v2.11',
]);

$redirect = 'http://localhost/fbalbums/fb-callback.php';

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email', 'user_photos']; // Optional permissions
$loginUrl = $helper->getLoginUrl($redirect, $permissions);

echo '<div class="container text-center"><a class="btn-primary btn fb-login" href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a></div>';
require_once 'sections/footer.php';
?>


</body>
</html>

