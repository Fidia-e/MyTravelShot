<!DOCTYPE html>  

<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" href="<?= $assetsBaseUri ?>images/favicon.svg" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  <title>My Travel Shot</title>

  	<!-- Bootstrap core css -->
  	<link rel="stylesheet" type="text/css" href="<?= $assetsBaseUri ?>bootstrap/css/bootstrap.min.css">
  	<!-- Bootstrap core css -->
  	<link rel="stylesheet" type="text/css" href="<?= $assetsBaseUri ?>css/style.css">
  	<!-- Magnific-popup css -->
  	<link rel="stylesheet" type="text/css" href="<?= $assetsBaseUri ?>css/magnific-popup.css">
  	<!-- Font Awesome icons -->
  	<link rel="stylesheet" type="text/css" href="<?= $assetsBaseUri ?>font-awesome/css/font-awesome.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body id="page-top">

<!-- Navigation Bar -->
<nav class="navbar navbar-fixed-top navbar-default">
     <div class="container">
         <div class="navbar-header">
             <h3 class="Logo">My Travel Shot</h3>
         </div>
         <div class="collapse navbar-collapse navbar-right" id="menu">
            <ul class="nav navbar-nav">
              <li class="active lien"><a href="<?= $router->generate('main-home') ?>"><i class="fa fa-camera sr-icons"></i> Galerie</a></li>
              <li class=" lien"><a href="<?= $router->generate('author-browse') ?>"><i class="fa fa-pencil sr-icons"></i> Par auteur</a></li>
              <li class=" lien"><a href="<?= $router->generate('admin-login') ?>"><i class="fa fa-user sr-icons"></i> Back Office</a></li>
              <li class=" lien"><a href="<?+ $router->generate('admin-logout') ?>"><i class="fa fa-user sr-icons"></i> Déconnexion</a></li>
            </ul>
         </div>
     </div>
   </nav>
<!-- End of Navigation Bar -->
