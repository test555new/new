<?php

class AccountModel
{
    public int $id;
    public string $username;
    public string $email;
    public string $phone;
    public string $passwordHash;
    public string $address;
    public ?string $avatar;
    public string $role;

    public function __construct(
        int $id,
        string $username,
        string $email,
        string $phone,
        string $passwordHash,
        string $address,
        ?string $avatar = null,
        string $role = 'user'
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->phone = $phone;
        $this->passwordHash = $passwordHash;
        $this->address = $address;
        $this->avatar = $avatar;
        $this->role = $role;
    }
}