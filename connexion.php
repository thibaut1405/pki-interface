<?php

include('includes/menu.php');
?>

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PKI</title>

    <meta name="description" content="Free Bootstrap Theme by BootstrapMade.com">

    <meta name="keywords" content="free website templates, free bootstrap themes, free template, free bootstrap, free website template">



    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Fira+Sans|Roboto:300,400|Questrial|Satisfy">

    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="css/animate.css">

    <link rel="stylesheet" type="text/css" href="css/style.css">



</head>





<body>



<div class="margeConnexion">

    <div style="margin-top: -5%" class="container">



        <div class="row form_connexion">

            <div class="heading_connexion" style="text-align: center">

                <table style="width: 100%">

                    <tbody>

                    <td>

                        <p style="font-size: 4em;"><strong>CONNEXION</strong></p>

                    </td>

                    </tbody>

                </table>

            </div>

            <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2 col-lg-10 col-lg-offset-1">

                    <form action="check_connexion.php"

                          method="POST">

                        <div class="form-group">

                            <label for="username">Identifiant :</label>

                            <input type="text" class="form-control" id="identifiant" name="identifiant"

                                   placeholder="Identifiant" required>

                        </div>

                        <div class="form-group">

                            <label for="password">Mot de passe:</label>

                            <input type="password" class="form-control" id="password" name="password"

                                   placeholder="Mot de passe"

                                   required>

                        </div>

                        <button style="float: right" type="submit" class="btn btn-default col-md-2">Connexion</button>

                    </form>

            </div>

        </div>



    </div>

</div>

</body>
