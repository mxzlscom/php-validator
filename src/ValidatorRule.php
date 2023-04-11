<?php declare(strict_types=1);


namespace Mengx\Validator;


class ValidatorRule
{
    private string $rule;

    private string $message;

    private  $args;

    /**
     * @param string $rule
     * @param $args
     * @param string $message
     */
    public function __construct(string $rule,$args,string $message )
    {
        $this->rule = $rule;
        $this->args = $args;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getRule(): string
    {
        return $this->rule;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getArgs()
    {
        return $this->args;
    }



}