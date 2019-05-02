<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="assets/css/connexion.css">

<!------ Include the above in your HEAD tag ---------->

<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="fadeIn first">
           <h1>Connexion</h1>
        </div>

        <!-- Login Form -->
        <form action="check_connexion.php" method="POST">

            <input type="text" id="identifiant" class="fadeIn second" name="identifiant" placeholder="identifiant" required>
            <input type="password" id="password" class="fadeIn third" name="password" placeholder="mot de passe" required>
            <input type="submit" class="fadeIn fourth" value="Se connecter">
        </form>
    </div>
</div>