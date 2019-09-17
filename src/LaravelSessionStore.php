<?php

namespace Bitgroupasia\Flash;

use Illuminate\Session\Store;

class LaravelSessionStore implements SessionStore
{
    /**
     * @var store
     */
    private $session;

    /**
     * Create a new session store instance
     *
     * @param Illuminate\Session\Store $session
     */
    function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Flash a messsage to the session.
     *
     * @param string $name
     * @param array  $data
     */
    public function flash($name, $data)
    {
        $this->session->flash($name, $data);
    }
}
