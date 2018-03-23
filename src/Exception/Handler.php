<?php

namespace Encore\Admin\Exception;

use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

class Handler
{
    /**
     * Render exception.
     *
     * @param \Exception $exception
     *
     * @return string
     */
    public static function renderException(\Exception $exception)
    {
        $trace = explode("\n", $exception->getTraceAsString());

        $error = new MessageBag([
            'type'      => get_class($exception),
            //'message'   => $exception->getMessage(),
            //stack maybe more useful
            'message'   => implode("\n", array_slice($trace, 0, 10)),
            'file'      => $exception->getFile(),
            'line'      => $exception->getLine(),
        ]);

        $errors = new ViewErrorBag();
        $errors->put('exception', $error);

        return view('admin::partials.exception', compact('errors'))->render();
    }

    /**
     * Flash a error message to content.
     *
     * @param string $title
     * @param string $message
     *
     * @return mixed
     */
    public static function error($title = '', $message = '')
    {
        $error = new MessageBag(compact('title', 'message'));

        return session()->flash('error', $error);
    }
}
