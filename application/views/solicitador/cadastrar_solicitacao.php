<?php 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
	<div class="container">
		<div class="col-md-12">
			<h2 style="font-family: Open Sans;
			font-style: normal			font-weight: bold;
			font-size: 50px;
			line-height: 68px;

			color: #7A7A7A;">Nova solicitacão</h2>
			<form accept-charset="UTF-8" action="<?php echo site_url("welcome/CadastrarNovaSolicitacao"); ?>" class="form-horizontal" id="nova_solicitacao" name="nova_solicitacao" method="post">
				<h2 style="
				font-family: Inter;
				font-style: normal;
				font-weight: normal;
				font-size: 14.0853px;
				line-height: 17px;

				color: #535353;">Solicitação de materiais</h2>
				<div class="form-group">
				</div>

				<?php foreach ($materiais as $key => $value) {
					echo "<div class='col-md-2 col-sm-4 col-xs-4'>
					<input class='form-check-input' type='checkbox' value='".$value['id']."' name='materiais[]' id='material".$value['id']."'>
					<label class='form-check-label' for='material".$value['id']."'>
					".$value['nome']."
					</label></div>";
				} ?>

			</div>
			<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
			<div class="col-lg-10">

			</div>
			<div class="col-lg-2">
				<a href="<?php echo site_url("welcome/ListarSolicitacoes"); ?>" style="background: #F9F9F9;
				border: 0.768173px solid #D2D2D2;
				box-sizing: border-box;
				border-radius: 5.88102px;" class="btn btn-light">Cancelar</a>
				<input class="btn btn-success" style="background: #1473E6;
				border-radius: 5.88102px;" name="commit" value="Enviar solicitacão" type="submit">
			</div>
		</form>
	</div>
</div>
</div>

</body>




</html>