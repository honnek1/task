<?php



/**
 * Энтити Задача
 */
class Task
{

    /** @var int $id */
    protected int $id;

    /** @var string $user */
    protected string $user;

    /** @var string $email */
    protected string $email;

    /** @var string $text */
    protected string $text;

    /** @var string $status */
    protected string $status;


/** --------------------------------Getters-------------------------------------------------------------------------- */

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
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
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

/** --------------------------------Setters-------------------------------------------------------------------------- */

    /**
     * @param string $user
     */
    public function setUser(string $user): void
    {
        $this->user = $user;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
