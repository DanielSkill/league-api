<?php

namespace App\Support\LeagueAPI;

use ArrayAccess;
use GuzzleHttp\Psr7\Response;

class APIResponse implements ArrayAccess
{
    /**
     * @var mixed
     */
    public $data;

    /**
     * @var mixed
     */
    public $headers;

    /**
     * @var int
     */
    public $status;

    /**
     * @var bool
     */
    public $isSuccessStatus;

    /**
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->data = json_decode($response->getBody(), true);
        $this->headers = $response->getHeaders();
        $this->status = $response->getStatusCode();
        $this->isSuccessStatus = $this->status <= 299 && $this->status >= 200;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }

    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }
}
