<?php
/**
 * Created by PhpStorm.
 * User: Road9-2
 * Date: 10/27/2019
 * Time: 12:54 PM
 */

namespace App\Notifications;


use App\Models\EmailLog;
use App\Models\Notification as NotificationTemplate;
use App\Models\web_push_notifications;
use Illuminate\Support\Facades\Notification;

class SendNotification
{
    private $notification;

    public function __construct($event, $users_temp, $params = [])
    {
        $this->notification = NotificationTemplate::where('event', $event)->first();
        if ($this->notification) {
            if (!is_a($users_temp, 'Illuminate\Database\Eloquent\Collection')) {
                $users[] = $users_temp;
            } else {
                $users = $users_temp;
            }
            if ($this->notification->email_notification && $this->notification->email_notification->is_active) {
                $this->sendEmailNotification($users, $params);
            }
        }


    }

    private function sendEmailNotification($users, $params)
    {
        foreach ($users as $user) {
            $data = $this->notification->email_notification->replaceData($params);
            $email_log['to'] = $user->email;
            $email_log['subject'] = $data['subject'];
            $email_log['status'] = 'failed';
            if (EmailLog::where('created_at', '>=', now()->subDays(30)->toDateTimeString())->count() < 1000) {
                try {
                    if ($this->validateEmail($user->email)) {
                        Notification::send($user, new EmailNotification($data));
                        $email_log['status'] = 'success';
                    } else {
                        $email_log['exception'] = 'Email not valid';
                    }

                } catch (\Exception $exception) {
                    $email_log['exception'] = $exception->getMessage();
                }
                EmailLog::create($email_log);
            }
        }
    }

    private function validateEmail($email)
    {
        $common = ['yahoo.com', 'gmail.com', 'msn.com', 'outlook.com', 'icloud.com'];
        $domain = explode('@', $email);
        $domain = isset($domain[1]) ? $domain[1] : null;
        if (!$domain) {
            return false;
        }
        if (in_array(strtolower($domain), $common)) {
            return true;
        }
        return checkdnsrr($domain, 'MX');
    }
}
