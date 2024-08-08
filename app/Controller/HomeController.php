<?php

 /*Interface entre View e Model */

    class HomeController
    {

        public function index()
        {

            //Teste da query, caso nao...
            try {

            //$colecPostagem = Postagem::selecionaTodos();
   
            $loader = new \Twig\Loader\FilesystemLoader('app/View'); //carrega pasta da view
            $twig = new \Twig\Environment($loader);

            $template = $twig->load('home.html'); // carrega arquivo a ser usado como view

            $parametros = array();
            //$parametros['postagens'] = $colecPostagem;
            //$parametros['nome'] = 'Rafael'; //passando valores para a view 

            $conteudo = $template->render($parametros); //armazena o cod html da pagina e passa os valores 
            echo $conteudo;

            //var_dump($colecPostagem = Postagem::selecionaTodos());

            } catch(Exception $e) {

                echo $e->getMessage();
            }        }

    }


?>