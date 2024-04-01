<?php

namespace App\Http\Middleware\External;

use Illuminate\Foundation\Http\Middleware\TransformsRequest;

class CleanEvilInput extends TransformsRequest
{
    /**
     * The attributes that should not be edited.
     *
     * @var array
     */
    protected $except = [];

    /**
     * Transform the given value.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return mixed
     */
    protected function transform($key, $value)
    {
        if (in_array($key, $this->except, true)) {
            return $value;
        }

        return $this->clean($value);
    }

    /**
     * [clean description].
     *
     * @param [type]    $value [description]
     * @param bool|bool $trim  [description]
     * @param bool|bool $clean [description]
     *
     * @return [type] [description]
     */
    public function clean($value, bool $trim = true, bool $clean = true)
    {
        if (is_bool($value) || is_int($value) || is_float($value)) {
            return $value;
        }

        $final = null;

        if ($value !== null) {
            if (is_array($value)) {
                $all   = $value;
                $final = [];
                foreach ($all as $key => $value) {
                    if ($value !== null) {
                        $final[$key] = $this->clean($value);
                    }
                }
            } else {
                if ($value !== null) {
                    $final = $this->process((string) $value);
                }
            }
        }

        return $final;
    }

    /**
     * [process description].
     *
     * @param string    $value [description]
     * @param bool|bool $trim  [description]
     * @param bool|bool $clean [description]
     *
     * @return [type] [description]
     */
    protected function process(string $value, bool $trim = true, bool $clean = true)
    {
        if ($trim) {
            $value = trim($value);
        }

        if ($clean) {
            $value = app('security')->clean($value);
        }

        return $value;
    }
}
