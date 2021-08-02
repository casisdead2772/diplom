<?php

namespace App\Dto\v1\Api\User;

final class UserStoreDto
{
    /** @var string */
    private string $email;

    /** @var string */
    private string $password;


    /**
     * UserStoreDto constructor.
     * @param string $email
     * @param string $password
     */
    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}