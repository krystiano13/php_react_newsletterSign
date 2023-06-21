<?php

require_once 'database.php';

abstract class Api
{
    public $userInput;
    public $free;
    private $validation;
    private $result;

    public function __construct($userInput)
    {
        $this->free = true;
        $this->userInput = $userInput;
        $this->validation = true;
        $this->result = false;
    }

    abstract public function validate(): bool;
    abstract public function send(): bool;
}

class Mail extends Api
{
    public $userInput;
    public $free;
    private $validation;
    private $result;

    public function __construct($userInput)
    {
        $this->free = true;
        $this->userInput = $userInput;
        $this->validation = true;
        $this->result = false;
    }

    public function validate(): bool
    {
        $this->userInput = htmlentities($this->userInput);

        if (empty(filter_var($this->userInput, FILTER_VALIDATE_EMAIL))) {
            return false;
        } else {
            return true;
        }
    }

    public function send(): bool
    {
        $this->validation = $this->validate();
        $this->result = false;
        $this->free = true;
        if ($this->validation) {

            $database = new Database();

            if ($database->connect()) {

                $checkQuery = $database->connection->prepare("SELECT email FROM emails WHERE email = :email");
                $checkQuery->bindValue(':email', $this->userInput);
                if ($checkQuery->execute()) {
                    if ($checkQuery->rowCount() > 0) {
                        $this->free = false;
                    }
                }

                if ($this->free) {
                    $query = $database->connection->prepare("INSERT INTO emails VALUES (NULL,:email)");
                    $query->bindValue(':email', $this->userInput);

                    if ($query->execute()) {
                        $this->result = true;
                    }
                }
                else
                    $this->result = false;
            }
        }

        return $this->result;
    }
}