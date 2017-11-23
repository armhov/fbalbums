<?php

if (!session_id()) {
    session_start();
}

require_once __DIR__ . '/vendor/autoload.php';

$fb = new Facebook\Facebook([
    'app_id' => '369854136802846',
    'app_secret' => '054c5df47ed5fdb2f65120649e163cb4',
    'default_graph_version' => 'v2.11',
]);
//$helper = $fb->getRedirectLoginHelper();

$album_id = $_POST['album_id'];
$name = $_POST['name'];

$accessToken = $_SESSION['facebook_access_token'];

if (isset($accessToken)) {

    $fb->setDefaultAccessToken($accessToken);
    try {

        //$photos = $fb->get("/{$album_id}/photos?fields=picture", $accessToken)->getGraphEdge()->asArray();
        $photos = $fb->get("/{$album_id}/photos?fields=images", $accessToken)->getGraphEdge()->asArray();
        if($photos){
            $response = json_encode($photos);
        }
        echo $response;

        // $userNode = $response->getGraphUser();
    } catch (Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }

}