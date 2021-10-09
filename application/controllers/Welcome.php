<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */


	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url'); //Carrega o helper de url(link)
		$this->load->helper('form'); //Carrega o helper de formul?rio
		$this->load->helper('array'); //Carrega o helper array
		$this->load->helper('encode');
		$this->load->library('session'); //Carrega a biblioteca de sess?o
		$this->load->library('table'); // Carrega a bibioteca de tabela
		$this->load->library('form_validation'); //Carrega a biblioteca de valida??o de formul?rio
		$this->load->model('login_model'); //Carrega o model
		//Limpa o cache, não permitindo ao usuário visualizar nenhuma página logo depois de ter feito logout do sistema
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");
	}


	public function index()
	{
		$this->session->sess_destroy();
		$this->load->view('login');
	}

	public function login(){
		
		$this->template->load('template/Template_Base', 'login');
	}

	public function logado(){


		$senha_md5 = md5($this->input->post('senha_usuario'));

		$dados_login = array('email'=>$this->input->post('email_usuario'),
			'senha'=>$senha_md5);

		$retorno = $this->login_model->verificarUsuario($dados_login);

		if ($retorno != null || $retorno != ''){

			$this->session->set_userdata('tipo_usuario', $retorno['tipo_usuario']);
			$this->session->set_userdata('nome_usuario', $retorno['nome_usuario']);
			$this->session->set_userdata('id_usuario', $retorno['id_usuario']);
			$this->session->set_userdata('email_usuario', $retorno['email_usuario']);
			if ($retorno['tipo_usuario'] == 1){
				//print_r($retorno);exit;
				$this->template->load('template/Template_Base', 'admin/listar_usuarios');
			}else{
				$this->template->load('template/Template_Base', 'listar_solicitacoes');
			}

			
		}else {
			$this->session->set_flashdata('login_negativo', 'E-mail ou senha invalidos!');
			redirect("welcome/index");
		}

	}

	public function ListarUsuario(){
		$this->template->load('template/Template_Base', 'admin/listar_usuarios');
	}

	public function ListarMateriais(){
		$this->template->load('template/Template_Base', 'admin/listar_materiais');
	}

	public function ListarSolicitacoes(){
		$this->template->load('template/Template_Base', 'listar_solicitacoes');
	}

	public function CadastrarNovoUsuario(){


		if ($this->input->post('nome')){
			$senha_md5 = md5($this->input->post('senha'));

			$dados = array('nome'=>$this->input->post('nome'),
				'tipo_usuario_id'=>$this->input->post('funcao'),
				'email'=>$this->input->post('email'),
				'senha'=>$senha_md5);


			$retorno = $this->login_model->cadastrarUsuario($dados);

			if ($retorno){
				$this->session->set_flashdata('cadastro_positivo', 'Usuário cadastrado com sucesso!');
				redirect("welcome/ListarUsuario");
			}else {
				$this->session->set_flashdata('cadastro_negativo', 'Erro ao cadastrar usuário!');
				redirect("welcome/ListarUsuario");
			}
		}



		$this->template->load('template/Template_Base', 'admin/cadastrar_usuario');
	}

	public function EditarUsuario($id_usuario_cript){
		$id_descript = url_base64_decode($id_usuario_cript);
		$dados = $this->login_model->buscarDadosUsuario($id_descript);
		$dados['senha']= $dados['senha'];
		$dados['id_cript'] = $id_usuario_cript;
		if ($this->input->post('nome')){

			$id_cript = $this->input->post('id_cript');

			$id_descript_edit = url_base64_decode($id_cript);

			$dados_editado = array('nome'=>$this->input->post('nome'),
				'tipo_usuario_id'=>$this->input->post('funcao'),
				'email'=>$this->input->post('email'),
				'id'=>$id_descript_edit);



			if ($this->input->post('senha') != null || $this->input->post('senha') != ''){
				$senha_md5 = md5($this->input->post('senha'));

				$dados_editado['senha'] = $senha_md5;
			}


			$retorno = $this->login_model->EditarUsuario($dados_editado);

			if ($retorno){
				$this->session->set_flashdata('cadastro_positivo', 'Usuário editado com sucesso!');
				redirect("welcome/ListarUsuario");
			}else {
				$this->session->set_flashdata('cadastro_negativo', 'Erro ao editar usuário!');
				redirect("welcome/ListarUsuario");
			}
		}

		$this->template->load('template/Template_Base', 'admin/editar_usuario', $dados);
	}

	public function CadastrarNovoMaterial(){


		if ($this->input->post('nome')){

			$dados = array('nome'=>$this->input->post('nome'));

			$retorno = $this->login_model->cadastrarMaterial($dados);

			if ($retorno){
				$this->session->set_flashdata('cadastro_positivo', 'Material cadastrado com sucesso!');
				redirect("welcome/ListarMateriais");
			}else {
				$this->session->set_flashdata('cadastro_negativo', 'Erro ao cadastrar material!');
				redirect("welcome/ListarMateriais");
			}
		}



		$this->template->load('template/Template_Base', 'admin/cadastrar_material');
	}

	public function EditarMaterial($id_material_cript){
		$id_descript = url_base64_decode($id_material_cript);
		$dados = $this->login_model->buscarDadosMaterial($id_descript);
		$dados['id_cript'] = $id_material_cript;
		if ($this->input->post('nome')){

			$id_cript = $this->input->post('id_cript');

			$id_descript_edit = url_base64_decode($id_cript);

			$dados_editado = array('nome'=>$this->input->post('nome'),
				'id'=>$id_descript_edit);

			$retorno = $this->login_model->EditarMaterial($dados_editado);

			if ($retorno){
				$this->session->set_flashdata('cadastro_positivo', 'Material editado com sucesso!');
				redirect("welcome/ListarMateriais");
			}else {
				$this->session->set_flashdata('cadastro_negativo', 'Erro ao editar material!');
				redirect("welcome/ListarMateriais");
			}
		}

		$this->template->load('template/Template_Base', 'admin/editar_material', $dados);
	}

	public function CadastrarNovaSolicitacao(){

		$dados['materiais'] = $this->login_model->buscarTodosMateriais();
		if ($this->input->post('materiais')){
			$retorno = $this->login_model->cadastrarSolicitacao($this->input->post('materiais'));

			if ($retorno){
				$this->session->set_flashdata('cadastro_positivo', 'Solicitação cadastrada com sucesso!');
				redirect("welcome/ListarSolicitacoes");
			}else {
				$this->session->set_flashdata('cadastro_negativo', 'Erro ao cadastrar solicitação!');
				redirect("welcome/ListarSolicitacoes");
			}
		}



		$this->template->load('template/Template_Base', 'solicitador/cadastrar_solicitacao', $dados);
	}

	public function SuaSolicitacao($id_cript){

		$id_descript = url_base64_decode($id_cript);
		$dados['id_cript'] = $id_descript;
		$solicitado = $this->login_model->buscarSolicitacaoEspecifica($id_descript);
		if ($solicitado['status'] == 1){ 
			$solicitado['status_string'] = "Aguardando aprovação";
			$solicitado['status_cor'] = "#535353";
		}else if ($solicitado['status'] == 2){ 
			$solicitado['status_string'] = "Aprovado";
			$solicitado['status_cor'] = "#49D895";
		}else { 
			$solicitado['status_string'] = "Reprovado";
			$solicitado['status_cor'] = "#FF4848";
		}

		$dados['solicitado'] = $solicitado;

		$materiais_solicitados = $this->login_model->buscarMateriaisSolicitados($id_descript);


		$materiais = $this->login_model->buscarTodosMateriais();
		foreach ($materiais as $key => $value) {
			$materiais[$key]['solicitado'] = '';
			foreach ($materiais_solicitados as $key2 => $value2) {
				if ($value['id'] == $value2['material_id']){
					$materiais[$key]['solicitado'] = 'checked';
				}
			}
		}

		//print_r($materiais);exit;

		$dados['materiais'] = $materiais;

		$this->template->load('template/Template_Base', 'solicitador/visualizar_solicitacao', $dados);
	}

	public function VisualizarSolicitacao($id_cript){

		$id_descript = url_base64_decode($id_cript);
		$dados['id_cript'] = $id_cript;
		$solicitado = $this->login_model->buscarSolicitacaoEspecifica($id_descript);

		$dados['usuario'] = $this->login_model->buscarDadosSolicitante($solicitado['usuario_id']);

		$solicitado['data_cadastrado'] = date('d/m/Y',strtotime($solicitado['data_cadastrado']));


		if ($solicitado['status'] == 1){ 
			$solicitado['status_string'] = "Aguardando aprovação";
			$solicitado['status_cor'] = "#535353";
		}else if ($solicitado['status'] == 2){ 
			$solicitado['status_string'] = 'Aprovado';
			$solicitado['status_cor'] = "#49D895";
		}else { 
			$solicitado['status_string'] = "Reprovado";
			$solicitado['status_cor'] = "#FF4848";
		}

		$dados['solicitado'] = $solicitado;

		$materiais_solicitados = $this->login_model->buscarMateriaisSolicitados($id_descript);


		$materiais = $this->login_model->buscarTodosMateriais();
		foreach ($materiais as $key => $value) {
			$materiais[$key]['solicitado'] = '';
			foreach ($materiais_solicitados as $key2 => $value2) {
				if ($value['id'] == $value2['material_id']){
					$materiais[$key]['solicitado'] = 'checked';
				}
			}
		}

		//print_r($materiais);exit;

		$dados['materiais'] = $materiais;


		//print_r($dados);exit;

		$this->template->load('template/Template_Base', 'aprovador/visualizar_solicitacao', $dados);
	}

	

	//Ajax

	public function AjaxMudarStatusSolicitacao(){

		$id_cript = $this->input->post('id_cript');

		if ($this->input->post('status') == 2){
			$tipo = 'Aprovado';
		}else {
			$tipo = 'Reprovado';
		}

		$id_descript = url_base64_decode($id_cript);

		$dados_solicitacao = array('obervacao'=>$this->input->post('obs'),
			'id'=>$id_descript,
			'status'=>$this->input->post('status'));

		$retorno = $this->login_model->statusSolicitacao($dados_solicitacao);

		if ($retorno){
			$this->session->set_flashdata('cadastro_positivo', 'Solicitação '.$tipo.' com sucesso!');
			echo json_encode($retorno, JSON_UNESCAPED_UNICODE);
		}else {
			$this->session->set_flashdata('cadastro_negativo', 'Erro ao '.$tipo.' solicitação!');
			echo json_encode($retorno, JSON_UNESCAPED_UNICODE);
		}

	}

	public function AjaxValidarEmail(){
		$retorno = $this->login_model->verificarEmailCadastrar($this->input->post('email'));
		echo json_encode($retorno, JSON_UNESCAPED_UNICODE);

	}

	public function AjaxValidarNome(){
		$retorno = $this->login_model->verificarNomeMaterial($this->input->post('nome'));
		echo json_encode($retorno, JSON_UNESCAPED_UNICODE);
	}

	public function AjaxValidarEmailEdit(){

		$id_cript = $this->input->post('id_cript');

		$id_descript = url_base64_decode($id_cript);
		$dados = array('id'=>$id_descript,
			'email'=>$this->input->post('email'));

		$retorno = $this->login_model->verificarEmailEditar($dados);
		echo json_encode($retorno, JSON_UNESCAPED_UNICODE);
	}

	public function AjaxValidarNomeEdit(){

		$id_cript = $this->input->post('id_cript');

		$id_descript = url_base64_decode($id_cript);
		$dados = array('id'=>$id_descript,
			'nome'=>$this->input->post('nome'));

		$retorno = $this->login_model->verificarNomeEditar($dados);
		echo json_encode($retorno, JSON_UNESCAPED_UNICODE);
	}

	public function AjaxRemoverUsuario(){
		$id_cript = $this->input->post('id_cript');
		$id_descript = url_base64_decode($id_cript);
		$retorno = $this->login_model->removerUsuario($id_descript);
		echo json_encode($retorno, JSON_UNESCAPED_UNICODE);
	}

	public function AjaxRemoverMaterial(){
		$id_cript = $this->input->post('id_cript');
		$id_descript = url_base64_decode($id_cript);
		$retorno = $this->login_model->removerMaterial($id_descript);
		echo json_encode($retorno, JSON_UNESCAPED_UNICODE);
	}

	public function AjaxBuscarUsuarios(){
		$inicio = $this->input->get('inicio');
		$nome = $this->input->get('nome');
		$tipo_usuario_id = $this->input->get('tipo_usuario_id');
		$maximo = 8;

		$total = $this->login_model->total_usuarios($nome, $tipo_usuario_id);
		$resultado = $this->login_model->get_usuarios($nome,$tipo_usuario_id,$inicio,$maximo);


		foreach ($resultado as $key => $value) {
			foreach ($value as $key2 => $value2) {
				if ($key2 == 'id') {
					$resultado[$key]['id_cript'] = url_base64_encode($value2);
				}
			}
		}

		$navegacao['anterior'] = null;
		$navegacao['proximo'] = null;	
		$numPaginas = null;	
		if (!empty($total)) {
			$numPaginas = $total/$maximo ;
			if ($numPaginas>5) {

				if ($inicio<=3*$maximo) {
					$numDaPagina[0] = 0;
					$numDaPagina[1] = $maximo;
					$numDaPagina[2] = 2*$maximo;
					$numDaPagina[3] = 3*$maximo;
					$numDaPagina[4] = 4*$maximo;
				}else{
					$numDaPagina[0] = $inicio-2*$maximo;
					$numDaPagina[1] = $inicio-$maximo;
					$numDaPagina[2] = $inicio;
					$numDaPagina[3] = $inicio+$maximo;
					$numDaPagina[4] = $inicio+2*$maximo;
				}

			}else{
				for ($i=0; $i < $numPaginas; $i++) { 
					$numDaPagina[$i] = $i*$maximo;
				}
			}

		}else{
			$numDaPagina[0] = $maximo;
		}

		if ($inicio<=3*$maximo) {
			$indexDaPagina=1;
		}else{
			$indexDaPagina=($inicio/$maximo)-1;
		}

		if($total < $maximo){
			$navegacao['anterior'] = null;
			$navegacao['proximo'] = null;				
		}else if($inicio == 0){
			$navegacao['anterior'] = null;
			$navegacao['proximo'] = $inicio + $maximo;				
		}else if($inicio >= $total){
			$navegacao['anterior'] = $inicio - $maximo;
			$navegacao['proximo'] = null;	
		}else if(($inicio > 0) && ($inicio < $total)){
			$navegacao['anterior'] = $inicio - $maximo;
			$navegacao['proximo'] = $inicio + $maximo;					
		}		
		$inicio==null?$inicio=0:'';
		echo json_encode(array('total'=>$total,'resultado'=>$resultado,'navegacao'=>$navegacao,'numPaginas'=>$numPaginas,'numDaPagina'=>$numDaPagina,'inicio'=>$inicio,'indexDaPagina'=>$indexDaPagina),JSON_UNESCAPED_UNICODE);

	}

	public function AjaxBuscarMateriais(){


		$inicio = $this->input->get('inicio');
		$nome = $this->input->get('nome');
		$maximo = 8;

		$total = $this->login_model->total_materiais($nome);
		$resultado = $this->login_model->get_materiais($nome,$inicio,$maximo);


		foreach ($resultado as $key => $value) {
			foreach ($value as $key2 => $value2) {
				if ($key2 == 'id') {
					$resultado[$key]['id_cript'] = url_base64_encode($value2);
				}
			}
		}

		$navegacao['anterior'] = null;
		$navegacao['proximo'] = null;	
		$numPaginas = null;	
		if (!empty($total)) {
			$numPaginas = $total/$maximo ;
			if ($numPaginas>5) {

				if ($inicio<=3*$maximo) {
					$numDaPagina[0] = 0;
					$numDaPagina[1] = $maximo;
					$numDaPagina[2] = 2*$maximo;
					$numDaPagina[3] = 3*$maximo;
					$numDaPagina[4] = 4*$maximo;
				}else{
					$numDaPagina[0] = $inicio-2*$maximo;
					$numDaPagina[1] = $inicio-$maximo;
					$numDaPagina[2] = $inicio;
					$numDaPagina[3] = $inicio+$maximo;
					$numDaPagina[4] = $inicio+2*$maximo;
				}

			}else{
				for ($i=0; $i < $numPaginas; $i++) { 
					$numDaPagina[$i] = $i*$maximo;
				}
			}

		}else{
			$numDaPagina[0] = $maximo;
		}

		if ($inicio<=3*$maximo) {
			$indexDaPagina=1;
		}else{
			$indexDaPagina=($inicio/$maximo)-1;
		}

		if($total < $maximo){
			$navegacao['anterior'] = null;
			$navegacao['proximo'] = null;				
		}else if($inicio == 0){
			$navegacao['anterior'] = null;
			$navegacao['proximo'] = $inicio + $maximo;				
		}else if($inicio >= $total){
			$navegacao['anterior'] = $inicio - $maximo;
			$navegacao['proximo'] = null;	
		}else if(($inicio > 0) && ($inicio < $total)){
			$navegacao['anterior'] = $inicio - $maximo;
			$navegacao['proximo'] = $inicio + $maximo;					
		}		
		$inicio==null?$inicio=0:'';
		echo json_encode(array('total'=>$total,'resultado'=>$resultado,'navegacao'=>$navegacao,'numPaginas'=>$numPaginas,'numDaPagina'=>$numDaPagina,'inicio'=>$inicio,'indexDaPagina'=>$indexDaPagina),JSON_UNESCAPED_UNICODE);
	}

	public function AjaxBuscarSolicitacoes(){
		$inicio = $this->input->get('inicio');
		$nome = $this->input->get('nome');
		$status = $this->input->get('status');
		$maximo = 10;

		//print_r($status);exit;

		$total = $this->login_model->total_solicitacoes($nome,$status);
		$resultado = $this->login_model->get_solicitacoes($nome,$status,$inicio,$maximo);


		foreach ($resultado as $key => $value) {
			foreach ($value as $key2 => $value2) {
				if ($key2 == 'id') {
					$resultado[$key]['id_cript'] = url_base64_encode($value2);
				}
			}
		}

		$navegacao['anterior'] = null;
		$navegacao['proximo'] = null;	
		$numPaginas = null;	
		if (!empty($total)) {
			$numPaginas = $total/$maximo ;
			if ($numPaginas>5) {

				if ($inicio<=3*$maximo) {
					$numDaPagina[0] = 0;
					$numDaPagina[1] = $maximo;
					$numDaPagina[2] = 2*$maximo;
					$numDaPagina[3] = 3*$maximo;
					$numDaPagina[4] = 4*$maximo;
				}else{
					$numDaPagina[0] = $inicio-2*$maximo;
					$numDaPagina[1] = $inicio-$maximo;
					$numDaPagina[2] = $inicio;
					$numDaPagina[3] = $inicio+$maximo;
					$numDaPagina[4] = $inicio+2*$maximo;
				}

			}else{
				for ($i=0; $i < $numPaginas; $i++) { 
					$numDaPagina[$i] = $i*$maximo;
				}
			}

		}else{
			$numDaPagina[0] = $maximo;
		}

		if ($inicio<=3*$maximo) {
			$indexDaPagina=1;
		}else{
			$indexDaPagina=($inicio/$maximo)-1;
		}

		if($total < $maximo){
			$navegacao['anterior'] = null;
			$navegacao['proximo'] = null;				
		}else if($inicio == 0){
			$navegacao['anterior'] = null;
			$navegacao['proximo'] = $inicio + $maximo;				
		}else if($inicio >= $total){
			$navegacao['anterior'] = $inicio - $maximo;
			$navegacao['proximo'] = null;	
		}else if(($inicio > 0) && ($inicio < $total)){
			$navegacao['anterior'] = $inicio - $maximo;
			$navegacao['proximo'] = $inicio + $maximo;					
		}		
		$inicio==null?$inicio=0:'';
		echo json_encode(array('total'=>$total,'resultado'=>$resultado,'navegacao'=>$navegacao,'numPaginas'=>$numPaginas,'numDaPagina'=>$numDaPagina,'inicio'=>$inicio,'indexDaPagina'=>$indexDaPagina),JSON_UNESCAPED_UNICODE);
	}


}
