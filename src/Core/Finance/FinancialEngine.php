<?php
final class FinancialEngine
{
    public static function canAfford(float $budget, float $amount): bool
    {
        return $budget >= $amount;
    }

    // Applique le transfert d'argent entre deux équipes
    public static function transferBudget(PDO $pdo, int $fromTeamId, int $toTeamId, float $amount): bool
    {
        try {
            $pdo->beginTransaction();

            // Vérifier budget de l'équipe source
            $stmt = $pdo->prepare("SELECT budget FROM equipes WHERE id=? FOR UPDATE");
            $stmt->execute([$fromTeamId]);
            $fromBudget = (float)$stmt->fetchColumn();
            if(!self::canAfford($fromBudget, $amount)){
                throw new Exception("Budget insuffisant pour l'équipe source !");
            }

            // Retirer l'argent de l'équipe source
            $stmt = $pdo->prepare("UPDATE equipes SET budget=budget-? WHERE id=?");
            $stmt->execute([$amount,$fromTeamId]);

            // Ajouter l'argent à l'équipe destination
            $stmt = $pdo->prepare("UPDATE equipes SET budget=budget+? WHERE id=?");
            $stmt->execute([$amount,$toTeamId]);

            $pdo->commit();
            return true;

        } catch(Exception $e){
            $pdo->rollBack();
            echo "Erreur lors du transfert : ".$e->getMessage();
            return false;
        }
    }
}
