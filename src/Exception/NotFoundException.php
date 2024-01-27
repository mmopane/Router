<?php

namespace MMOPANE\Router\Exception;

class NotFoundException extends HttpException
{
    protected $code = 404;
    protected $message = 'Not Found';
}