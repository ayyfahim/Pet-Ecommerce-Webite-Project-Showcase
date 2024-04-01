<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function email_notification()
    {
        return $this->hasOne(EmailNotificationTemplate::class);
    }

    public function push_notification()
    {
        return $this->hasOne(PushNotificationTemplate::class);
    }

    public function sms_notification()
    {
        return $this->hasOne(SmsNotificationTemplate::class);
    }
    public function web_push_notification()
    {
        return $this->hasOne(WebPushNotificationTemplate::class);
    }
}
