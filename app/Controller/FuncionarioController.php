<?php

 /*Interface entre View e Model */

    class FuncionarioController
    {

        public function index()
        {

            //Teste da query, caso nao...
            try {

            $colecPerfil = Funcionario::selecionaTodos();
   
            $loader = new \Twig\Loader\FilesystemLoader('app/View'); //carrega pasta da view
            $twig = new \Twig\Environment($loader);

            $template = $twig->load('listaFuncionarios.html'); // carrega arquivo a ser usado como view

            $parametros = array();

            $parametros['funcionarios'] = $colecPerfil;
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

            $template = $twig->load('cadastroFuncionario.html'); // carrega arquivo a ser usado como view
    
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
                    Funcionario::insert($_POST);

    
               echo '<script>alert("Publicação inserida com sucesso!");</script>';
               echo '<script>location.href="?pagina=funcionario&metodo=index"</script>';
    
                } catch (Exception $e) {
    
                    echo '<script>alert("'.$e->getMessage().'");</script>';
                    echo '<script>location.href="?pagina=funcionario&metodo=create"</script>';
                }
    
    
    
            
            }

            

            public function change($paramId)
            {
                $loader = new \Twig\Loader\FilesystemLoader('app/View');
                $twig = new \Twig\Environment($loader);
            
                // Buscar todas as ocupações e cidades
                $colecOcupacao = Ocupacao::selecionaTodos();
                $colecCidade = Cidade::selecionaTodos();
            
                // Buscar o funcionário pelo ID
                $funcionario = Funcionario::selecionaPorId($paramId);
            
                // Preparar parâmetros para o template
                $parametros = [
                    'ocupacoes' => $colecOcupacao,
                    'cidades' => $colecCidade,
                    'id' => $funcionario->usuarios_id,
                    'nome' => $funcionario->usuarios_nome,
                    'cpf' => $funcionario->usuarios_cpf,
                    'ocupacao_id' => $funcionario->ocupacao_id,
                    'nome_ocupacao' => $funcionario->nome_ocupacao,
                    'data_nascimento' => $funcionario->data_nascimento,
                    'genero_nome' => $funcionario->genero,
                    'email' => $funcionario->email,
                    'endereco_nome' => $funcionario->enderecos_nome,
                    'endereco_numero' => $funcionario->enderecos_numero,
                    'enderecos_complemento' => $funcionario->enderecos_complemento,
                    'enderecos_padrao' => $funcionario->enderecos_padrao,
                    'endereco_bairro' => $funcionario->endereco_bairro,
                    'endereco_cep' => $funcionario->endereco_cep,
                    'cidade_nome' => $funcionario->cidades_nome,
                    'cidade_id' => $funcionario->cidades_id,
                ];
            
                // Carregar e renderizar o template
                $template = $twig->load('updateFuncionario.html');
                $conteudo = $template->render($parametros);
                echo $conteudo;
            }

        public function update()
		{
			try {
                var_dump($_POST);

				Funcionario::update($_POST);
				echo '<script> alert("Publicação alterada com sucesso");</script>';
				echo '<script> location.href="?pagina=funcionario"</script>';
			} catch (Exception $e) {
                var_dump($_POST);
			    echo '<script> alert("'.$e->getMessage().'");</script>';
				echo '<script> location.href="?pagina=perfil&metodo=change&id='.$_POST['id'].'"</script>';

			}
			
		}

        public function delete($paramId)
		{
			try {
				Funcionario::delete($paramId);

				echo '<script>alert("Publicação deletada com sucesso!");</script>';
				echo '<script>location.href="?pagina=funcionario&metodo=index"</script>';
			} catch (Exception $e) {
				echo '<script>alert("'.$e->getMessage().'");</script>';
				echo '<script>location.href="?pagina=funcionario&metodo=index"</script>';
			}
			
		}

    }


?>