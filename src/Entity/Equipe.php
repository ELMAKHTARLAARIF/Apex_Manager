<?php
class Equipe
{
    public ?int $id = null;

    public function __construct(
        public string $nom,
        public float $budget,
        public string $manager
    ) {}

    public function save(PDO $pdo): void
    {
        if ($this->id) {
            $stmt = $pdo->prepare("UPDATE equipes SET nom=?, budget=?, manager=? WHERE id=?");
            $stmt->execute([$this->nom, $this->budget, $this->manager, $this->id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO equipes (nom, budget, manager) VALUES (?, ?, ?)");
            $stmt->execute([$this->nom, $this->budget, $this->manager]);
            $this->id = (int)$pdo->lastInsertId();
        }
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
    public function updateBudget(PDO $pdo, float $newBudget): bool
    {
        $stmt = $pdo->prepare(
            "UPDATE equipes SET budget = :budget WHERE id = :id"
        );
        return $stmt->execute([
            'budget' => $newBudget,
            'id' => $this->id
        ]);
        return $this->id;
    }

    public static function find(PDO $pdo, int $id): ?Equipe
    {
        $stmt = $pdo->prepare("SELECT * FROM equipes WHERE id=?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Equipe($row['nom'], (float)$row['budget'], $row['manager']);
        }
        return null;
    }
}
