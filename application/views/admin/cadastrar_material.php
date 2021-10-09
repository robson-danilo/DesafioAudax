<?php 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">


	<style type="text/css">


	.input_universal{
		background: #F9F9F9;
		border: 0.649342px solid #D2D2D2;
		box-sizing: border-box;
		border-radius: 4.97127px;
	}

	.olho {
		cursor: pointer;
		left: 746px;
		position: absolute;
		width: 20px;
		top: 40px;
	}

	.form-group .glyphicon-eye-open {
		pointer-events: auto;
	}
	.form-group .glyphicon-eye-open:hover {
		cursor: pointer;
	}

</style>


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

	function validar_campos() {
		var nome = $('#nome').val();
		$.ajax({
			url: "<?php echo base_url() ?>welcome/AjaxValidarNome",
			dataType: 'json',
			type: 'post',
			data: {
				nome: nome
			},
			cache: false,
			success: function(data) {
				if (data ==true) {
					document.getElementById("novo_material").submit();
				} else {
					$("#div_alertar_nome").show();
					document.getElementById('nome').focus();
					return false;
				}
			},
			error: function(d) {

				return false;
			}
		});
	}

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

			color: #7A7A7A;">Cadastrar material</h2>
			<form accept-charset="UTF-8" action="<?php echo site_url("welcome/CadastrarNovoMaterial"); ?>" class="form-horizontal" onsubmit="validar_campos();return false;" id="novo_material" name="novo_material" method="post">

				<div class="form-group">
					<div class="col-lg-12">
						<div id="div_alertar_nome" style="display: none;" class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<strong>Aviso!</strong> Material com esse nome já está cadastrado!
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label title="Campo obrigatório" class="control-label"><label for="nome">Nome</label></label>
						<input class="form-control input_universal" id="nome" name="nome" required="required" maxlength="70" size="30" type="text">
					</div>
				</div>
				<div class="col-lg-10">
					
				</div>
				<div class="col-lg-2">
					<a href="<?php echo site_url("welcome/ListarMateriais"); ?>" style="background: #F9F9F9;
					border: 0.768173px solid #D2D2D2;
					box-sizing: border-box;
					border-radius: 5.88102px;" class="btn btn-light">Cancelar</a>
					<input class="btn btn-success" style="background: #1473E6;
					border-radius: 5.88102px;" name="commit" value="Cadastrar material" type="submit">
				</div>
			</form>
		</div>
	</div>
</div>

</body>




</html>