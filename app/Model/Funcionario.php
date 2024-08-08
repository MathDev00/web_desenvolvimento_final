<?php


/*

Modelagem do banco de dados. Funções para conexão com a tabela.
Retorno dos dados. 

*/
    class Funcionario 
    {


      public static function listaFuncionarios() {

        //Conexao com banco de dados

        $conn =  Connection::getConn();  

        $sql = "SELECT *
        FROM usuarios
        INNER JOIN funcionario ON funcionario.usuarios_usuarios_id = usuarios.usuarios_id
      
        ";
        

        $sql = $conn->prepare($sql);
        $sql->execute();

        $resultado = array();


        /* Retorno por meio de $row (objeto) é armazenado em resultado. 
        Retorno da consulta acima */

        while ($row = $sql->fetchObject('Funcionario')) {

          $resultado []  = $row; //$row->titulo, $row->conteudo

        }

        /* Array vazio!!! */ 

        if (!$resultado)  {

          throw  new Exception("Não foi encontrado nenhum registro");

        }


        return $resultado;





      }








        public static function selecionaTodos()
        
        {

          //Conexao com banco de dados

          $conn =  Connection::getConn();  

          $sql = "SELECT funcionario.id, funcionario.ocupacao_id, usuarios.usuarios_id, usuarios.usuarios_nome, usuarios.genero, usuarios.usuarios_cpf, funcionario.email, 
          funcionario.data_nascimento, enderecos.endereco_cep,enderecos.enderecos_nome,enderecos.endereco_bairro, ocupacao.nome_ocupacao,cidades.cidades_nome 
          FROM  usuarios
          INNER JOIN funcionario ON funcionario.usuarios_usuarios_id = usuarios.usuarios_id
          INNER JOIN enderecos ON enderecos.usuarios_usuarios_id = usuarios.usuarios_id
          INNER JOIN ocupacao on ocupacao.id = funcionario.ocupacao_id
          INNER JOIN cidades on cidades.cidades_id = enderecos.cidades_cidades_id
          
          ";
          

          $sql = $conn->prepare($sql);
          $sql->execute();

          $resultado = array();


          /* Retorno por meio de $row (objeto) é armazenado em resultado. 
          Retorno da consulta acima */

          while ($row = $sql->fetchObject('Funcionario')) {

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

          $sql = "SELECT funcionario.id,funcionario.ocupacao_id, usuarios.usuarios_id, cidades.cidades_id, usuarios.usuarios_nome, usuarios.genero, usuarios.usuarios_cpf, funcionario.email, funcionario.data_nascimento,
          enderecos.endereco_cep,enderecos.enderecos_nome,enderecos.endereco_bairro,enderecos.enderecos_numero, enderecos.enderecos_complemento,  enderecos.enderecos_padrao, ocupacao.nome_ocupacao,cidades.cidades_nome 
          FROM  usuarios
          INNER JOIN funcionario ON funcionario.usuarios_usuarios_id = usuarios.usuarios_id
          INNER JOIN enderecos ON enderecos.usuarios_usuarios_id = usuarios.usuarios_id
          INNER JOIN ocupacao on ocupacao.id = funcionario.ocupacao_id
          INNER JOIN cidades on cidades.cidades_id = enderecos.cidades_cidades_id 
      
          WHERE funcionario.usuarios_usuarios_id = :id";
          $sql = $conn->prepare($sql);
          $sql->bindValue(':id', $idPost, PDO::PARAM_INT);
          $sql->execute();

          $resultado = $sql->fetchObject('Funcionario');

          return $resultado; 
        }




        public static function insert($dadosPost)
        
        {
          $con = Connection::getConn();  

          var_dump($_POST);    


          $sql = $con->prepare('INSERT INTO usuarios (usuarios_nome, usuarios_cpf, pass, genero) VALUES (:usuarios_nome, :usuarios_cpf, :pass, :genero)'); 


          $sql->bindValue(':usuarios_nome', $dadosPost['nome'] ,PDO::PARAM_STR);    
          $sql->bindValue(':usuarios_cpf', $dadosPost['cpf'],PDO::PARAM_STR);    
          $sql->bindValue(':genero', $dadosPost['genero'],PDO::PARAM_STR);      
          $sql->bindValue(':pass', $dadosPost['password'],PDO::PARAM_STR);      

          $res = $sql->execute();

          $lastId = $con->lastInsertId();

          $sql = $con->prepare('INSERT INTO funcionario (data_nascimento, email, ocupacao_id, usuarios_usuarios_id) 
          VALUES (:data_nascimento, :email, :ocupacao_id, :usuarios_usuarios_id)'); 

          $data = date("Y-m-d", strtotime(str_replace('/', '-', $dadosPost['data_nascimento'])));
          $sql->bindValue(':data_nascimento', $data, PDO::PARAM_STR);
          $sql->bindValue(':email', $dadosPost['email'],PDO::PARAM_STR);    
          $sql->bindValue(':ocupacao_id', $dadosPost['ocupacao'],PDO::PARAM_STR);    
          $sql->bindValue(':usuarios_usuarios_id', $lastId,PDO::PARAM_STR);      


          $res = $sql->execute();

         $sql = $con->prepare('INSERT INTO enderecos (enderecos_nome, enderecos_numero, enderecos_complemento,endereco_bairro,endereco_cep,enderecos_padrao,cidades_cidades_id, usuarios_usuarios_id) 
         VALUES (:enderecos_nome, :enderecos_numero, :enderecos_complemento, :endereco_bairro, :endereco_cep, :enderecos_padrao, :cidades_cidades_id, :usuarios_usuarios_id)'); 

          $sql->bindValue(':enderecos_nome', $dadosPost['endereco_nome'],PDO::PARAM_STR);    
          $sql->bindValue(':enderecos_numero', $dadosPost['endereco_numero'],PDO::PARAM_INT);    
          $sql->bindValue(':enderecos_complemento', $dadosPost['endereco_complemento'],PDO::PARAM_STR);     
          $sql->bindValue(':endereco_bairro', $dadosPost['endereco_bairro'],PDO::PARAM_STR);                         
          $sql->bindValue(':endereco_cep', $dadosPost['endereco_cep'],PDO::PARAM_STR);      
          $sql->bindValue(':enderecos_padrao', $dadosPost['endereco_padrao'],PDO::PARAM_STR);      
          $sql->bindValue(':cidades_cidades_id', $dadosPost['cidade_id'],PDO::PARAM_INT);      
          $sql->bindValue(':usuarios_usuarios_id',  $lastId ,PDO::PARAM_INT);      


          $res = $sql->execute();

          //$sql_endereco =  "SELECT * FROM user WHERE user_cpf = $dadosPost['cpf']";


          if ($res == 0) {
            throw new Exception("Falha ao inserir publicação");
    
            return false;
          }
    
          return true;
        }

        public static function update($dadosPost)
		{
			$con = Connection::getConn();

			$sql = "UPDATE usuarios SET usuarios_nome = :usuarios_nome, usuarios_cpf = :usuarios_cpf, genero = :genero WHERE usuarios_id = :usuarios_id";

			$sql = $con->prepare($sql);
      
			$sql->bindValue(':usuarios_nome', $dadosPost['nome'],PDO::PARAM_STR);    
      $sql->bindValue(':usuarios_cpf', $dadosPost['cpf'],PDO::PARAM_STR);    
      $sql->bindValue(':genero', $dadosPost['genero'],PDO::PARAM_STR); 
      $sql->bindValue(':usuarios_id', $dadosPost['id']);

      $resultado = $sql->execute();

      $sql = $con->prepare('UPDATE funcionario SET data_nascimento = :data_nascimento, email = :email, ocupacao_id  = :ocupacao_id WHERE usuarios_usuarios_id = :usuarios_usuarios_id'); 

      $data = date("Y-m-d", strtotime(str_replace('/', '-', $dadosPost['data_nascimento'])));
      $sql->bindValue(':data_nascimento', $data, PDO::PARAM_STR);
      $sql->bindValue(':email', $dadosPost['email'],PDO::PARAM_STR);    
      $sql->bindValue(':ocupacao_id', $dadosPost['ocupacao'],PDO::PARAM_STR);    
      $sql->bindValue(':usuarios_usuarios_id', $dadosPost['id'],PDO::PARAM_STR);   

          $resultado = $sql->execute();

      $sql = $con->prepare('UPDATE enderecos SET enderecos_nome = :enderecos_nome, enderecos_numero = :enderecos_numero, enderecos_complemento  = :enderecos_complemento,
      endereco_bairro = :endereco_bairro, endereco_cep = :endereco_cep,enderecos_padrao = :enderecos_padrao, cidades_cidades_id = :cidades_cidades_id
      WHERE usuarios_usuarios_id = :usuarios_usuarios_id'); 

      $sql->bindValue(':enderecos_nome', $dadosPost['endereco_nome'],PDO::PARAM_STR);    
      $sql->bindValue(':enderecos_numero', $dadosPost['endereco_numero'],PDO::PARAM_INT);    
      $sql->bindValue(':enderecos_complemento', $dadosPost['endereco_complemento'],PDO::PARAM_STR);     
      $sql->bindValue(':endereco_bairro', $dadosPost['endereco_bairro'],PDO::PARAM_STR);                         
      $sql->bindValue(':endereco_cep', $dadosPost['endereco_cep'],PDO::PARAM_STR);      
      $sql->bindValue(':enderecos_padrao', $dadosPost['endereco_padrao'],PDO::PARAM_STR);      
      $sql->bindValue(':cidades_cidades_id', $dadosPost['cidade_id'],PDO::PARAM_INT);      
      $sql->bindValue(':usuarios_usuarios_id',  $dadosPost['id'] ,PDO::PARAM_INT);      
     
      $resultado = $sql->execute();


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

			$sql = "DELETE funcionario
      FROM funcionario
      WHERE usuarios_usuarios_id = :id;
      
      DELETE enderecos
      FROM enderecos
      WHERE usuarios_usuarios_id = :id;
      
      DELETE FROM usuarios
      WHERE usuarios_id = :id;
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