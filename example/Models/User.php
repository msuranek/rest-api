<?php
namespace Models;

class User implements \JsonSerializable
{
    private int $id;
    private string $name;
    private string $email;
    private ?int $age;

    public function __construct(int $id, string $name, string $email, ?int $age = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->age = $age;
    }

    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getEmail(): string { return $this->email; }
    public function getAge(): ?int { return $this->age; }

    public function jsonSerialize(): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'email' => $this->email,
            'age'   => $this->age,
        ];
    }
}
