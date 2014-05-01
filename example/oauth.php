<?php

require('SycamorePHP/sycamore.php');
require('SycamorePHP/GrantType/IGrantType.php');
require('SycamorePHP/GrantType/AuthorizationCode.php');

define("CLIENT_ID", 'YOUR_CLIENT_ID_HERE');
define("CLIENT_SECRET", 'YOUR_CLINET_SECRET_HERE');
define("SCOPE", "general individual");

define("REDIRECT_URI", 'YOUR_REDIRECT_URI_HERE');
define("AUTHORIZATION_ENDPOINT", 'https://www.sycamoreeducation.com/oauth/authorize.php');
define("TOKEN_ENDPOINT", 'https://www.sycamoreeducation.com/oauth/token.php');

$client = new OAuth2\Sycamore(CLIENT_ID, CLIENT_SECRET);

//if the code varialbe isn't present in the URL, start the OAuth dance
if (!isset($_GET['code'])){
        $auth_url = $client->getAuthenticationUrl(AUTHORIZATION_ENDPOINT, REDIRECT_URI, SCOPE);
        header('Location: ' . $auth_url);
        die('Redirect');
}else{
        $params = array('code' => $_GET['code'], 'redirect_uri' => REDIRECT_URI);
        //trade auth code for access token
        $response = $client->getAccessToken(TOKEN_ENDPOINT, 'authorization_code', $params);
      
        //returns json_decoded array with top level "result" array
        $token = $response["result"]["access_token"];
    
        //WARNING: in a production environment, you would want to store the access toke and refresh tokens in a database and NOT in the browser
        setcookie("auth_token", $token);

        //throw the user back to the index page
        header("Location: index.php");
}

?>
