<?php
/**
 * Created by PhpStorm.
 * User: webid
 * Date: 18-1-12
 * Time: 下午2:27
 */

namespace mmxs\Bundle\CommandLogBundle\Model;

interface HandlerInterface
{
    public function handleStart(string $token, array $data);

    public function handleError(string $token, array $data);

    public function handleTerminate(string $token, array $data);

    public function handleProgress(string $token, array $data);
}