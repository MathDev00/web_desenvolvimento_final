<?php


/*

Modelagem do banco de dados. Funções para conexão com a tabela.
Retorno dos dados. 

*/
    class Ficha
    {

        public static function selecionaTodos()
        
        {

          //Conexao com banco de dados

          $conn =  Connection::getConn();  

          $sql = "SELECT 
          agendamento.id, 
          usuario_paciente.usuarios_nome AS paciente_nome,  
          usuario_funcionario.usuarios_nome AS funcionario_nome,
          ocupacao.nome_ocupacao AS ocupacao_funcionario,
          agendamento.data_inicio,
          agendamento.data_final,
          agendamento.titulo,
          agendamento.responsavel_agendamento
      FROM  
          agendamento
      INNER JOIN 
          paciente ON agendamento.paciente_id = paciente.id
      INNER JOIN 
          funcionario ON agendamento.funcionario_id = funcionario.id
      INNER JOIN 
          usuarios AS usuario_paciente ON paciente.usuarios_usuarios_id = usuario_paciente.usuarios_id
      INNER JOIN 
          usuarios AS usuario_funcionario ON funcionario.usuarios_usuarios_id = usuario_funcionario.usuarios_id
      INNER JOIN 
          ocupacao ON funcionario.ocupacao_id = ocupacao.id

          ORDER BY agendamento.id
      ";
          

          $sql = $conn->prepare($sql);
          $sql->execute();

          $resultado = array();


          /* Retorno por meio de $row (objeto) é armazenado em resultado. 
          Retorno da consulta acima */

          while ($row = $sql->fetchObject('Paciente')) {

            $resultado []  = $row; //$row->titulo, $row->conteudo

          }

          /* Array vazio!!! */ 

          if (!$resultado)  {

            throw  new Exception("Não foi encontrado nenhum registro");

          }


          return $resultado;


        }

        public static function selecionaPorId($idPost){

          $conn =  Connection::getConn();  

          $sql = "SELECT * FROM ficha

          WHERE  id = :id";
          $sql = $conn->prepare($sql);
          $sql->bindValue(':id', $idPost, PDO::PARAM_INT);
          $sql->execute();

          $resultado = $sql->fetchObject('Ficha');

          return $resultado; 
        }




        public static function insert($dadosPost)
        
        {
        
        $con = Connection::getConn();  

        $sql = $con->prepare('INSERT INTO ficha (conteudo, paciente_id, agendamento_id, funcionario_id) 
        VALUES  (:conteudo, :paciente_id, :agendamento_id, :funcionario_id)');

         $sql->bindValue(':conteudo', $dadosPost['conteudo'],PDO::PARAM_STR);   
         $sql->bindValue(':paciente_id', $dadosPost['paciente_id'],PDO::PARAM_STR);    
         $sql->bindValue(':agendamento_id', $dadosPost['agendamento_id'],PDO::PARAM_STR);    
         $sql->bindValue(':funcionario_id', $dadosPost['funcionario_id'],PDO::PARAM_STR);    

        $res = $sql->execute();
        echo '<script>alert("Publicação inserida!");</script>';         }
    

        public static function update($dadosPost)
		{

            var_dump($dadosPost);
			$con = Connection::getConn();

			$sql = "UPDATE ficha SET conteudo = :conteudo, agendamento_id = :agendamento_id, paciente_id = :paciente_id, funcionario_id = :funcionario_id
             WHERE id = :id";

			$sql = $con->prepare($sql);
			$sql->bindValue(':conteudo', $dadosPost['conteudo'],PDO::PARAM_STR);    
            $sql->bindValue(':agendamento_id', $dadosPost['agendamento_id'],PDO::PARAM_STR);    
            $sql->bindValue(':paciente_id', $dadosPost['paciente_id'],PDO::PARAM_STR);    
           $sql->bindValue(':funcionario_id', $dadosPost['funcionario_id'],PDO::PARAM_STR);    
           $sql->bindValue(':id', $dadosPost['id']);



            $resultado = $sql->execute();

			if ($resultado == 0) {
				throw new Exception("Falha ao alterar publicação");

				return false;
			}

			return true;
		}

        public static function delete($id)
		{
			$con = Connection::getConn();

			$sql = "DELETE FROM ficha
      WHERE id = :id;

      ";

			$sql = $con->prepare($sql);
			$sql->bindValue(':id', $id);
			$resultado = $sql->execute();

			if ($resultado == 0) {
				throw new Exception("Falha ao deletar publicação");

				return false;
			}

			return true;
		}

        public static function selecionarFicha($idFicha) {


            $con =  Connection::getConn();  
        
            $sql = "SELECT * FROM ficha WHERE paciente_id =  :paciente_id";
            $sql = $con->prepare($sql);
        
            $sql->bindValue(':paciente_id', $idFicha, PDO::PARAM_INT);
            $sql->execute();
        
            $resultado = array();
        
         
            while ($row = $sql->fetchObject('Ficha')) {
        
                $resultado[] = $row;
        
        
        
            }
        
        
        
            return $resultado;
        
        
        
        
           }

    }

?>