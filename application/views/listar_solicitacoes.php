<?php 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<script type="text/javascript">	
		$(document).ready(function () {

			pesquisarSolicitacoes();

		});

		function loadDataInTable(value){
			var event_data = '';
			event_data += '<tr style="background: #FFFFFF;">';
			event_data += '<td>'+value.data_cadastrado+'</td>';
			event_data += '<td>'+value.nome+'</td>';    
			if (value.status == 1){
				event_data += '<td style="color: #535353">Aguardando aprovação</td>'; 
			}else if(value.status == 2){
				event_data += '<td style="color: #49D895">Aprovado</td>'; 
			}else{
				event_data += '<td style="color: #FF4848">Reprovado</td>'; 
			}                                    
			event_data += '<td>';
			event_data += '<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">';

			event_data += '<div style="margin-bottom: 3px;" class="btn-group" role="group" aria-label="Basic example">';
			<?php if ($this->session->userdata('tipo_usuario') == 3) {  ?>
				event_data += '<a title="Visualizar solicitação" type="button" class="btn btn-light"  href="<?php echo site_url("welcome/SuaSolicitacao/'+value.id_cript+'"); ?>"><img src="/images/editar_icon.svg" alt="some text" width=20 height=20></a>';
			<?php }else { ?>
				event_data += '<a title="Visualizar solicitação" type="button" class="btn btn-light"  href="<?php echo site_url("welcome/VisualizarSolicitacao/'+value.id_cript+'"); ?>"><img src="/images/editar_icon.svg" alt="some text" width=20 height=20></a>';
			<?php } ?>
			

			event_data += '</div>'; 

			event_data += '</div>';

			event_data += '</td>';
			event_data += '</tr>';

			return event_data;
		}

		function pesquisarSolicitacoes(inicio = 0){
			let status = $('#div_select').val();
			let nome = $('#nome').val();
			$("#tabela tbody").html('');
			$("#tabela tbody").append('<tr><td colspan="4">Carregando...</td></tr>');

			$.ajax({
				url: "<?php echo base_url()?>welcome/AjaxBuscarSolicitacoes",
				dataType: 'json',
				type: 'get',
				data: {nome:nome,inicio:inicio,status:status},
				cache:false,
				success: function(data){  

					var event_data = '';

					$.each(data.resultado, function(index, value){
						event_data += loadDataInTable(value);
					});

					$("#divNavegacao").html('');
					var botaoNevegacao = '';
					if(data.navegacao.anterior != null){

						botaoNevegacao += '<button type="button" class="btn btn-success" onclick="pesquisarSolicitacoes('+data.navegacao.anterior+')"><span class="glyphicon glyphicon-backward"></span></button>';        
					}

					if(data.numPaginas >1){
						$.each(data.numDaPagina, function(index, value){ 
							paginaAtual=data.inicio==value?"disabled":'';
							paginaVazia=Math.ceil(data.numPaginas)<data.indexDaPagina+index?"disabled":'';
							if (!paginaVazia) {
								botaoNevegacao += '<button style="margin-left: 5px;margin-right: 5px;" type="button" '+paginaAtual+' class="btn btn-xs btn-success" onclick="pesquisarSolicitacoes('+value+')">'+(data.indexDaPagina+index)+'</button>';
							}

						});

					}

					if(data.navegacao.proximo != null){
						botaoNevegacao += '<button type="button" class="btn btn-success" onclick="pesquisarSolicitacoes('+data.navegacao.proximo+')"><span class="glyphicon glyphicon-forward"></span></button>';          
					}   
					$("#divNavegacao").html(botaoNevegacao);
					$("#divNavegacao2").html(botaoNevegacao);

					if(event_data!=''){
						$("#tabela tbody").html('');
						$("#tabela tbody").append(event_data);
					}else{
						$("#tabela tbody").html('');
						$("#tabela tbody").append('<tr><td colspan="4">Nenhuma solicitação encontrada.</td></tr>');
					}

				},
				error: function(d){
					$("#tabela tbody").html('');
					$("#tabela tbody").append('<tr><td colspan="4">Nenhum resultado na pesquisa.</td></tr>');
				}
			});
		}

		function remover_usuario(id_cript){
			$.ajax({
				url: "<?php echo base_url()?>welcome/AjaxRemoverUsuario",
				dataType: 'json',
				type: 'post',
				data: {id_cript:id_cript},
				cache:false,
				success: function(data){  
					if (data) {
						pesquisarUsuarios();
					}else{
						alert('Error ao tentar remover usuário!');
					}
				},
				error: function(d){
					alert('error');
				}
			});
		}

	</script>

</head>
<body>

	<div class="row">
		<div class="x_title">
			<h2 style="font-family: Open Sans;
			font-style: normal;
			font-weight: bold;
			font-size: 50px;
			line-height: 68px;

			color: #7A7A7A;">Solicitações</h2>
			<div class="clearfix"></div>
		</div>
		<div id="main" class="container">  
			<div class="col-md-12">

				<div class="row">  
					<?php if ($this->session->userdata('tipo_usuario') == 2)  { ?>
						<div class="col-lg-6" style="margin-top: 1em">
							<div class="input-group">
								<input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome do solicitador" aria-describedby="basic-addon3">
								<span onclick="pesquisarSolicitacoes()" style="background: #1473E6;" class="input-group-addon" id="basic-addon3"><img src="/images/pesquisar_icon.svg" alt="some text" width=12 height=20> </span>
							</div>
						</div>
					<?php } ?>

					<div class="col-lg-4" style="margin-top: 1em">
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon3">Status:</span>
							<select id="div_select" autofocus="autofocus" class="form-control" name="div_select" onchange="pesquisarSolicitacoes()">
								<option  selected="selected" value="" >Todos</option>
								<option value="1">Aguardando aprovação</option>
								<option value="2">Aprovado</option>
								<option value="3">Reprovado</option>
							</select>
						</div>
					</div>

					<?php if ($this->session->userdata('tipo_usuario') != 2)  { ?>

						<div class="col-lg-6" style="margin-top: 1em">
						</div>



						<div class="col-lg-2" style="margin-top: 1em">
							<a style="display: flex;
							flex-direction: row;
							align-items: center;
							padding: 0px 48px;
							left: calc(50% - 226px/2 + 516.53px);
							bottom: 739.02px;
							background: #1473E6;
							border-radius: 50px;" href="<?php echo site_url("welcome/CadastrarNovaSolicitacao"); ?>" class="btn btn-success btn-xs"><img src="/images/novo_icon.svg" alt="some text" width=12 height=40>  &nbsp;&nbsp;&nbsp;&nbsp;Nova solicitação</a>
						</div>
					<?php } ?>

					<div class="col-lg-12">
						<?php 
						echo validation_errors('<p>','</p>');
						if($this->session->flashdata('cadastro_positivo'))
						{
							echo '<p><font color="#228B22">'.$this->session->flashdata('cadastro_positivo').'</font></p>';
						}
						if($this->session->flashdata('cadastro_negativo'))
						{
							echo '<p><font color="#FF0000">'.$this->session->flashdata('cadastro_negativo').'</font></p>';
						}
						?>
					</div>
				</div>
				<div class="form-group">

					<table id="tabela" class="table table-hover table-striped">
						<thead>
							<tr><td colspan="4" style="text-align: right"><div id="divNavegacao"></div></td></tr>
							<tr>
								<th>Data da solicitação</th>
								<th>Solicitador</th>
								<th>Status</th>
								<th>Ações </th>
							</tr>
						</thead>
						<tbody style="border: 0.660066px solid #DDDDDD; box-sizing: border-box;">   
							<tr><td colspan="4">Nenhuma solicitação cadastrada</td></tr>
						</tbody>
						<tfoot>
							<tr><td colspan="4" style="text-align: right"><div id="divNavegacao2"></div></td></tr>
						</tfoot>
					</table> 

				</div>

			</div>
		</div>
	</div>
</div>




</html>