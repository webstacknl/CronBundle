<?php

namespace Padam87\CronBundle\Util;

use Padam87\CronBundle\Annotation\Job;

class Tab implements \ArrayAccess
{
    /**
     * @var Job[]
     */
    protected $jobs = [];

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->jobs[$offset]);
    }

    /**
     * {@inheritdoc}
     *
     * @return Job
     */
    public function offsetGet($offset)
    {
        return $this->jobs[$offset];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        if (!$value instanceof Job) {
            throw new \UnexpectedValueException(
                sprintf(
                    'The crontab should only contain instances of "%s", "%s" given',
                    'Padam87\CronBundle\Annotation\Job',
                    get_class($value)
                )
            );
        }

        if (is_null($offset)) {
            $this->jobs[] = $value;
        } else {
            $this->jobs[$offset] = $value;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->jobs[$offset]);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return implode(PHP_EOL, $this->jobs) . PHP_EOL;
    }

    /**
     * @return Job[]
     */
    public function getJobs()
    {
        return $this->jobs;
    }
}
