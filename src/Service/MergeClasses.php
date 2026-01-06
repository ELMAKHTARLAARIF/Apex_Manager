<?php
class MergeClasses
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    public function getJoueurDetailes()
    {
        $sql = "
            SELECT 
                joueurs.pseudo,
                joueurs.role,
                Equipe.nom AS equipe
            FROM joueurs
            LEFT JOIN equipe_joueur ON equipe_joueur.joueur_id = joueurs.id
            LEFT JOIN equipes Equipe ON equipe_joueur.equipe_id = Equipe.id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
}