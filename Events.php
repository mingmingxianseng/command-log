<?php
/**
 * Created by PhpStorm.
 * User: webid
 * Date: 18-1-16
 * Time: 下午2:22
 */

namespace mmxs\Bundle\CommandLogBundle;

final class Events
{
    /**
     * @Event("mmxs\Bundle\CommandLogBundle\CommandProgressEvent")
     * @var string
     */
    const PROGRESS = 'command.progress';
}