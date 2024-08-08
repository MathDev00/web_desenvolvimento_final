<?php

 /*Interface entre View e Model */

    class PacienteController
    {

        public function index()
        {

            //Teste da query, caso nao...
            try {

            $colecPerfil = Paciente::selecionaTodos();
   
            $loader = new \Twig\Loader\FilesystemLoader('app/View'); //carrega pasta da view
            $twig = new \Twig\Environment($loader);

            $template = $twig->load('listaPaciente.html'); // carrega arquivo a ser usado como view

            $parametros = array();

            $parametros['pacientes'] = $colecPerfil;
            //var_dump($colecPerfil);
            //$parametros['nome'] = 'Rafael'; //passando valores para a view 

            $conteudo = $template->render($parametros); //armazena o cod html da pagina e passa os valores 
            echo $conteudo;

            //var_dump($colecperfil = perfil::selecionaTodos());

            } catch(Exception $e) {

                echo $e->getMessage();
            }        }


            public function create() {

            $loader = new \Twig\Loader\FilesystemLoader('app/View'); //carrega pasta da view
            $twig = new \Twig\Environment($loader);

            $template = $twig->load('cadastroPaciente.html'); // carrega arquivo a ser usado como view
    
            $parametros = array();

            $colecOcupacao = Ocupacao::selecionaTodos();
            $colecCidade = Cidade::selecionaTodos();
            $parametros['ocupacoes'] = $colecOcupacao;
            $parametros['cidades'] = $colecCidade;
    
    
            $conteudo = $template->render($parametros); //armazena o cod html da pagina e passa os valores 
            echo $conteudo;
    
            }  
            
            public function insert() {

                try {    
                    
                    //var_dump($_perfil);        
                    Paciente::insert($_POST);

    
               echo '<script>alert("Publicação inserida com sucesso!");</script>';
               echo '<script>location.href="?pagina=Paciente&metodo=index"</script>';
    
                } catch (Exception $e) {
    
                    echo '<script>alert("'.$e->getMessage().'");</script>';
                    echo '<script>location.href="?pagina=Paciente&metodo=create"</script>';
                }
    
    
    
            
            }

            

            public function change($paramId)
{
        $loader = new \Twig\Loader\FilesystemLoader('app/View');
        $twig = new \Twig\Environment($loader);

    // Buscar todas as ocupações e cidades
       $colecOcupacao = Ocupacao::selecionaTodos();
       $colecCidade = Cidade::selecionaTodos();

    // Buscar o paciente pelo ID
       $paciente = Paciente::selecionaPorId($paramId);

    // Preparar parâmetros para o template
    $parametros = [
        'ocupacoes' => $colecOcupacao,
        'cidades' => $colecCidade,
        'id' => $paciente->usuarios_id,
        'nome' => $paciente->usuarios_nome,
        'cpf' => $paciente->usuarios_cpf,
        'data_nascimento' => $paciente->data_nascimento,
        'genero_nome' => $paciente->genero,
        'email' => $paciente->email,
        'endereco_nome' => $paciente->enderecos_nome,
        'endereco_numero' => $paciente->enderecos_numero,
        'enderecos_complemento' => $paciente->enderecos_complemento,
        'enderecos_padrao' => $paciente->enderecos_padrao,
        'endereco_bairro' => $paciente->endereco_bairro,
        'endereco_cep' => $paciente->endereco_cep,
        'cidade_id' => $paciente->cidades_id,
    ];

    // Carregar e renderizar o template
    $template = $twig->load('updatePaciente.html');
    $conteudo = $template->render($parametros);
    echo $conteudo;
}

        public function update()
		{
			try {
                var_dump($_POST);

				Paciente::update($_POST);
				echo '<script> alert("Publicação alterada com sucesso");</script>';
				echo '<script> location.href="?pagina=paciente"</script>';
			} catch (Exception $e) {
                var_dump($_POST);
			echo '<script> alert("'.$e->getMessage().'");</script>';
				echo '<script> location.href="?pagina=paciente&metodo=change&id='.$_POST['id'].'"</script>';

			}
			
		}

        public function delete($paramId)
		{
			try {
				Paciente::delete($paramId);

				echo '<script>alert("Publicação deletada com sucesso!");</script>';
				echo '<script>location.href="?pagina=paciente&metodo=index"</script>';
			} catch (Exception $e) {
				echo '<script>alert("'.$e->getMessage().'");</script>';
				echo '<script>location.href="?pagina=paciente&metodo=index"</script>';
			}
			
		}

    }

    


?>