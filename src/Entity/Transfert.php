<?php

final class Transfert
{
    public ?PDO $pdo;
    public function __construct($pdo)
    {
        $this->pdo=$pdo;
    }
    public function transferPlayer(int $playerId, int $fromTeamId, int $toTeamId, float $amount)
    {
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("SELECT id, budget FROM equipes WHERE id IN (?, ?) FOR UPDATE");
            $stmt->execute([$fromTeamId, $toTeamId]);
            $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($teams) < 2) {
                throw new Exception("Une des équipes est introuvable.");
            }

            $fromBudget = 0;
            $toBudget = 0;
            foreach ($teams as $team) {
                if ($team['id'] == $fromTeamId) $fromBudget = (float)$team['budget'];
                if ($team['id'] == $toTeamId) $toBudget = (float)$team['budget'];
            }

            if ($toBudget < $amount) {
                throw new Exception("L'équipe destination n'a pas assez de budget !");
            }


            $stmt = $this->pdo->prepare("UPDATE equipes SET budget = budget - ? WHERE id = ?");
            $stmt->execute([$amount, $fromTeamId]);

            $stmt = $this->pdo->prepare("UPDATE equipes SET budget = budget + ? WHERE id = ?");
            $stmt->execute([$amount, $toTeamId]);

            $stmt = $this->pdo->prepare("UPDATE equipe_joueur SET equipe_id = ? WHERE joueur_id = ?");
            $stmt->execute([$toTeamId, $playerId]);

            $this->pdo->commit();

        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
    
}
