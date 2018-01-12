<?php
/**
 * Created by PhpStorm.
 * User: webid
 * Date: 18-1-12
 * Time: 下午2:46
 */

namespace mmxs\Bundle\CommandLogBundle\Model;


use GuzzleHttp\Client;

class ApiHandler implements HandlerInterface
{
    const PATH_START = 'command/{token}/start';
    const PATH_ERROR = 'command/{token}/error';
    const PATH_TERMINATE = 'command/{token}/terminate';
    private $options = [
        'client_options' => [
            'base_uri' => '',
        ],
    ];
    /**
     * @var Client
     */
    private $client;

    public function __construct(array $options)
    {
        $this->options = array_replace($this->options, $options);

        $this->client = new Client($this->options['client_options']);
    }

    public function handleStart(string $token, array $data)
    {
        try {
            $this->client->post(
                str_replace('{token}', $token, self::PATH_START),
                ['json' => $data]
            );
        } catch (\Exception $e) {

        }

    }

    public function handleError(string $token, array $data)
    {
        try {
            $this->client->post(
                str_replace('{token}', $token, self::PATH_ERROR),
                ['json' => $data]
            );
        } catch (\Exception $e) {

        }
    }

    public function handleTerminate(string $token, array $data)
    {
        try {
            $this->client->post(
                str_replace('{token}', $token, self::PATH_TERMINATE),
                ['json' => $data]
            );
        } catch (\Exception $e) {

        }
    }

}