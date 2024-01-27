<?php

namespace MMOPANE\Router\Exception;

class MethodNotAllowedException extends HttpException
{
    protected $code = 405;
    protected $message = 'Method Not Allowed';
}