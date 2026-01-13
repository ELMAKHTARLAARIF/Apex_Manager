<?php
abstract class Personne {
    public ?int $person_id = null;

    public function __construct(
        public string $name,
        public string $email,
        public string $nationality,
    ) {}

}