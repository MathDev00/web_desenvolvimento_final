<?php

 /*Interface entre View e Model */

    class AgendamentoController
    {

        public function index()
        {

            //Teste da query, caso nao...
            try {

            $colecAgendamento = Agendamento::selecionaTodos();
   
            $loader = new \Twig\Loader\FilesystemLoader('app/View'); //carrega pasta da view
            $twig = new \Twig\Environment($loader);

            $template = $twig->load('listaAgendamento.html'); // carrega arquivo a ser usado como view

            $parametros = array();

            $parametros['agendamentos'] = $colecAgendamento;
            //$parametros['nome'] = 'Rafael'; //passando valores para a view 

            $conteudo = $template->render($parametros); //armazena o cod html da pagina e passa os valores 
            echo $conteudo;

            //var_dump($colecAgendamento = Agendamento::selecionaTodos());

            } catch(Exception $e) {

                echo $e->getMessage();
            }        }


            public function create() {

                $loader = new \Twig\Loader\FilesystemLoader('app/View'); //carrega pasta da view
            $twig = new \Twig\Environment($loader);

            $template = $twig->load('cadastroAgendamento.html'); // carrega arquivo a ser usado como view

            $parametros = array();

            $colecOcupacao = Funcionario::listaFuncionarios();
            $colecCidade = Paciente::listaPaciente();
            //var_dump($colecCidade);
            $parametros['funcionarios'] = $colecOcupacao;
            $parametros['pacientes'] = $colecCidade;
    
    


            $conteudo = $template->render($parametros); //armazena o cod html da pagina e passa os valores 
            echo $conteudo;

            //var_dump($colecAgendamentoagem = Agendamentoagem::selecionaTodos());
            }  
            
            public function insert() {

                try {    
                    
                    //var_dump($_Agendamento);        
                    Agendamento::insert($_POST);

    
               echo '<script>alert("Publicação inserida com sucesso!");</script>';
               echo '<script>location.href="?pagina=Agendamento&metodo=index"</script>';
    
                } catch (Exception $e) {
    
                    echo '<script>alert("'.$e->getMessage().'");</script>';
                   echo '<script>location.href="?pagina=Agendamento&metodo=create"</script>';
                }
    
    
    
            
            }

            

            public function change($paramId)
            {
                    $loader = new \Twig\Loader\FilesystemLoader('app/View');
                    $twig = new \Twig\Environment($loader);
            
                // Buscar todas as ocupações e cidades
                   $colecPaciente = Paciente::selecionaTodos();
                   $colecFuncionario = Funcionario::selecionaTodos();
            
                // Buscar o paciente pelo ID
                   $agendamento = Agendamento::selecionaPorId($paramId);
            
                // Preparar parâmetros para o template
                $parametros = [
                    'pacientes' => $colecPaciente,
                    'funcionarios' => $colecFuncionario,
                    'id' => $agendamento->id,
                    'titulo' => $agendamento->titulo,
                    'responsavel_agendamento' => $agendamento->responsavel_agendamento,
                    'data_inicio' => $agendamento->data_inicio,
                    'data_final' => $agendamento->data_final
                    
                ];
            
                // Carregar e renderizar o template
                $template = $twig->load('updateAgendamento.html');
                $conteudo = $template->render($parametros);
                echo $conteudo;
            }
            

        public function update()
		{
			try {
                var_dump($_POST);
				Agendamento::update($_POST);
				echo '<script> alert("Publicação alterada com sucesso");</script>';
				echo '<script> location.href="?pagina=agendamento&metodo=index"</script>';
			} catch (Exception $e) {
				echo '<script> alert("'.$e->getMessage().'");</script>';
				echo '<script> location.href="?pagina=agendamento&metodo=change&id='.$_POST['id'].'"</script>';
			}
			
		}

        public function delete($paramId)
		{
			try {

				Agendamento::delete($paramId);

				echo '<script>alert("Publicação deletada com sucesso!");</script>';
				echo '<script>location.href="?pagina=agendamento&metodo=index"</script>';
			} catch (Exception $e) {
				echo '<script>alert("'.$e->getMessage().'");</script>';
				echo '<script>location.href="?pagina=agendamento&metodo=index"</script>';
			}
			
		}

    }



?>