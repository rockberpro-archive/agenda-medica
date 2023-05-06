<?php

class ConsultaDB
{

    public static function findConsultaById(string $id): array
    {
        $pdo = self::ensureConnection();

        try {

            $sql = "SELECT * FROM consulta consulta
                    WHERE consulta.id = :id";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();

            $resultSet[] = $stmt->fetchAll(PDO::FETCH_CLASS, "Consulta");
            $stmt->closeCursor();

            return $resultSet[0];
        } catch (PDOException $e) {
            echo "erro: $e->getMessage()";
        }
    }

    public static function registerConsulta(array $post)
    {
        $pdo = self::ensureConnection();

        try {

            $dados = [
                'hora_inicio'           => $post['hora_inicio'],
                'hora_fim'              => $post['hora_fim'],
                'diagnostico'           => $post['diagnostico'],
                'receita'               => $post['receita'],
                'ref_paciente'          => $post['ref_paciente'],
                'ref_medico'            => $post['ref_medico'],
                'ref_situacao_consulta' => $post['ref_situacao_consulta']
            ];

            $sql = "INSERT INTO consulta ( hora_inicio,
                                           hora_fim, diagnostico,
                                           receita, ref_paciente,
                                           ref_medico,
                                           ref_situacao_consulta
                                         )
                                  VALUES ( :hora_inicio, 
                                           :hora_fim, 
                                           :diagnostico, 
                                           :receita, 
                                           :ref_paciente, 
                                           :ref_medico, 
                                           :ref_situacao_consulta
                                          )";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($dados);
            $stmt->closeCursor();
        } catch (PDOException $e) {
            echo "erro: $e->getMessage()";
        }
    }

    public static function removeConsultaById(int $id)
    {
        $pdo = self::ensureConnection();

        try {

            $stmt = $pdo->prepare("DELETE FROM consulta WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
        } catch (PDOException $e) {
            echo "erro: $e->getMessage()";
        }
    }

    public static function findAllConsultas(): array
    {
        $pdo = self::ensureConnection();

        try {
            $stmt = $pdo->prepare("SELECT * FROM consulta");
            $stmt->execute();

            $resultSet[] = $stmt->fetchAll(PDO::FETCH_CLASS, "Consulta");
            $stmt->closeCursor();

            return $resultSet[0];
        } catch (Exception $e) {
            echo "erro: $e->getMessage()";
        }
    }

    public static function updateConsulta(array $post)
    {
        $pdo = self::ensureConnection();

        try {

            $dados = [
                'hora_inicio'            => $post['hora_inicio'],
                'hora_fim'               => $post['hora_fim'],
                'diagnostico'            => $post['diagnostico'],
                'receita'                => $post['receita'],
                'ref_paciente'           => $post['ref_paciente'],
                'ref_medico'             => $post['ref_medico'],
                'ref_situacao_consulta'  => $post['ref_situacao_consulta'],
                'id_consulta'            => $post['id_consulta']
            ];

            $sql = "UPDATE consulta SET hora_inicio            = :hora_inicio,
                                        hora_fim               = :hora_fim,
                                        diagnostico            = :diagnostico,
                                        receita                = :receita,
                                        ref_paciente           = :ref_paciente,
                                        ref_medico             = :ref_medico,
                                        ref_situacao_consulta  = :ref_situacao_consulta
                    WHERE id = :id_consulta";

            $pdo = Conexao::getConexao();

            $stmt = $pdo->prepare($sql);
            $stmt->execute($dados);
            $stmt->closeCursor();
        } catch (PDOException $e) {
            echo "erro: $e->getMessage()";
        }
    }

    private static function ensureConnection(): PDO
    {
        return Conexao::getConexao();
    }
}
