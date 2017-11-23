<?php
require_once 'sections/header.php';
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

} catch (Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch (Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

//echo $accessToken;
# If the
if (isset($accessToken)) {

    $_SESSION['facebook_access_token'] = $accessToken->getValue();
    // Logged in!
    // Now you can redirect to another page and use the
    // access token from $_SESSION['facebook_access_token']
    // But we shall we the same page
    // Sets the default fallback access token so
    // we don't have to pass it to each request

    $fb->setDefaultAccessToken($accessToken);
    try {

        $response = $fb->get('/me/?fields=albums', $accessToken)->getGraphNode()->asArray();

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

    ?>


    <div class="content">
        <div class="container">
            <?php

            if (isset($response)) { ?>
                <select name="albums_list" id="albums_list">

                    <?php
                    foreach ($response['albums'] as $album) { ?>
                        <option class="album_name"
                                value="<?php echo $album['id']; ?>"><?php echo $album['name']; ?></option>
                    <?php } ?>
                </select>

            <?php } ?>

            <div id="pics">

            </div>
        </div>
    </div>
    <?php
} else {
    $permissions = ['email'];
    $loginUrl = $helper->getLoginUrl($redirect, $permissions);
    echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
}

require_once 'sections/footer.php';