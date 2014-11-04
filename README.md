# Sycamore School PHP OAuth Library

You can sign up for a Sycamore Developer account at https://app.sycamoreeducation.com/developer/.

## Requirements

PHP 5.2 and later.

## Installation

Obtain the latest version of the Sycamore OAuth PHP library with:

    git clone https://github.com/SycamoreEducation/OAuthPHP

To use the bindings, add the following to your PHP script:

    require_once("/path/to/sycamore-php/lib/Sycamore.php");

## Getting Started

Simple usage looks like:

    define("CLIENT_ID", 'YOUR_CLIENT_ID_HERE');
    define("CLIENT_SECRET", 'YOUR_CLINET_SECRET_HERE');
    define("SCOPE", "general individual");

    define("REDIRECT_URI", 'YOUR_REDIRECT_URI_HERE');
    define("AUTHORIZATION_ENDPOINT", 'https://app.sycamoreeducation.com/oauth/authorize.php');
    define("TOKEN_ENDPOINT", 'https://app.sycamoreeducation.com/oauth/token.php');

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

## Documentation

Please see http://api.sycamoresupport.com for up-to-date documentation.
