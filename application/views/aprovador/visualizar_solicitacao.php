<?php 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">




	<script type="text/javascript">	
		function statusSolicitacao(status){
			var id_cript = $('#id_cript').val();
			var obs = $('#observacao').val();
			$.ajax({
				url: "<?php echo base_url() ?>welcome/AjaxMudarStatusSolicitacao",
				dataType: 'json',
				type: 'post',
				data: {
					status: status,
					id_cript:id_cript,
					obs:obs
				},
				cache: false,
				success: function(data) {
					window.location.href = "<?php echo site_url()."welcome/ListarSolicitacoes"?>";
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
		<input type="hidden" value="<?php echo $id_cript; ?>" name="id_cript" id="id_cript">
		<div class="col-md-12">
			<h2 style="font-family: Open Sans;
			font-style: normal;
			font-weight: bold;
			font-size: 50px;
			line-height: 68px;
			color: #7A7A7A;">Visualizar solicitacão</h2>

			
			<div class="row">
				<div class="form-group">
					<div class="col-md-6 col-sm-12 col-xs-12">
						<label title="Campo obrigatório" class="control-label"><label for="nome">Solicitador:</label></label>
						<input disabled class="form-control input_universal" value="<?php echo $usuario['nome'] ?>"  id="nome" name="nome" required="required" maxlength="70" size="30" type="text">
					</div>
					<div class="col-md-6 col-sm-12 col-xs-12">
						<label title="Campo obrigatório" class="control-label"><label for="nome">Data da solicitação:</label></label>
						<input disabled class="form-control input_universal" value="<?php echo $solicitado['data_cadastrado'] ?>"  id="nome" name="nome" required="required" maxlength="70" size="30" type="text">
					</div>
				</div>
			</div>


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
					color:  <?php echo $solicitado['status_cor']; ?>;"><?php echo $solicitado['status_string'];?></h2>
				</div>
			</div>
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
					<textarea name="observacao" id="observacao" class="form-control" cols="100" rows="5" style="resize: none"> <?php echo $solicitado['observacao']; ?></textarea>
				</div>
			</div>
		</div>
	</div>
	<br><br><br><br>
	<div class="col-lg-10">

	</div>
	<div class="col-lg-2">
		<a href="<?php echo site_url("welcome/ListarSolicitacoes"); ?>" style="
		border: 0.768173px solid #D2D2D2;
		box-sizing: border-box;
		border-radius: 5.88102px;" class="btn btn-light">Voltar</a>
		<input class="btn btn-success" style="background: #FB2B3F;
		border-radius: 5.88102px;" onclick="statusSolicitacao('3')" value="Reprovar" type="submit">
		<input class="btn btn-success" style="background: #1473E6;
		border-radius: 5.88102px;" onclick="statusSolicitacao('2')" value="Aprovar" type="submit">
	</div>
</div>
</div>
</div>

</body>




</html>