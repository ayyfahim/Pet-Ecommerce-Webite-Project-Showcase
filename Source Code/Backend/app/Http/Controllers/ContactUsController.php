<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Brand;
use App\Models\Concern;
use App\Models\EmailLog;
use Illuminate\Http\Response;
use App\Transformers\PageTransformer;
use App\Transformers\BrandTransformer;
use App\Http\Requests\ContactUsRequest;
use App\Notifications\ContactUsEmailNotification;
use Illuminate\Support\Facades\Request;
use App\Transformers\ConcernTransformer;
use Illuminate\Support\Facades\Notification;

/**
 * @group System-Pages
 */
class ContactUsController extends Controller
{
    public function store(ContactUsRequest $request)
    {
        try {
            $data['body'] = "
            $request->full_name wants to contact you!<br>
            Here is the message:<br>
            <p>$request->message</p><br>
            <p>
            Email: $request->email<br>
            Phone: $request->mobile
            </p>
            ";
            $data['from'] = $request->email;
            $data['to'] = config('app.email');
            $data['subject'] = "$request->full_name wants to contact you!";
            $data['full_name'] = $request->full_name;

            $email_log['to'] = config('app.email');
            $email_log['subject'] = $data['subject'];
            $email_log['status'] = 'failed';
            if (EmailLog::where('created_at', '>=', now()->subDays(30)->toDateTimeString())->count() < 1000) {
                try {
                    if ($this->validateEmail($request->email)) {
                        Notification::route('mail', $data['to'])
                            ->notify(new ContactUsEmailNotification($data));
                        $email_log['status'] = 'success';
                    } else {
                        $email_log['exception'] = 'Email not valid';
                    }
                } catch (\Exception $exception) {
                    $email_log['exception'] = $exception->getMessage();
                }
                EmailLog::create($email_log);
            }
            return $this->returnCrudData(__('system_messages.common.create_success'), route('contact_us.store'));
        } catch (\Throwable $exception) {
            return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
        
        // try {
        //     Feed::create($request->toArray());
        //     return $this->returnCrudData(__('system_messages.common.create_success'), route('feed.index'));
        // } catch (Exception $exception) {
        //     return $this->returnCrudData($exception->getMessage(), null, 'error');
        // }
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
