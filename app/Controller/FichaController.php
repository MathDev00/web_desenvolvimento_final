<?php

 /*Interface entre View e Model */

    class FichaController
    {

        public function index($params)
        {   

            //Teste da query, caso nao...
            try {
            

            $ficha = Ficha::selecionarFicha($params);
            //var_dump($ficha);
   
            $loader = new \Twig\Loader\FilesystemLoader('app/View'); //carrega pasta da view
            $twig = new \Twig\Environment($loader);

            $template = $twig->load('singleFicha.html'); // carrega arquivo a ser usado como view

            $parametros = array();
            $parametros['ficha'] = $ficha;

            //$parametros['nome'] = 'Rafael'; //passando valores para a view 

            $conteudo = $template->render($parametros); //armazena o cod html da pagina e passa os valores 
            echo $conteudo;

            //var_dump($colecficha = ficha::selecionaTodos());

            } catch(Exception $e) {

                echo $e->getMessage();
            }        
        }


            public function create() {

            $loader = new \Twig\Loader\FilesystemLoader('app/View'); //carrega pasta da view
            $twig = new \Twig\Environment($loader);

            $template = $twig->load('cadastroFicha.html'); // carrega arquivo a ser usado como view
    
            $parametros = array();

            $colecAgendamento = Agendamento::selecionaTodos();
            $colecPaciente = Paciente::selecionaTodos();
            $colecFuncionario = Funcionario::selecionaTodos();

            $parametros['agendamentos'] = $colecAgendamento;
            $parametros['pacientes'] = $colecPaciente;
            $parametros['funcionarios'] = $colecFuncionario;

    
    
            $conteudo = $template->render($parametros); //armazena o cod html da pagina e passa os valores 
            echo $conteudo;
    
            }  
            
            public function insert() {

                try {    
                    
                    var_dump($_POST);        
                    Ficha::insert($_POST);

    
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
        $colecPaciente = Paciente::selecionaTodos();
        $colecFuncionario = Funcionario::selecionaTodos();
        $colecAgendamento = Agendamento::selecionaTodos();


    // Buscar o paciente pelo ID
       $ficha = Ficha::selecionaPorId($paramId);
       //var_dump($ficha);

    // Preparar parâmetros para o template
    $parametros = [
        'pacientes' => $colecPaciente,
        'funcionarios' => $colecFuncionario,
        'agendamentos' => $colecAgendamento,
        'id' => $ficha->id,
        'agendamento_id' => $ficha->agendamento_id,
        'funcionario_id' => $ficha->funcionario_id,
        'paciente_id' => $ficha->paciente_id,
        'conteudo' => $ficha->conteudo
    ];
    
    //var_dump( $ficha->conteudo);
    // Carregar e renderizar o template
    $template = $twig->load('updateSingleFicha.html');
    $conteudo = $template->render($parametros);
    echo $conteudo;
}

        public function update()
		{
			try {
                var_dump($_POST);

				Ficha::update($_POST);
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
				Ficha::delete($paramId);

				echo '<script>alert("Publicação deletada com sucesso!");</script>';
				echo '<script>location.href="?pagina=paciente&metodo=index"</script>';
			} catch (Exception $e) {
				echo '<script>alert("'.$e->getMessage().'");</script>';
				echo '<script>location.href="?pagina=paciente&metodo=index"</script>';
			}
			
		}

    }

    


?>