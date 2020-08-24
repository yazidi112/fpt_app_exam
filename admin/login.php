<?php
session_start();
if(isset($_POST['user'])){
	if($_POST['user']=="admin" and $_POST['pwd']=="adminexamen2020"){
		$_SESSION["username"] = "admin" ;
		header("Location: index.php");
	}else{
		echo"Nom d'utilisateur ou Mot de passe incorrect";
	}
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Gestion Examen</title>
    </head>
    <body>
        
        
        <div style="margin:auto;width:400px;margin-top:100px">
			<h2>Exmaens <small>Connexion</small></h2>
            <form method="post">  
                <div class="form-group">
                    <label>Nom d'utilisateur</label>
                    <input type="text" class="form-control" name="user">
                </div>
				<div class="form-group">
                    <label>Mot de passe</label>
                    <input type="password" class="form-control" name="pwd">
                </div>
                <input type="submit" class="btn btn-primary" value="Connexion" />
            </form>
        </div>
        <div class="container">
         
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>

