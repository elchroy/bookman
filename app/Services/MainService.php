<?php

namespace App\Services;

class MainService
{
    /**
     * Token provided is invalie, does not match email.
     */
    const INVALID_TOKEN = 'Invalid Token. Please enter your subscription token.';

    /**
     * The called service is not provided.
     */
    const METHOD_NOT_EXISTS = 'This action is not available in the service. Please view the documentation.';

    /**
     * Generate hash using env key.
     *
     * @param [type] $data to be hashed
     *
     * @return [string] The generated hash
     */
    public function generateHash($data) : string
    {
        return hash('sha256', $data.env('SECRET_KEY'));
    }

    /**
     * Response for Invalid token.
     *
     * @param string $token Invalid token
     *
     * @return [array
     */
    public function getInvalidTokenResponse(string $token) : array
    {
        return [
            'token'   => $token,
            'message' => self::INVALID_TOKEN,
        ];
    }

    /**
     * Response with simple message.
     *
     * @param string $message Information to be sent to user
     *
     * @return [type] [description]
     */
    public function getMessageResponse(string $message) : array
    {
        return [
            'message' => $message,
        ];
    }

    /**
     * Prepare response for user.
     *
     * @param array $body   response body
     * @param int   $status response status code
     *
     * @return array
     */
    public function respond(array $body, int $status) : array
    {
        return [
            'status' => $status,
            'body'   => $body,
        ];
    }

    /**
     * Handle cases when a method/action is not provided on the service.
     *
     * @param string $methodName The unavailable method
     * @param array  $arguments  The arguments provided to the method
     *
     * @return [type] Response to the user saying method/action is not provided.
     */
    public function __call(string $methodName, array $arguments)
    {
        return $this->respond($this->getMessageResponse($methodName.' : '.self::METHOD_NOT_EXISTS), 400);
    }
}
