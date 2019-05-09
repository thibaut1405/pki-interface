<?php
    include('check_connexion.php');

?>
<!doctype html>
<html lang="fr">

<head>
	<title>MTV PKI</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/vendor/linearicons/style.css">
	<link rel="stylesheet" href="assets/vendor/chartist/css/chartist-custom.css">
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/demo.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
</head>

<?php
    if (!isset($_SESSION)) {
        session_start();
    }

    if (empty($_SESSION['connected'])) {
        $login = 0;
        header('Location: connexion.php');
    } else {

        $login = 1;
        $pers = $bdd->prepare('SELECT admin, identifiant, nom, prenom  FROM personne WHERE id = :id ');
        $pers->execute(array(
            'id' => $_SESSION['id'],
        ));
        $personne = $pers->fetch();
        if ($personne['admin'] == 1) {
            $cert = $bdd->prepare('SELECT path_certificate, nom, prenom, state_certificate, fqdn_certificate FROM certificates INNER JOIN personne ON personne.id = certificates.id_demandeur');
            $cert->execute();
        } else {
            $cert = $bdd->prepare('SELECT path_certificate, nom, prenom, state_certificate, fqdn_certificate FROM certificates INNER JOIN personne ON personne.id = certificates.id_demandeur WHERE id = :id');
            $cert->execute(array(
                'id' => $_SESSION['id']
            ));
        }
    }
?>


<body>
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand">
				<b>MTV PKI</b>
			</div>
            <div class="container-fluid">
                <div class="navbar-btn">
                    <button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
                </div>
                <div id="navbar-menu">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                        <li><a><i class="lnr lnr-user"></i> <span><?php echo $personne['prenom'] . " " . $personne['nom']?></span></a></li>
                        </li>
                        <li class="dropdown">
                        <li><a href="deconnexion.php"><i class="lnr lnr-exit"></i> <span>Déconnexion</span></a></li>
                        </li>
                    </ul>
                </div>
            </div>
		</nav>
        <div id="sidebar-nav" class="sidebar">
            <div class="sidebar-scroll">
                <nav>
                    <ul class="nav">
                        <li><a href="index.php" class=""><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
                        <li><a href="importCSR.php" class=""><i class="lnr lnr-download"></i> <span>Importer CSR</span></a></li>
                        <li><a href="listeCSR.php" class="active"><i class="lnr lnr-list"></i> <span>Lister CSR</span></a></li>
                        <?php if ($personne['admin'] == 1) {
                            ?>
                            <li><a href="signerCSR.php" class=""><i class="lnr lnr-pencil"></i> <span>Signer CSR</span></a></li>
                            <?php
                        }
                        ?>
                        <li><a href="listeCertificats.php" class=""><i class="lnr lnr-lock"></i> <span>Lister Certificats</span></a></li>
                        <?php if ($personne['admin'] == 1) {
                            ?>
                            <li><a href="revoquerCertificat.php" class=""><i class="lnr lnr-trash"></i> <span>Révoquer Certificat</span></a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
		<div class="main">
			<div class="main-content">
				<div class="container-fluid">
					<div class="panel panel-headline">
                        <div class="panel-heading">
                            <h3 class="panel-title">Demandes de Certificat</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="panel">
                                    <div class="panel-body no-padding">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nom de la demande</th>
                                                    <th>FQDN</th>
                                                    <th>Nom du demandeur</th>
                                                    <th>Prénom du demandeur</th>
                                                    <th>Statut</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($lesCerts = $cert->fetch()) {
                                                    ?>
                                                    <tr>
                                                        <td class="col-md-3"><strong><?php echo $lesCerts['path_certificate'] ?></strong></td>
                                                        <td class="col-md-2"><?php echo $lesCerts['fqdn_certificate']?></td>
                                                        <td class="col-md-2"><?php echo $lesCerts['nom']?></td>
                                                        <td class="col-md-3"><?php echo $lesCerts['prenom']?></td>
                                                        <td class="col-md-1">
                                                            <?php
                                                                if ($lesCerts['state_certificate'] == 0) {
                                                                    echo "<span class='label label-info'>En attente</span>";

                                                                } elseif ($lesCerts['state_certificate'] == true) {
                                                                    echo "<span class='label label-success'>Acceptée</span>";
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="col-md-1">
                                                            <?php
                                                                if ($personne['admin'] == 1) {
                                                                    ?>
                                                                    <button>
                                                                        <a href="verifyCSR.php?fqdn=<?php echo $lesCerts['fqdn_certificate'] ?>">Vérifier</a>
                                                                    </button>
                                                                    <?php
                                                                } elseif ($personne['admin'] == 0) {
                                                                    echo "";
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<footer>
			<div class="container-fluid">
				<p class="copyright">&copy; 2019 MTV PKI</p>
			</div>
		</footer>
	</div>
	<script src="assets/vendor/jquery/jquery.min.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
	<script src="assets/vendor/chartist/js/chartist.min.js"></script>
	<script src="assets/scripts/klorofil-common.js"></script>
	<script>
        function bs_input_file() {
            $(".input-file").before(
                function() {
                    if ( ! $(this).prev().hasClass('input-ghost') ) {
                        var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");
                        element.attr("name",$(this).attr("name"));
                        element.change(function(){
                            element.next(element).find('input').val((element.val()).split('\\').pop());
                        });
                        $(this).find("button.btn-choose").click(function(){
                            element.click();
                        });
                        $(this).find("button.btn-reset").click(function(){
                            element.val(null);
                            $(this).parents(".input-file").find('input').val('');
                        });
                        $(this).find('input').css("cursor","pointer");
                        $(this).find('input').mousedown(function() {
                            $(this).parents('.input-file').prev().click();
                            return false;
                        });
                        return element;
                    }
                }
            );
        }
        $(function() {
            bs_input_file();
        });
	</script>
</body>

</html>
