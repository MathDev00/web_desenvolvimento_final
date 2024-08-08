<?php



class Cidade 
    {

        public static function selecionaTodos()
        
        {

          //Conexao com banco de dados

          $conn =  Connection::getConn();  

          $sql = "SELECT * FROM cidades ORDER BY cidades_id ASC";
          $sql = $conn->prepare($sql);
          $sql->execute();

          $resultado = array();


          /* Retorno por meio de $row (objeto) é armazenado em resultado. 
          Retorno da consulta acima */

          while ($row = $sql->fetchObject('Cidade')) {

            $resultado []  = $row; //$row->titulo, $row->conteudo

          }

          /* Array vazio!!! */ 

          if (!$resultado)  {

            throw  new Exception("Não foi encontrado nenhum registro");

          }


          return $resultado;


        }

    }      


?>        