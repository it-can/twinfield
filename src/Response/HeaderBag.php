<?php

namespace PhpTwinfield\Response;

class HeaderBag
{
    private $headers = [];

    /**
     * @param string $rawHeaders
     * @return self
     */
    public static function fromString(string $rawHeaders): HeaderBag
    {
        $headers = [];
        foreach (explode("\r\n", trim($rawHeaders)) as $line) {
            if (strpos($line, ':') !== false) {
                [$name, $value] = explode(':', $line, 2);
                $headers[strtolower(trim($name))] = trim($value);
            }
        }
        return new self($headers);
    }

    /**
     * @param array $headers
     */
    public function __construct(array $headers)
    {
        $this->headers = $headers;
    }

    /**
     * Retrieves a header value by its name, case-insensitive.
     * @param string $name
     * @param string|null $default
     * @return string|null
     */
    public function get(string $name, ?string $default = null): ?string
    {
        return $this->headers[strtolower($name)] ?? $default;
    }
}
