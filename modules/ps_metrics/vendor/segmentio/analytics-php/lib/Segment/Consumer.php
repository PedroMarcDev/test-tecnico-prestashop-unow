<?php

namespace ps_metrics_module_v4_1_2;

abstract class Segment_Consumer
{
    protected $type = "Consumer";
    protected $options;
    protected $secret;
    /**
     * Store our secret and options as part of this consumer
     * @param string $secret
     * @param array  $options
     */
    public function __construct($secret, $options = array())
    {
        $this->secret = $secret;
        $this->options = $options;
    }
    /**
     * Tracks a user action
     * 
     * @param  array  $message
     * @return boolean whether the track call succeeded
     */
    public abstract function track(array $message);
    /**
     * Tags traits about the user.
     * 
     * @param  array  $message
     * @return boolean whether the identify call succeeded
     */
    public abstract function identify(array $message);
    /**
     * Tags traits about the group.
     * 
     * @param  array  $message
     * @return boolean whether the group call succeeded
     */
    public abstract function group(array $message);
    /**
     * Tracks a page view.
     * 
     * @param  array  $message
     * @return boolean whether the page call succeeded
     */
    public abstract function page(array $message);
    /**
     * Tracks a screen view.
     * 
     * @param  array  $message
     * @return boolean whether the group call succeeded
     */
    public abstract function screen(array $message);
    /**
     * Aliases from one user id to another
     * 
     * @param  array $message
     * @return boolean whether the alias call succeeded
     */
    public abstract function alias(array $message);
    /**
     * Check whether debug mode is enabled
     * @return boolean
     */
    protected function debug()
    {
        return isset($this->options["debug"]) ? $this->options["debug"] : \false;
    }
    /**
     * Check whether we should connect to the API using SSL. This is enabled by
     * default with connections which make batching requests. For connections
     * which can save on round-trip times, we disable it.
     * @return boolean
     */
    protected function ssl()
    {
        return isset($this->options["ssl"]) ? $this->options["ssl"] : \false;
    }
    /**
     * On an error, try and call the error handler, if debugging output to
     * error_log as well.
     * @param  string $code
     * @param  string $msg
     */
    protected function handleError($code, $msg)
    {
        if (isset($this->options['error_handler'])) {
            $handler = $this->options['error_handler'];
            $handler($code, $msg);
        }
        if ($this->debug()) {
            \error_log("[Analytics][" . $this->type . "] " . $msg);
        }
    }
}
