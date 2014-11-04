<?php

//require the SycamorePHP library
require('../src/SycamorePHP/Sycamore.php');

//add your applications ID and secret here
define("CLIENT_ID", "YOUR_CLIENT_ID_HERE");
define("CLIENT_SECRET", "YOUR_CLIENT_SECRET_HERE");

//set the scopes that you want to request
define("SCOPE", "general individual");

//this is the URL that the OAuth server will post information back to
define("REDIRECT_URI", "http://127.0.0.1:8080/OAuthPHP/example/oauth.php");

//These should not need to be changed, so don't do it. =)
define("AUTHORIZATION_ENDPOINT", 'https://app.sycamoreeducation.com/oauth/authorize');
define("TOKEN_ENDPOINT", 'https://app.sycamoreeducation.com/oauth/token');

//create new instance of the client
$client = new OAuth2\Sycamore(CLIENT_ID, CLIENT_SECRET);

//if the code varialbe isn't present in the URL, start the OAuth dance
if (!isset($_GET['code'])){
        $auth_url = $client->getAuthenticationUrl(AUTHORIZATION_ENDPOINT, REDIRECT_URI, SCOPE);

        //redirect the browser to Sycamore School's OAuth login page
        header('Location: ' . $auth_url);
        die('Redirect');
}else{
        $params = array('code' => $_GET['code'], 'redirect_uri' => REDIRECT_URI);

        //trade auth code for access token
        $response = $client->getAccessToken(TOKEN_ENDPOINT, 'authorization_code', $params);

        //returns json_decoded array with top level "result" array
        $token = $response["result"]["access_token"];

        //store access token in cookie for use later
        setcookie("auth_token", $token);

        /*
         * WARNING: in a production environment, you would want to store the
         * access token in a database and NOT in the browser
         */

        //throw the user back to the index page
        header("Location: index.php");
}

?>
