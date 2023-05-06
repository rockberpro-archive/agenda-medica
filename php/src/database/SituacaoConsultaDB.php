<?php

require_once "../database/Conexao.php";

class SituacaoConsultaDB
{

    public static function findSituacaoConsultaById(string $id): array
    {
        $pdo = self::ensureConnection();

        try {
            $sql = "SELECT * FROM situacao_consulta situacao
                WHERE situacao.id = :id";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();

            $resultSet[] = $stmt->fetchAll(PDO::FETCH_CLASS, "SituacaoConsulta");

            return $resultSet[0];
        } catch (PDOException $e) {
            echo "Erro: $e->getMessage()";
        }
    }

    public static function findAllSituacaoConsulta(): array
    {
        $pdo = self::ensureConnection();

        try {
            $stmt = $pdo->prepare("SELECT * FROM situacao_consulta");
            $stmt->execute();

            $resultSet[] = $stmt->fetchAll(PDO::FETCH_CLASS, "SituacaoConsulta");

            return $resultSet[0];
        } catch (PDOException $e) {
            echo "Erro: $e->getMessage()";
        }
    }

    private static function ensureConnection(): PDO
    {
        return Conexao::getConexao();
    }
}
