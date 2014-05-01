<?php

if( (isset($_POST)) && (isset($_POST['logout'])) && (!empty($_POST['logout'])) ){

    setcookie("auth_token", "", time()-3600);

}elseif($_COOKIE['auth_token']){

    require('SycamorePHP/sycamore.php');

    define("CLIENT_ID", 'YOUR_CLIENT_ID_HERE');
    define("CLIENT_SECRET", 'YOUR_CLINET_SECRET_HERE');
    
    $client = new OAuth2\Sycamore(CLIENT_ID, CLIENT_SECRET);
    $client->setAccessToken($_COOKIE['auth_token']);
    $me = $client->fetch("/Me");

}

?>

<!doctype html>
<head>
    <meta charset="utf-8">
    <title>Sycamore OAuth PHP Demo</title>
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
    <style>
        body {
            padding-top: 50px;
        }
    
        .starter-template {
            padding: 40px 15px;
            text-align: center;
        }
    
        #results {
            text-align: center;
        }
    
        pre {
            margin: 25px;
        }

        .keypair {
            display: block;
        }
    </style>
</head>
<body>

<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Sycamore OAuth PHP Demo</a>
        </div>
        <div class="collapse navbar-collapse">
<?php
    if($me) {
        echo "<form name='auth_form' class='navbar-form navbar-right' action='index.php' method='post' role='form'>";
        echo "<button type='submit' name='logout' class='btn btn-success'>Sign Out</button>";
        echo "<input type='hidden' name='logout' value=1 />";
        echo "</form>";
    }else{
        echo "<a id='login' href='oauth.php' class='navbar-form navbar-right'><button type='button' class='btn btn-success'>Login with Sycamore</button></a>";
    }
?>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">
        <div class="starter-template">
            <h1>Sycamore OAuth2.0 PHP Example </h1>
            <p class="lead">Click on the 'Login With Sycamore' button to prompt a user for authorization.<br> Once redirected, a button will be enabled to poll the Sycamore API and return data.</p>
        </div>

        <div id="results">
<?php
    if($me){
        echo "<p>Here is your personal information:</p>";
        echo "<pre>";
        foreach($me['result'] as $key => $value){
            echo "<span class='keypair'>$key => $value </span>";
        }        
        echo "</pre>";
    }else{
        echo "<p>Please log in to see your personal information</p>";
    }
?>
        </div>
    </div><!-- /.container -->

</body>
</html>



