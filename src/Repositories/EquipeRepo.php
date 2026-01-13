<?php

class EquipeRepo
{
    public function save(PDO $pdo, Equipe $equipe): void
    {
        if ($equipe->id !== null) {
            $stmt = $pdo->prepare(
                "UPDATE teams SET name=?, budget=?, manager=? WHERE id=?"
            );
            $stmt->execute([
                $equipe->name,
                $equipe->budget,
                $equipe->manager,
                $equipe->id
            ]);
        } else {
            $stmt = $pdo->prepare(
                "INSERT INTO teams (name, budget, manager) VALUES (?, ?, ?)"
            );
            $stmt->execute([
                $equipe->name,
                $equipe->budget,
                $equipe->manager
            ]);
            $equipe->id = (int)$pdo->lastInsertId();
        }
    }

    public function createEquipe($pdo, Equipe $equipe): void
    {

        $stmt = $pdo->prepare("INSERT INTO teams (name,budget,manager) VALUE (?,?,?)");
        $stmt->execute([$equipe->name, $equipe->budget, $equipe->manager]);
        $equipe->id = $pdo->lastInsertId();
    }

    public function updateEquipe($pdo, Equipe $equipe)
    {
        if ($equipe->id === null) {
            throw new InvalidArgumentException(
                "Cannot update an Equipe without an ID"
            );
        }
        $stmt = $pdo->prepare("UPDATE teams set name = ?  budget = ? manager = ?");
        $stmt->execute([$equipe->name, $equipe->budget, $equipe->manager, $equipe->id]);
    }

    public static function all(PDO $pdo): array
    {
        $stmt = $pdo->query("SELECT * FROM teams ORDER BY name ASC");

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function find(PDO $pdo, int $id): ?Equipe
    {
        $stmt = $pdo->prepare("SELECT * FROM teams WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $team = new Equipe($row['name'], (float)$row['budget'], $row['manager']);
        $team->id = (int)$row['id'];
        return $team;
    }

    public static function updateBudget(PDO $pdo, int $id, float $newBudget): bool
    {
        $stmt = $pdo->prepare(
            "UPDATE teams SET budget = :budget WHERE id = :id"
        );
        return $stmt->execute([
            'budget' => $newBudget,
            'id' => $id
        ]);
    }

    public static function deleteEquipe(PDO $pdo, int $id): bool
    {
        $stmt = $pdo->prepare("DELETE FROM teams WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
