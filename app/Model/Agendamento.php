<?php


/*

Modelagem do banco de dados. Funções para conexão com a tabela.
Retorno dos dados. 

*/
    class Agendamento
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

      
          WHERE  agendamento.id = :id";
          $sql = $conn->prepare($sql);
          $sql->bindValue(':id', $idPost, PDO::PARAM_INT);
          $sql->execute();

          $resultado = $sql->fetchObject('paciente');

          return $resultado; 
        }




        public static function insert($dadosPost)
        
        {
        $con = Connection::getConn();  

        //var_dump($_POST);    

        $sql = "SELECT * 
        FROM agendamento
        WHERE 
            (
                (data_inicio >= :data_inicio AND data_inicio <= :data_final)
                OR
                (data_final >= :data_inicio AND data_final <= :data_final)
                OR
                (data_inicio <= :data_inicio AND data_final >= :data_final)
            )
            AND funcionario_id = :funcionario_id";

        $consulta = $con->prepare($sql);
        $consulta->bindValue(':paciente_id', $dadosPost['paciente_id']);    

        $data_inicio = date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $dadosPost['data_inicio'])));
        $consulta->bindValue(':data_inicio', $data_inicio);

        $data_final = date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $dadosPost['data_final'])));
        $consulta->bindValue(':data_final', $data_final);
        $consulta->bindValue(':funcionario_id', $dadosPost['funcionario_id']);    

        $consulta->execute();

        if($consulta->rowCount() > 0){
        echo '<script>alert("Já exise agendamento para o horário!");</script>';     
        }

        else{ 

        // $data = $da    

        $sql = $con->prepare('INSERT INTO agendamento (titulo, paciente_id, data_inicio, data_final, responsavel_agendamento, funcionario_id) 
        VALUES  (:titulo, :paciente_id, :data_inicio, :data_final, :responsavel_agendamento, :funcionario_id)');

         $sql->bindValue(':titulo', $dadosPost['titulo'],PDO::PARAM_STR);    
         $sql->bindValue(':paciente_id', $dadosPost['paciente_id'],PDO::PARAM_STR);    

        $data_inicio = date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $dadosPost['data_inicio'])));
        $sql->bindValue(':data_inicio', $data_inicio, PDO::PARAM_STR);

        $data_final = date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $dadosPost['data_final'])));
        $sql->bindValue(':data_final', $data_final, PDO::PARAM_STR);

        $sql->bindValue(':responsavel_agendamento', $dadosPost['responsavel_agendamento'],PDO::PARAM_STR);    
        $sql->bindValue(':funcionario_id', $dadosPost['funcionario_id'],PDO::PARAM_STR);    


        $res = $sql->execute();
        /* echo '<script>alert("Publicação inserida!");</script>'; */        }
    }

        public static function update($dadosPost)
		{

            //var_dump($dadosPost);
			$con = Connection::getConn();

			$sql = "UPDATE agendamento SET titulo = :titulo, paciente_id = :paciente_id, 
            data_inicio = :data_inicio ,data_final = :data_final, responsavel_agendamento = :responsavel_agendamento,
            funcionario_id = :funcionario_id
             WHERE id = :id";

			$sql = $con->prepare($sql);
			$sql->bindValue(':titulo', $dadosPost['titulo'],PDO::PARAM_STR);    
            $sql->bindValue(':paciente_id', $dadosPost['paciente_id'],PDO::PARAM_STR);    

           $data = date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $dadosPost['data_inicio'])));
           $sql->bindValue(':data_inicio', $data, PDO::PARAM_STR);

           $data = date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $dadosPost['data_final'])));
           $sql->bindValue(':data_final', $data, PDO::PARAM_STR);

           $sql->bindValue(':responsavel_agendamento', $dadosPost['responsavel_agendamento'],PDO::PARAM_STR);    
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

			$sql = "DELETE FROM agendamento
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


    }

?>