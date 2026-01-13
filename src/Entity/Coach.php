<?php
require_once 'Personne.php';

class Coach extends Personne
{
    public ?int $person_id = null;
    public ?int $teamId = null;

    public function __construct(
        public string $name,
        public string $email,
        public string $nationality,
        public string $coaching_style,
        public int $years_of_experience,

    ) {
        parent::__construct($name, $email, $nationality);
    }

}
