<?php

class CoachRepo
{
    public int $person_id;

    public static function  create(PDO $pdo, Coach $coach): void
    {
        $stmt = $pdo->prepare(
            "INSERT INTO persons (name, email, nationality) VALUES (?, ?, ?)"
        );
        $stmt->execute([
            $coach->name,
            $coach->email,
            $coach->nationality
        ]);
        $coach->person_id = (int) $pdo->lastInsertId();

        $stmt = $pdo->prepare("INSERT INTO coachs (person_id,coaching_style,years_of_experience) VALUES (?,?,?)");
        $stmt->execute([
            $coach->person_id,
            $coach->coaching_style,
            $coach->years_of_experience,
        ]);
    }
    public static function deleteCoach(PDO $pdo, int $coachId): bool
    {
        $stmt = $pdo->prepare("DELETE FROM persons WHERE id = ?");
        $stmt->execute([$coachId]);
        return $stmt->rowCount() > 0;
    }

    public static function getCoach(PDO $pdo, int $coachId)
    {
        $stmt = $pdo->prepare("
            SELECT coachs.person_id, coachs.coaching_style, coachs.years_of_experience,
                   persons.name, persons.email, persons.nationality
            FROM coachs 
            JOIN persons persons ON persons.id = coachs.person_id
            WHERE coachs.person_id = ?
        ");
        $stmt->execute([$coachId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public static function update(PDO $pdo, Coach $coach)
    {
        $stmt = $pdo->prepare("
            UPDATE persons SET name = ?, email = ?, nationality = ?
            WHERE id = ?
        ");
        $stmt->execute([
            $coach->name,
            $coach->email,
            $coach->nationality,
            $coach->person_id
        ]);


        $stmt = $pdo->prepare("
            UPDATE coachs SET coaching_style = ?, years_of_experience = ?
            WHERE person_id = ?
        ");
        $stmt->execute([
            $coach->coaching_style,
            $coach->years_of_experience,
            $coach->person_id
        ]);

        return $stmt;
    }



    public function addToTeam(PDO $pdo,$person_id, int $teamId, float $salary = 0): void
    {
        if ($person_id) {
            throw new Exception("Coach person_id is not set.");
        }

        $stmt = $pdo->prepare("
            INSERT INTO contracts (
                person_id,
                team_id,
                salary,
                start_date,
                end_date
            ) VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $person_id,
            $teamId,
            $salary,
            date('Y-m-d'),
            date('Y-m-d', strtotime('+1 year'))
        ]);
    }


    public static function all(PDO $pdo): array
    {
        $stmt = $pdo->query("
        SELECT c.person_id, c.coaching_style, c.years_of_experience,
               p.name AS name, p.email, p.nationality
        FROM coachs c
        JOIN persons p ON p.id = c.person_id
    ");

        $coaches = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $coach = new Coach(
                $row['name'],
                $row['email'],
                $row['nationality'],
                $row['coaching_style'],
                (int)$row['years_of_experience'],

            );
            $coach->person_id = (int)$row['person_id'];
            $coaches[] = $coach;
        }

        return $coaches;
    }
}
