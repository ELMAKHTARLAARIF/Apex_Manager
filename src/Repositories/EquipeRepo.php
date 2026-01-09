<?php

class EquipeRepo
{
    public function save(PDO $pdo, Equipe $equipe): void
    {
        if ($equipe->id !== null) {
            $stmt = $pdo->prepare(
                "UPDATE equipes SET nom=?, budget=?, manager=? WHERE id=?"
            );
            $stmt->execute([
                $equipe->nom,
                $equipe->budget,
                $equipe->manager,
                $equipe->id
            ]);
        } else {
            $stmt = $pdo->prepare(
                "INSERT INTO equipes (nom, budget, manager) VALUES (?, ?, ?)"
            );
            $stmt->execute([
                $equipe->nom,
                $equipe->budget,
                $equipe->manager
            ]);
            $equipe->id = (int)$pdo->lastInsertId();
        }
    }

    public function createEquipe($pdo,Equipe $equipe):void{

        $stmt = $pdo->prepare("INSERT INTO equipes (nom,budget,manager) VALUE (?,?,?)");
        $stmt->execute([$equipe->nom,$equipe->budget,$equipe->manager]);
        $equipe->id = $pdo->lastInsertId();
        
    }

    public function updateEquipe($pdo,Equipe $equipe){
        if ($equipe->id === null) {
            throw new InvalidArgumentException(
                "Cannot update an Equipe without an ID"
            );
        }
        $stmt = $pdo->prepare("UPDATE equipes set nom = ?  budget = ? manager = ?");
        $stmt->execute([$equipe->nom,$equipe->budget,$equipe->manager,$equipe->id]);
    }

    public static function all(PDO $pdo): array
    {
        $stmt = $pdo->query("SELECT * FROM equipes ORDER BY nom ASC");
        $teams = [];

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $t) {
            $team = new Equipe($t['nom'], (float)$t['budget'], $t['manager']);
            $team->id = (int)$t['id'];
            $teams[] = $team;
        }
        return $teams;
    }

    public static function find(PDO $pdo, int $id): ?Equipe
    {
        $stmt = $pdo->prepare("SELECT * FROM equipes WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $team = new Equipe($row['nom'], (float)$row['budget'], $row['manager']);
        $team->id = (int)$row['id'];
        return $team;
    }

    public static function updateBudget(PDO $pdo, int $id, float $newBudget): bool
    {
        $stmt = $pdo->prepare(
            "UPDATE equipes SET budget = :budget WHERE id = :id"
        );
        return $stmt->execute([
            'budget' => $newBudget,
            'id' => $id
        ]);
    }

    public static function deleteEquipe(PDO $pdo, int $id): bool
    {
        $stmt = $pdo->prepare("DELETE FROM equipes WHERE id = ?");
        return $stmt->execute([$id]);
    }

}
