<?php

/*Rotas da aplicação

Se a classe existir, por padrão entra em HomeController


*/


class Core 
{
    public function start($urlGet)
    {

        //echo $urlGet['pagina'];
        if (isset($urlGet['pagina'])) {
        $controller = ucfirst($urlGet['pagina']. 'Controller'); 
        // Sempre cair em controler (classe)
        }

      
        else { //sem pagina (?pagina=...!!!
            $controller =  'HomeController';
        }

        if (isset($urlGet['metodo'])){ //pega o metodo

            $acao = $urlGet['metodo'];


        } else {
        $acao =  'index';//metodo padrao das classes

        }


        if (!class_exists($controller)){ //Teste lógico para a existência da classe

            $controller = "ErroController";
        }

   
       // var_dump($urlGet);


        if(isset($urlGet['id']) && $urlGet['id'] != null) {

            $id = $urlGet['id'];
        }

        else {

            $id = null;

        }



        call_user_func_array(array(new $controller, $acao), array($id));//Usar métodos de classe!!!

       // echo $controller;


    }

}


?>