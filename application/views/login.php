<?php
?>
<html lang="pt">

<head>
	<meta name="robots" content="noindex">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">


	<!-- Bootstrap -->
	<link href="/template/2.0/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="/template/2.0/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

	<!-- Custom Theme Style -->
	<link href="/template/2.0/build/css/custom.min.css" rel="stylesheet">

	<script type="text/javascript">
		$(document).ready(function() {
			//$("#login_cnpj").mask("99.999.999/9999-99");
		});
	</script>
</head>

<body class="login">
	<div>

		<div class="login_wrapper">
			<div class="animate form login_form">
				<section class="login_content">
					<form accept-charset="UTF-8" action="<?php echo site_url("welcome/logado"); ?>" id="new_session" method="post">
						<p style="position: absolute;
						width: 502.83px;
						height: 75.05px;
						top: 138.98px;
						font-family: Open Sans;
						font-style: normal;
						font-weight: bold;
						font-size: 30px;
						line-height: 111.18%;
						color: #1473E6;">Solicite os materiais do seu
					almoxarifado de forma facilitada.</p>

					<?php
					echo validation_errors('<p>', '</p>');
					if ($this->session->flashdata('login_negativo')) {
						echo '<p ><font style="    position: absolute;
						/* width: 502.83px; */
						/* height: 82.05px; */
						top: 207.98px;
						font-family: Open Sans;
						/* font-style: normal; */
						font-weight: bold;
						font-size: 15px;
						line-height: 111.18%;" color="#FF0000">' . $this->session->flashdata('login_negativo') . '</font></p>';
					}
					?>

					<div>
						<input style="position: absolute;
						width: 530px;
						height: 74px;
						top:  229px;
						background: #FFFFFF;
						border: 1px solid #C1BBBB;
						box-sizing: border-box;" type="text" class="form-control" placeholder="E-mail" required="" id="email_usuario" name="email_usuario" />
					</div>
					<div>
						<input style="position: absolute;
						width: 530px;
						height: 74px;
						top: 301.5px;
						background: #FFFFFF;
						border: 1px solid #C1BBBB;
						box-sizing: border-box;" type="password" class="form-control" placeholder="Senha" required="" id="senha_usuario" name="senha_usuario" />
					</div>
					<div class="clearfix"></div>

					<div>
						<button style="position: absolute;
						width: 534px;
						height: 54px;
						left: -2px;
						top: 386.5px;

						background: #1473E6;
						box-shadow: 0px 4px 3px rgba(0, 0, 0, 0.25);"  type="submit" name="Commit"  class="btn btn-success">Entrar</button>

					</div>
				</form>
			</section>
		</div>
	</div>
</div>

</body>

</html>