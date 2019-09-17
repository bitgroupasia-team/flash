<?php

if (! function_exists('flash')) {
    /**
     * @param string $message
     * @param string $level
     *
     * @return Toastr
     */
    function flash(string $message = null, string $level = 'info')
    {
        if (is_null($message)) {
            return app('flash');
        }

        return app('flash')->message($message, $level);
    }
}
