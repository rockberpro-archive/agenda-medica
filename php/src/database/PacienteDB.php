<?php

require_once "../database/Conexao.php";

class PacienteDB
{

    public static function findPacienteById(string $id): array
    {
        $pdo = self::ensureConnection();

        try {
            $sql = "SELECT * FROM pessoa
                        RIGHT JOIN paciente ON pessoa.id = paciente.ref_pessoa
                    WHERE paciente.ref_pessoa = :id";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();

            $resultSet[] = $stmt->fetchAll(PDO::FETCH_CLASS, "Paciente");

            return $resultSet[0];
        } catch (PDOException $e) {
            echo "Erro: $e->getMessage()";
        }
    }

    public static function pacienteAlreadyExists(string $cpf): bool
    {
        $pdo = self::ensureConnection();

        try {
            $sql = "SELECT COUNT(*) FROM pessoa
                    WHERE pessoa.cpf = :cpf";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchColumn();

            return $result > 0;
        } catch (PDOException $e) {
            echo "Erro: $e->getMessage()";
        }
    }

    public static function findAllPacientes(): array
    {
        $pdo = self::ensureConnection();

        try {
            $stmt = $pdo->prepare(" SELECT * FROM pessoa
                                             RIGHT JOIN paciente
                                             ON pessoa.id = paciente.ref_pessoa
                                  ");
            $stmt->execute();

            $resultSet[] = $stmt->fetchAll(PDO::FETCH_CLASS, "Paciente");

            return $resultSet[0];
        } catch (PDOException $e) {
            echo "Erro: $e->getMessage()";
        }
    }

    public static function registerPaciente(array $post)
    {
        $pdo = self::ensureConnection();

        try {
            // INSERT tabela "pessoa"
            $dados = [
                'nome' => $post['nome'],
                'cpf' => $post['cpf'],
                'telefone' => $post['telefone'],
                'email' => $post['email']
            ];

            $sql = "INSERT INTO pessoa (nome, cpf, telefone, email, data_cadastro) 
                    VALUES (:nome, :cpf, :telefone, :email, date_trunc('second', now()::timestamp))";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($dados);

            // INSERT tabela "paciente"
            $cpf = $post['cpf'];
            $stmt = $pdo->prepare("SELECT id FROM pessoa WHERE cpf = '{$cpf}'");
            $stmt->execute();
            $resultSet = $stmt->fetchAll();

            $id_paciente = "";
            foreach ($resultSet as $row) {
                $id_paciente = $row['id'];
            }

            $stmt = $pdo->prepare("INSERT INTO paciente (ref_pessoa) 
                                   VALUES (:ref_pessoa)");
            $stmt->bindParam(':ref_pessoa', $id_paciente, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro: $e->getMessage()";
        }
    }

    public static function updatePaciente(array $post)
    {
        $pdo = self::ensureConnection();

        try {
            $dados = [
                'id_paciente' => $post['id_paciente'],
                'nome' => $post['nome'],
                'cpf' => $post['cpf'],
                'telefone' => $post['telefone'],
                'email' => $post['email'],
            ];

            $sql = "UPDATE pessoa SET  nome = :nome,
                                       cpf = :cpf,
                                       telefone = :telefone,
                                       email = :email
                    WHERE id = :id_paciente";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($dados);
        } catch (PDOException $e) {
            echo "Erro: $e->getMessage()";
        }
    }

    public static function removePacienteById(int $id)
    {
        $pdo = self::ensureConnection();

        if (self::pacienteConsultaAssociada($id)) {
            echo "<script>alert('Paciente não pode ser removido, há consultas associadas!');</script>";
            return;
        }

        try {
            $stmt = $pdo->prepare("DELETE FROM paciente WHERE ref_pessoa = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $stmt = $pdo->prepare("DELETE FROM pessoa WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro: $e->getMessage()";
        }
    }

    public static function pacienteConsultaAssociada(int $id): bool
    {
        $pdo = self::ensureConnection();

        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM consulta WHERE ref_paciente = :id;");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchColumn(0);

            return $result > 0 ? true : false;
        } catch (PDOException $e) {
            echo "Erro: $e->getMessage()";
        }
    }

    private static function ensureConnection(): PDO
    {
        return Conexao::getConexao();
    }
}
