<?php 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">




	<script type="text/javascript">	
		$(document).ready(function () {

		//pesquisarUsuarios();

		document.getElementById('olho').addEventListener('mousedown', function() {
			document.getElementById('senha').type = 'text';
		});

		document.getElementById('olho').addEventListener('mouseup', function() {
			document.getElementById('senha').type = 'password';
		});

		// Para que o password não fique exposto apos mover a imagem.
		document.getElementById('olho').addEventListener('mousemove', function() {
			document.getElementById('senha').type = 'password';
		});

	});

</script>

</head>
<body>
	<div class="container">
		<div class="col-md-12">
			<h2 style="font-family: Open Sans;
			font-style: normal;
			font-weight: bold;
			font-size: 50px;
			line-height: 68px;

			color: #7A7A7A;">Sua solicitacão</h2>
			<h2 style="
			font-family: Inter;
			font-style: normal;
			font-weight: normal;
			font-size: 14.0853px;
			line-height: 17px;

			color: #535353;">Materiais solicitados</h2>
			<div class="form-group">

				<?php foreach ($materiais as $key => $value) {
					echo "<div class='col-md-2 col-sm-4 col-xs-4'>
					<input disabled ".$value['solicitado']." class='form-check-input' type='checkbox' value='".$value['id']."' name='materiais[]' id='material".$value['id']."'>
					<label class='form-check-label' for='material".$value['id']."'>
					".$value['nome']."
					</label></div>";
				} ?>

			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<h2 style="
					font-family: Inter;
					font-style: normal;
					font-weight: normal;
					font-size: 14.0853px;
					line-height: 17px;
					color: #535353;">Status</h2>
				</div>

				<div class="col-md-12 col-sm-12 col-xs-12">
					<h2 style="
					font-family: Inter;
					font-style: normal;
					font-weight: normal;
					font-size: 14.0853px;
					line-height: 17px;
					color: <?php echo $solicitado['status_cor']; ?>;"><?php echo $solicitado['status_string'];?></h2>
				</div>
			</div>
			<?php if ($solicitado['status'] == 3) { ?>
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<h2 style="
						font-family: Inter;
						font-style: normal;
						font-weight: normal;
						font-size: 14.0853px;
						line-height: 17px;
						color: #535353;">Observação:</h2>
					</div>

					<div class="col-md-12 col-sm-12 col-xs-12">
						<textarea disabled class="form-control" cols="100" rows="5" style="resize: none"> <?php echo $solicitado['observacao']; ?></textarea>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
	<br><br><br><br>
	<div class="col-md-11 col-sm-10 col-xs-10">

	</div>
	<div class="col-md-1 col-sm-4 col-xs-4">
		<a href="<?php echo site_url("welcome/ListarSolicitacoes"); ?>" style="background: #1473E6;
		border: 0.768173px solid #D2D2D2;
		box-sizing: border-box;
		border-radius: 5.88102px;" class="btn btn-primary">Voltar</a>
	</div>
</div>
</div>
</div>

</body>




</html>