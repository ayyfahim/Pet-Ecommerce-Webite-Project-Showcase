<?php

namespace App\Models\Traits;

use App\Models\Notification;

trait HasNotification
{

    public $boolean = ['is_active'];

    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }

    public function scopeOfRole($query, $role)
    {
        return $query->where('user_role', $role);
    }

    public function replaceData($data = [])
    {
        $res = [];
        $fields = [
            'subject',
            'body',
            'links'
        ];

        foreach ($fields as $one) {
            if ($one == 'links') {
                $str = $this->links;
            } else {
                $str = $this->$one;
            }
            if ($data) {
                foreach ($data as $key => $value) {
                    $str = preg_replace('/{{2}' . $key . '}{2}/', $value, $str);
                }
            }

            $res[$one] = $str;
        }
        return $res;
    }

}
