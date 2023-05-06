<?php

require_once "../database/Conexao.php";

class MedicoDB
{

    public static function findMedicoById($id): array
    {
        $pdo = self::ensureConnection();

        try {
            $sql = "SELECT * FROM pessoa
                        RIGHT JOIN medico ON pessoa.id = medico.ref_pessoa
                    WHERE medico.ref_pessoa = :id";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();

            $resultSet[] = $stmt->fetchAll(PDO::FETCH_CLASS, "Medico");

            return $resultSet[0];
        } catch (PDOException $e) {
            echo "Erro: $e->getMessage()";
        }
    }

    public static function medicoAlreadyExists(string $cpf): bool
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
        } catch (Exception $e) {
            echo "Erro: $e->getMessage()";
        }
    }

    public static function findAllMedicos(): array
    {
        $pdo = self::ensureConnection();

        try {
            $stmt = $pdo->prepare(" SELECT * FROM pessoa
                                             RIGHT JOIN medico
                                             ON pessoa.id = medico.ref_pessoa
                                  ");
            $stmt->execute();

            $resultSet[] = $stmt->fetchAll(PDO::FETCH_CLASS, "Medico");

            return $resultSet[0];
        } catch (Exception $e) {
            echo "Erro: $e->getMessage()";
        }
    }

    public static function registerMedico(array $post)
    {
        $pdo = self::ensureConnection();

        try {
            // INSERT entidade "pessoa"
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

            // INSERT entidade "medico"
            $cpf = $post['cpf'];
            $stmt = $pdo->prepare("SELECT id FROM pessoa WHERE cpf = '{$cpf}'");
            $stmt->execute();
            $resultSet = $stmt->fetchAll();

            $id_medico = "";
            foreach ($resultSet as $row) {
                $id_medico = $row['id'];
            }

            $crm_medico = $post['codigo-crm'];
            $stmt = $pdo->prepare("INSERT INTO medico (ref_pessoa, codigo_crm) 
                                          VALUES (:ref_pessoa, :codigo_crm)");
            $stmt->bindParam(':ref_pessoa', $id_medico, PDO::PARAM_INT);
            $stmt->bindParam(':codigo_crm', $crm_medico, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro: $e->getMessage()";
        }
    }

    public static function updateMedico(array $post)
    {
        $pdo = self::ensureConnection();

        try {
            $dados = [
                'id_medico' => $post['id_medico'],
                'nome' => $post['nome'],
                'cpf' => $post['cpf'],
                'telefone' => $post['telefone'],
                'email' => $post['email'],
            ];

            $sql = "UPDATE pessoa SET  nome = :nome,
                                       cpf = :cpf,
                                       telefone = :telefone,
                                       email = :email
                    WHERE id = :id_medico";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($dados);

            $sql = "UPDATE medico SET codigo_crm = :codigo_crm
                    WHERE ref_pessoa = :id_medico ";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_medico', $post['id_medico'], PDO::PARAM_INT);
            $stmt->bindParam(':codigo_crm', $post['codigo_crm'], PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro: $e->getMessage()";
        }
    }

    public static function removeMedicoById(int $id)
    {
        $pdo = self::ensureConnection();

        if (self::medicoConsultaAssociada($id)) {
            echo "<script>alert('Médico não pode ser removido, há consultas associadas!');</script>";
            return;
        }

        try {
            $stmt = $pdo->prepare("DELETE FROM medico WHERE ref_pessoa = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $stmt = $pdo->prepare("DELETE FROM pessoa WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro: $e->getMessage()";
        }
    }

    public static function medicoConsultaAssociada(int $id): bool
    {
        $pdo = self::ensureConnection();

        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM consulta WHERE ref_medico = :id;");
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
