<?php

require_once 'vendor/autoload.php';

require_once 'lib/Database/Connection.php';

require_once 'app/Core/Core.php';

require_once 'app/Model/Cidade.php';
require_once 'app/Model/Ocupacao.php';
require_once 'app/Model/Funcionario.php';
require_once 'app/Model/Paciente.php';
require_once 'app/Model/Agendamento.php';
require_once 'app/Model/Ficha.php';




require_once 'app/Controller/HomeController.php';
require_once 'app/Controller/ErroController.php';
require_once 'app/Controller/FuncionarioController.php';
require_once 'app/Controller/PacienteController.php';
require_once 'app/Controller/AgendamentoController.php';
require_once 'app/Controller/FichaController.php';






$template = file_get_contents('app/Template/estrutura.html');

ob_start();
    $core = new Core();
    $core->start($_GET); //url(get)_ do navegador!!!!

    $saida = ob_get_contents(); //variavel com a captura da URL/GET(saida da pagina!!)
ob_end_clean();    


// string(search), valor_subtuir e local a procurar e substituir!!!
$tplPronto = str_replace('{{area_dinamica}}', $saida, $template);
echo $tplPronto;


?>
