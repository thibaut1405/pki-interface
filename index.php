<?php
    include('includes/connexion.php');

?>
<!doctype html>
<html lang="fr">

<head>
	<title>MTVP PKI</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/vendor/linearicons/style.css">
	<link rel="stylesheet" href="assets/vendor/chartist/css/chartist-custom.css">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="assets/css/main.css">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="assets/css/demo.css">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
</head>

<?php if (!isset($_SESSION)) {
    session_start();
    }
?>

<?php

    if (empty($_SESSION['connected'])) {

        $login = 0;

    } else {

        $login = 1;
        $pers = $bdd->prepare('SELECT admin FROM personne WHERE id = :id ');
        $pers->execute(array(
            'id' => $_SESSION['id'],
        ));
        $personne = $pers->fetch();
        if ($personne['admin'] == 1) {
            $cert = $bdd->prepare('SELECT path_certificate, nom, prenom, state_certificate FROM certificates INNER JOIN personne ON personne.id = certificates.id_demandeur');
            $real_cert = $bdd->prepare('SELECT path_real_certificate, nom, prenom, state_real_certificate FROM real_certificates INNER JOIN personne ON personne.id = real_certificates.id_demandeur');

            $real_cert->execute();
            $cert->execute();
        } else {
            $cert = $bdd->prepare('SELECT path_certificate, nom, prenom, state_certificate FROM certificates INNER JOIN personne ON personne.id = certificates.id_demandeur WHERE id = :id');
            $real_cert = $bdd->prepare('SELECT path_real_certificate, nom, prenom, state_real_certificate FROM real_certificates INNER JOIN personne ON personne.id = real_certificates.id_demandeur WHERE id = :id');

            $cert->execute(array(
                'id' => $_SESSION['id']
            ));
            $real_cert->execute(array(
                'id' => $_SESSION['id']
            ));
        }
    }
?>


<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand">
				<b>MTVP PKI</b>
			</div>
			<div class="container-fluid">
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
								<li><a href="deconnexion.php"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Importer une Demande de Certificat (CSR)</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-5">
                                    <form method="post" action="uploadCertif.php" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <input type="file" class="form-control" name="file" required>
                                            <br>
                                            <span class="form-control" >
                                                <span>FQDN : </span>
                                                <input type="text" name="fqdn" placeholder="exemple.fr" required>
                                            </span>
                                            <br>
                                            <span class="col-md-9"></span>
                                            <button type="submit" class="col-md-3"> Envoyer</button>
                                        </div>
                                    </form>
								</div>
							</div>
						</div>
					</div>
					<!-- END OVERVIEW -->
					<div class="panel panel-headline">
                        <div class="panel-heading">
                            <h3 class="panel-title">Demandes de Certificat</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <!-- RECENT PURCHASES -->
                                <div class="panel">
                                    <div class="panel-body no-padding">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nom de la demande</th>
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
                                                        <td class="col-md-3"><?php echo $lesCerts['nom']?></td>
                                                        <td class="col-md-3"><?php echo $lesCerts['prenom']?></td>
                                                        <td class="col-md-2">
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
                                                            if ($lesCerts['state_certificate'] == 0) {
                                                                echo '<button>
                                                                    <a href="signing.php?csr=request/<?php echo $lesCerts[\'path_certificate\']?>">Signer</a>
                                                                </button>';

                                                            } elseif ($lesCerts['state_certificate'] == true) {
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
                                <!-- END RECENT PURCHASES -->
                            </div>
                        </div>
					</div>
                    <div class="panel panel-headline">
                        <div class="panel-heading">
                            <h3 class="panel-title">Liste des Certificats</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <!-- RECENT PURCHASES -->
                                <div class="panel">
                                    <div class="panel-body no-padding">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>Nom du certificat</th>
                                                <th>Nom du détenteur</th>
                                                <th>Prénom du détenteur</th>
                                                <th>Statut</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            while ($certifs = $real_cert->fetch()) {
                                                ?>
                                                <tr>
<<<<<<< HEAD
                                                    <td><strong><?php echo $lesCerts['path_certificate'] ?></strong></td>
                                                    <td><?php echo $lesCerts['nom']?></td>
                                                    <td><?php echo $lesCerts['prenom']?></td>
                                                    <td><button><a href="signing.php?csr=<?php echo $lesCerts['path_certificate']?>">Accepter</a></button></td>
                                                    <td>
                                                        <span class="label label-success">
                                                             <?php

                                                             ?>
                                                        </span>
=======
                                                    <td class="col-md-3"><strong><?php echo $certifs['path_real_certificate'] ?></strong></td>
                                                    <td class="col-md-3"><?php echo $certifs['nom']?></td>
                                                    <td class="col-md-3"><?php echo $certifs['prenom']?></td>
                                                    <td class="col-md-2">
                                                        <?php
                                                        if ($certifs['state_real_certificate'] == 0) {
                                                            echo "<span class='label label-success'>Valide</span>";

                                                        } elseif ($certifs['state_real_certificate'] == true) {
                                                            echo "<span class='label label-danger'>Révoqué</span>";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="col-md-1">
                                                        <?php
                                                        if ($certifs['state_real_certificate'] == 0) {
                                                            echo '<button>
                                                                    <a href="revoke.php?csr=request/<?php echo $lesCerts[\'path_real_certificate\']?>">Révoquer</a>
                                                                </button>';

                                                        } elseif ($certifs['state_real_certificate'] == true) {
                                                            echo "";
                                                        }
                                                        ?>
>>>>>>> 739ca83a8493da89e8cbd6be4ffffc5574f8fe71
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- END RECENT PURCHASES -->
                            </div>
                        </div>
                    </div>
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
		<!-- END MAIN -->
		<div class="clearfix"></div>
		<footer>
			<div class="container-fluid">
				<p class="copyright">&copy; 2019 MTVP PKI</p>
			</div>
		</footer>
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
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

	$(function() {
		var data, options;

		// headline charts
		data = {
			labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
			series: [
				[23, 29, 24, 40, 25, 24, 35],
				[14, 25, 18, 34, 29, 38, 44],
			]
		};

		options = {
			height: 300,
			showArea: true,
			showLine: false,
			showPoint: false,
			fullWidth: true,
			axisX: {
				showGrid: false
			},
			lineSmooth: false,
		};

		new Chartist.Line('#headline-chart', data, options);


		// visits trend charts
		data = {
			labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
			series: [{
				name: 'series-real',
				data: [200, 380, 350, 320, 410, 450, 570, 400, 555, 620, 750, 900],
			}, {
				name: 'series-projection',
				data: [240, 350, 360, 380, 400, 450, 480, 523, 555, 600, 700, 800],
			}]
		};

		options = {
			fullWidth: true,
			lineSmooth: false,
			height: "270px",
			low: 0,
			high: 'auto',
			series: {
				'series-projection': {
					showArea: true,
					showPoint: false,
					showLine: false
				},
			},
			axisX: {
				showGrid: false,

			},
			axisY: {
				showGrid: false,
				onlyInteger: true,
				offset: 0,
			},
			chartPadding: {
				left: 20,
				right: 20
			}
		};

		new Chartist.Line('#visits-trends-chart', data, options);


		// visits chart
		data = {
			labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
			series: [
				[6384, 6342, 5437, 2764, 3958, 5068, 7654]
			]
		};

		options = {
			height: 300,
			axisX: {
				showGrid: false
			},
		};

		new Chartist.Bar('#visits-chart', data, options);


		// real-time pie chart
		var sysLoad = $('#system-load').easyPieChart({
			size: 130,
			barColor: function(percent) {
				return "rgb(" + Math.round(200 * percent / 100) + ", " + Math.round(200 * (1.1 - percent / 100)) + ", 0)";
			},
			trackColor: 'rgba(245, 245, 245, 0.8)',
			scaleColor: false,
			lineWidth: 5,
			lineCap: "square",
			animate: 800
		});

		var updateInterval = 3000; // in milliseconds

		setInterval(function() {
			var randomVal;
			randomVal = getRandomInt(0, 100);

			sysLoad.data('easyPieChart').update(randomVal);
			sysLoad.find('.percent').text(randomVal);
		}, updateInterval);

		function getRandomInt(min, max) {
			return Math.floor(Math.random() * (max - min + 1)) + min;
		}

	});
	</script>
</body>

</html>
