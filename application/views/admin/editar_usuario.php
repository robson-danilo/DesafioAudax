<?php 

$funcoes = array(
  array("id" => "1", "nome" => "Administrador"),
  array("id" => "2", "nome" => "Aprovador"),
  array("id" => "3", "nome" => "Solicitador")
);
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
		var email = $('#email').val();
		var id_cript = $('#id_cript').val();
		$.ajax({
			url: "<?php echo base_url() ?>welcome/AjaxValidarEmailEdit",
			dataType: 'json',
			type: 'post',
			data: {
				email: email,
				id_cript:id_cript
			},
			cache: false,
			success: function(data) {
				if (data ==true) {
					document.getElementById("edit_usuario").submit();
				} else {
					$("#div_alertar_email").show();
					document.getElementById('email').focus();
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

			color: #7A7A7A;">Cadastrar usuário</h2>
			<form accept-charset="UTF-8" action="<?php echo site_url("welcome/EditarUsuario/$id_cript"); ?>" class="form-horizontal" onsubmit="validar_campos();return false;" id="edit_usuario" name="edit_usuario" method="post"><input type="hidden" value="<?php echo $id_cript ?>" id="id_cript" name="id_cript">

				<div class="form-group">
					<div class="col-lg-12">
						<div id="div_alertar_email" style="display: none;" class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<strong>Aviso!</strong> O email de acesso informado já está sendo usado!
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-6 col-sm-12 col-xs-12">
						<label title="Campo obrigatório" class="control-label"><label for="nome">Nome</label></label>
						<input class="form-control input_universal" value="<?php echo $nome ?>" id="nome" name="nome" required="required" maxlength="70" size="30" type="text" onkeyup="caps(this)">
					</div>
					<div id="div_uf" class="col-md-6 col-sm-12 col-xs-12">
						<label title="Campo obrigatório" class="control-label"><label for="funcao">Função</label></label>
						<select class="form-control input_universal"  required id="funcao" name="funcao">
							<option selected="selected" value="" disabled>Selecione...</option>
							<?php
							foreach ($funcoes as $funcao) {
								if ($funcao['id'] == $tipo_usuario_id) {
									echo "<option selected  value='" . $funcao['id'] . "'>" . $funcao['nome'] . "</option>";
								} else {
									echo "<option value='" . $funcao['id'] . "'>" . $funcao['nome'] . "</option>";
								}
							}
							?>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<div id="div_email_de_acesso" class="col-md-6 col-sm-12 col-xs-12">
						<label title="Campo obrigatório" class="control-label"><label for="email">E-mail</label></label>
						<input class="form-control input_universal" value="<?php echo $email ?>" id="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" name="email" placeholder="exemplo@exemplo.com" type="text">
					</div>
					<div id="div_senha" class="col-md-6 col-sm-12 col-xs-12">
						<label title="Campo obrigatório" class="control-label"><label for="senha">Senha</label></label>
						<input class="form-control input_universal" id="senha" name="senha" type="password">
						<img src="https://cdn0.iconfinder.com/data/icons/ui-icons-pack/100/ui-icon-pack-14-512.png" id="olho" class="olho">
					</div>
				</div>
				<div class="col-lg-10">
					
				</div>
				<div class="col-lg-2">
					<a href="<?php echo site_url("welcome/ListarUsuario"); ?>" style="background: #F9F9F9;
					border: 0.768173px solid #D2D2D2;
					box-sizing: border-box;
					border-radius: 5.88102px;" class="btn btn-light">Cancelar</a>
					<input class="btn btn-success" style="background: #1473E6;
					border-radius: 5.88102px;" name="commit" value="Editar usuário" type="submit">
				</div>
			</form>
		</div>
	</div>
</div>

</body>




</html>