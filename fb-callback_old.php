<?php
require_once 'sections/header.php';
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 11/22/2017
 * Time: 12:17 PM
 */

if (!session_id()) {
    session_start();
}

require_once __DIR__ . '/vendor/autoload.php';


$fb = new Facebook\Facebook([
    'app_id' => '369854136802846',
    'app_secret' => '054c5df47ed5fdb2f65120649e163cb4',
    'default_graph_version' => 'v2.11',
]);

$helper = $fb->getRedirectLoginHelper();

try {
    $accessToken = $helper->getAccessToken();

} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

if (! isset($accessToken)) {
    if ($helper->getError()) {
        header('HTTP/1.0 401 Unauthorized');
        echo "Error: " . $helper->getError() . "\n";
        echo "Error Code: " . $helper->getErrorCode() . "\n";
        echo "Error Reason: " . $helper->getErrorReason() . "\n";
        echo "Error Description: " . $helper->getErrorDescription() . "\n";
    } else {
        header('HTTP/1.0 400 Bad Request');
        echo 'Bad request';
    }
    exit;
}

// Logged in
echo '<h3>Access Token</h3>';
//var_dump($accessToken->getValue());

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
echo '<h3>Metadata</h3><pre>';
print_r($tokenMetadata);

// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId('369854136802846'); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

$user_id = $tokenMetadata->getUserId();

/*if (! $accessToken->isLongLived()) {

    try {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
        exit;
    }

    echo '<h3>Long-lived</h3>';
    var_dump($accessToken->getValue());
}*/

$_SESSION['fb_access_token'] = (string) $accessToken;

if($tokenMetadata->validateUserId($user_id)){
    $_SESSION['user_id'] = $user_id;
}else{
   // print_r($tokenMetadata);
}


try {
    // Returns a `Facebook\FacebookResponse` object
   // $albums = $fb->get($user_id.'/albums', $_SESSION['fb_access_token'])->getGraphEdge();

    $response = $fb->get(
        $user_id.'/albums',
        $_SESSION["fb_access_token"]
    );
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}
$graphNode = $response->getGraphEdge();

//$user = $response->getGraphUser();

//$albums = $fb->get('/me/albums', $_SESSION["fb_access_token"]);

echo "<pre>";
var_dump($graphNode);
require_once 'sections/footer.php';