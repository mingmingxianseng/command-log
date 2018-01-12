<?php
/**
 * Created by PhpStorm.
 * User: webid
 * Date: 18-1-12
 * Time: 上午11:11
 */

namespace mmxs\Bundle\CommandLogBundle\Model;


interface CommandLogInterface
{
    public function setName();

    public function getName();
}