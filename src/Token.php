<?php namespace Tattoo;

/**
 * Tattoo token
 **
 * @package             Tattoo
 * @copyright           2015 Mario Döring
 */

class Token
{
    /**
     * The type of this token
     *
     * @var string
     */
    public $type = null;

    /**
     * The value of this token
     *
     * @var int
     */
    public $value = null;

    /**
     * The line this token is in the code
     *
     * @var int
     */
    public $line = 0;

    /**
     * The constructor
     *
     * @var array         $token
     * @return void
     */
    public function __construct(array $token)
    {
        if (count($token) !== 3) 
        {
            throw new Exception('Invalid number of arguments for token constructor array.');
        }

        list($this->type, $this->value, $this->line) = $token;
    }

    /**
     * Gets the tokens value in the correct data type
     *
     * @return mixed
     */
    public function getValue()
    {
        $value = $this->value;

        switch ($this->type) 
        {
            case 'boolTrue':
                $value = true;
                break;

            case 'boolFalse':
                $value = false;
                break;

            case 'string':
                $value = str_replace("\\", "", substr($value, 1, -1));
                break;

            case 'number':
                $value = $value + 0;
                break;

            case 'null':
                $value = null;
                break;
        }

        return $value;
    }

    /**
     * Is this a value token?
     *
     * @return bool
     */
    public function isValue()
    {
        return
        $this->type === 'string' ||
        $this->type === 'number' ||
        $this->type === 'null' ||
        $this->type === 'boolTrue' ||
        $this->type === 'boolFalse';
    }

    /**
     * Is this an Operator
     *
     * @return bool
     */
    public function isOperator()
    {
        return
        $this->type === 'plus' ||
        $this->type === 'minus' ||
        $this->type === 'slash' ||
        $this->type === 'star';
    }
}
