<?php

namespace App\Tools;

use Illuminate\Http\Request;

/**
 * @deprecated
 */
class IP
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * IP constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get the client ip.
     *
     * @return mixed|string
     */
    public function get()
    {
        $ip = $this->request->getClientIp();

        if($ip == '::1') {
            $ip = '127.0.0.1';
        }

        return $ip;
    }
}
