<?php
namespace CSD\Marketo;

use Guzzle\Service\Command\OperationCommand;
use Guzzle\Service\Command\ResponseClassInterface;

/**
 * Base response class for Marketo API calls.
 *
 * @author Daniel Chesterton <daniel@chestertondevelopment.com>
 */
class Response implements ResponseClassInterface
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return array|null
     */
    public function getResult()
    {
        return isset($this->data['result'])? $this->data['result']: null;
    }

    /**
     * @return string
     */
    public function getRequestId()
    {
        return $this->data['requestId'];
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return true === $this->data['success'];
    }

    /**
     * @return array|null
     */
    public function getError()
    {
        if (isset($this->data['errors']) && count($this->data['errors'])) {
            return $this->data['errors'][0];
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public static function fromCommand(OperationCommand $command)
    {
        return new static($command->getResponse()->json());
    }
}