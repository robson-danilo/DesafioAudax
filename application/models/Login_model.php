<?php
class Login_model extends CI_Model
{

	public function verificarUsuario($dados){
		$this->db->select('id as id_usuario, email as email_usuario, nome as nome_usuario, tipo_usuario_id as tipo_usuario');
		$this->db->from('usuario');
		$this->db->where('email', $dados['email']);
		$this->db->where('senha', $dados['senha']);
		return $this->db->get()->row_array();
	}


	public function total_usuarios($nome, $tipo_usuario_id)
	{
		if ($nome){
			$this->db->like('nome', $nome);
		}
		if ($tipo_usuario_id){
			$this->db->where('tipo_usuario_id', $tipo_usuario_id);
		}

		$this->db->where('id !=', $this->session->userdata('id_usuario'));
		return $this->db->count_all_results('usuario');
	}

	public function get_usuarios($nome, $tipo_usuario_id, $inicio, $maximo)
	{
		$this->db->select('*');
		$this->db->from('usuario');
		if ($nome){
			$this->db->like('nome', $nome);
		}
		if ($tipo_usuario_id){
			$this->db->where('tipo_usuario_id', $tipo_usuario_id);
		}

		$this->db->where('id !=', $this->session->userdata('id_usuario'));
		$this->db->order_by('nome');
		$this->db->limit($maximo, $inicio);
		return $this->db->get()->result_array();
	}


	public function total_materiais($nome)
	{
		if ($nome){
			$this->db->like('nome', $nome);
		}
		return $this->db->count_all_results('materiais');
	}

	public function get_materiais($nome, $inicio, $maximo)
	{
		$this->db->select('*');
		$this->db->from('materiais');
		if ($nome){
			$this->db->like('nome', $nome);
		}
		$this->db->order_by('nome');
		$this->db->limit($maximo, $inicio);
		return $this->db->get()->result_array();
	}
	

	public function verificarEmailCadastrar($email){
		$this->db->select('id');
		$this->db->from('usuario');
		$this->db->where('email', $email);
		$email = $this->db->get()->row_array();
		$verificarEmail = (is_array($email) ? count($email) : 0);
		if ($verificarEmail > 0){
			return false;
		}else {
			return true;
		}
	}

	public function verificarNomeMaterial($nome){
		$this->db->select('id');
		$this->db->from('materiais');
		$this->db->where('nome', $nome);
		$dados = $this->db->get()->row_array();
		$verificarNome = (is_array($dados) ? count($dados) : 0);
		if ($verificarNome > 0){
			return false;
		}else {
			return true;
		}
	}

	public function verificarEmailEditar($dados){
		$this->db->select('id');
		$this->db->from('usuario');
		$this->db->where('id != ', $dados['id']);
		$this->db->where('email', $dados['email']);
		$email = $this->db->get()->row_array();
		$verificarEmail = (is_array($email) ? count($email) : 0);
		if ($verificarEmail > 0){
			return false;
		}else {
			return true;
		}
	}

	public function verificarNomeEditar($dados){
		$this->db->select('id');
		$this->db->from('materiais');
		$this->db->where('id != ', $dados['id']);
		$this->db->where('nome', $dados['nome']);
		$dados = $this->db->get()->row_array();
		$verificarNome = (is_array($dados) ? count($dados) : 0);
		if ($verificarNome > 0){
			return false;
		}else {
			return true;
		}
	}

	public function cadastrarUsuario($dados){
		return $this->db->insert('usuario', $dados);
	}

	public function cadastrarMaterial($dados){
		return $this->db->insert('materiais', $dados);
	}


	public function buscarDadosUsuario($id){
		$this->db->select('nome, senha, email, tipo_usuario_id');
		$this->db->from('usuario');
		$this->db->where('id', $id);
		return $this->db->get()->row_array();
	}

	public function buscarDadosMaterial($id){
		$this->db->select('nome');
		$this->db->from('materiais');
		$this->db->where('id', $id);
		return $this->db->get()->row_array();
	}

	public function EditarUsuario($dados){
		$this->db->set('nome', $dados['nome']);
		$this->db->set('email', $dados['email']);
		$this->db->set('tipo_usuario_id', $dados['tipo_usuario_id']);
		if ($dados['senha']){
			$this->db->set('senha', $dados['senha']);
		}
		$this->db->where('id', $dados['id']);
		return $this->db->update('usuario');
	}

	public function EditarMaterial($dados){
		$this->db->set('nome', $dados['nome']);
		$this->db->where('id', $dados['id']);
		return $this->db->update('materiais');
	}

	public function removerUsuario($id){
		$this->db->where('id', $id);
		return $this->db->delete('usuario');
	}

	public function removerMaterial($id){
		$this->db->where('id', $id);
		return $this->db->delete('materiais');
	}

	public function total_solicitacoes($nome=null, $status)
	{

		$this->db->join('usuario', 'usuario.id = solicitacoes.usuario_id', 'LEFT');
		if ($this->session->userdata('tipo_usuario') == 2){
			if ($nome){
				$this->db->like('usuario.nome', $nome);
			}
		}
		if ($status){
			$this->db->where('solicitacoes.status', $status);
		}

		if ($this->session->userdata('tipo_usuario') == 3){
			$this->db->where('solicitacoes.usuario_id', $this->session->userdata('id_usuario'));
		}
		return $this->db->count_all_results('solicitacoes');
	}

	public function get_solicitacoes($nome=null,$status, $inicio, $maximo)
	{
		//print_r($this->session->userdata('tipo_usuario'));exit;
		$this->db->select('solicitacoes.*, usuario.nome as nome');
		$this->db->from('solicitacoes');
		$this->db->join('usuario', 'usuario.id = solicitacoes.usuario_id', 'LEFT');
		if ($this->session->userdata('tipo_usuario') == 2){
			if ($nome){
				$this->db->like('usuario.nome', $nome);
			}
		}
		if ($status){
			$this->db->where('status', $status);
		}
		if ($this->session->userdata('tipo_usuario') == 3){
			$this->db->where('usuario_id', $this->session->userdata('id_usuario'));
			$this->db->order_by('data_cadastrado');
		}else {
			$this->db->order_by('usuario.nome');
		}
		$this->db->limit($maximo, $inicio);
		return $this->db->get()->result_array();
	}

	public function buscarTodosMateriais(){
		$this->db->select('*');
		$this->db->from('materiais');
		return $this->db->get()->result_array();
	}

	public function cadastrarSolicitacao($materiais){
		$this->db->trans_start();
		$this->db->set('usuario_id', $this->session->userdata('id_usuario'));
		$this->db->set('data_cadastrado', date('Y-m-d'));
		$this->db->insert('solicitacoes');
		$id_solicitacao = $this->db->insert_id();

		foreach ($materiais as $key => $value) {
			$this->db->set('material_id', $value);
			$this->db->set('solicitacao_id', $id_solicitacao);
			$this->db->insert('materiais_solicitados');
		}

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			return false;
		} else {
			return true;
		}
	}

	public function buscarSolicitacaoEspecifica($id){
		$this->db->select('*');
		$this->db->from('solicitacoes');
		$this->db->where('id', $id);
		return $this->db->get()->row_array();
	}

	public function buscarMateriaisSolicitados($id){
		$this->db->select('material_id');
		$this->db->from('materiais_solicitados');
		$this->db->where('solicitacao_id', $id);
		return $this->db->get()->result_array();
	}

	public function statusSolicitacao($dados){
		$this->db->set('observacao', $dados['obervacao']);
		$this->db->set('status', $dados['status']);
		$this->db->where('id', $dados['id']);
		return $this->db->update('solicitacoes');
	}

	public function buscarDadosSolicitante($id){
		$this->db->select('nome');
		$this->db->from('usuario');
		$this->db->where('id', $id);
		return $this->db->get()->row_array();
	}
	

	
}