<?php



class Ocupacao 
    {

        public static function selecionaTodos()
        
        {

          //Conexao com banco de dados

          $conn =  Connection::getConn();  

          $sql = "SELECT * FROM ocupacao ORDER BY id ASC";
          $sql = $conn->prepare($sql);
          $sql->execute();

          $resultado = array();


          /* Retorno por meio de $row (objeto) é armazenado em resultado. 
          Retorno da consulta acima */

          while ($row = $sql->fetchObject('Ocupacao')) {

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