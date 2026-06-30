<?php

namespace PhpTwinfield\ApiConnectors;

final class ApiOptions
{
    private const RATE_LIMITED_MESSAGE = 'Too Many Requests';

    private $retriableExceptionMessages = [
        "SSL: Connection reset by peer",
        "Your logon credentials are not valid anymore. Try to log on again.",
    ];

    private $maxRetries = 3;

    private $useRetryAfterHeader;

    /**
     * @throws \InvalidArgumentException
     */
    public function __construct(?array $messages = null, ?int $maxRetries = null, bool $useRetryAfterHeader = false)
    {
        if ($messages !== null) {
            $this->validateMessages($messages);
            $this->retriableExceptionMessages = $messages;
        }
        if ($maxRetries !== null) {
            $this->validateMaxRetries($maxRetries);
            $this->maxRetries = $maxRetries;
        }

        $this->useRetryAfterHeader = $useRetryAfterHeader;
    }

    /**
     * @throws \InvalidArgumentException
     */
    private function validateMaxRetries(int $maxRetries): void
    {
        if ($maxRetries < 0) {
            throw new \InvalidArgumentException('The max retries should be a positive integer.');
        }
    }

    /**
     * @throws \InvalidArgumentException
     */
    private function validateMessages(array $messages): void
    {
        foreach ($messages as $key => $message) {
            if (trim($message) === '') {
                throw new \InvalidArgumentException(
                    sprintf('The exception message should not be empty. Key: [%s]', $key)
                );
            }
        }
    }

    /**
     * @return array
     */
    public function getRetriableExceptionMessages(): array
    {
        $messages = $this->retriableExceptionMessages;
        if ($this->useRetryAfterHeader) {
            $messages[] = self::RATE_LIMITED_MESSAGE;
        }

        return $messages;
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function setRetriableExceptionMessages(array $retriableExceptionMessages): ApiOptions
    {
        return new self(
            $retriableExceptionMessages,
            $this->maxRetries,
            $this->useRetryAfterHeader
        );
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function addMessages(array $messages): ApiOptions
    {
        return new self(
            array_merge($messages, $this->retriableExceptionMessages),
            $this->maxRetries,
            $this->useRetryAfterHeader
        );
    }

    /**
     * @return int
     */
    public function getMaxRetries(): int
    {
        return $this->maxRetries;
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function setMaxRetries(int $maxRetries): ApiOptions
    {
        return new self(
            $this->retriableExceptionMessages,
            $maxRetries,
            $this->useRetryAfterHeader
        );
    }

    public function getUseRetryAfterHeader(): bool
    {
        return $this->useRetryAfterHeader;
    }

    public function setUseRetryAfterHeader(bool $useRetryAfterHeader): ApiOptions
    {
        return new self(
            $this->retriableExceptionMessages,
            $this->maxRetries,
            $useRetryAfterHeader
        );
    }
}