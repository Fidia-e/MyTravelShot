<!DOCTYPE html>  

<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" href="../public/assets/images/favicon.svg" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  <title>My Travel Shot</title>

  	<!-- Bootstrap core css -->
  	<link rel="stylesheet" type="text/css" href="../public/assets/bootstrap/css/bootstrap.min.css">
  	<!-- Bootstrap core css -->
  	<link rel="stylesheet" type="text/css" href="../public/assets/css/style.css">
  	<!-- Magnific-popup css -->
  	<link rel="stylesheet" type="text/css" href="../public/assets/css/magnific-popup.css">
  	<!-- Font Awesome icons -->
  	<link rel="stylesheet" type="text/css" href="../public/assets/font-awesome/css/font-awesome.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body id="page-top">
    <div class="table-responsive">
        <table class="table text-center">
            <thead>
                <tr>
                <td><a class="link active" href="#" data-toggle="tab">Galerie</a></td>
                <td><a class="link" href="#" data-toggle="tab">Auteurs</a></td>
                <td><a class="link" href="#category3" data-toggle="tab">Endroits</a></td>
                </tr>
            </thead>
        </table>
        <hr>
    </div>
    <a href="<?= $router->generate('author-browse') ?>">LIEN</a>