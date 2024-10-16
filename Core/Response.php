<?php

namespace Core;

/* ~~~ Response Class 🚀 ~~~  */

class Response
{
    protected int $statusCode = 200;
    protected array $headers = [];
    protected $body;

    /**
     * Sets the HTTP status code for the response.
     *
     * @param int $code The HTTP status code to set.
     * @return self Returns the current instance for method chaining.
     */
    public function setStatusCode(int $code): self
    {
        if ($code < 100 || $code > 599) {
            throw new \InvalidArgumentException("Invalid HTTP status code.");
        }
        $this->statusCode = $code;
        return $this;
    }

    /**
     * Adds a header to the response.
     *
     * @param string $header The name of the header.
     * @param string $value The value of the header.
     * @return self Returns the current instance for method chaining.
     */
    public function addHeader(string $header, string $value): self
    {
        if (isset($this->headers[$header])) {
            throw new \InvalidArgumentException("Header already exists: $header");
        }
        $this->headers[$header] = $header . ': ' . $value;
        return $this;
    }

    /**
     * Sets the response body as JSON encoded data.
     *
     * @param array $data The data to be encoded as JSON.
     * @return self Returns the current instance for method chaining.
     */
    public function json(array $data): self
    {
        $this->addHeader('Content-Type', 'application/json');
        $json = json_encode($data);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('JSON encoding error: ' . json_last_error_msg());
        }
        
        $this->body = $json;
        return $this;
    }

    /**
     * Sends the response to the client.
     *
     * Sets the HTTP status code, adds headers, and outputs the body content.
     */
    public function send(): void
    {
        http_response_code($this->statusCode);

        foreach ($this->headers as $header) {
            header($header);
        }

        if ($this->body !== null) {
            echo $this->body;
        }
    }
}
