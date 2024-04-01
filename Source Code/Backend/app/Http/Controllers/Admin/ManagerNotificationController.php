<?php

namespace App\Http\Controllers\Admin;

use App\Models\EmailNotificationTemplate;
use App\Models\Notification;
use App\Models\PushNotificationTemplate;
use App\Models\SmsNotificationTemplate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * @group ManagerMailTemplate
 */
class ManagerNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Notification::query()->get();
        return view('pages.notifications.index', [
            'events' => $events,
            'breadcrumb' => $this->breadcrumb([], 'Notifications'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    public function show( $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     */
    public function edit($id)
    {
        $event = Notification::find($id);
        $emailTemplate = EmailNotificationTemplate::query()->where('notification_id',$id)->first();
        $PN = PushNotificationTemplate::query()->where('notification_id',$id)->first();
        $sms = SmsNotificationTemplate::query()->where('notification_id',$id)->first();
        return view('pages.notifications.edit', [
            'email' => $emailTemplate,
            'PN' => $PN,
            'sms' => $sms,
            'event'=> $event,
            'breadcrumb' => $this->breadcrumb([], 'Notifications'),
            'locales' => LaravelLocalization::getSupportedLanguagesKeys(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     */
    public function update($id, Request $request)
    {
        $emailTemplate = EmailNotificationTemplate::query()->where('notification_id',$id)->first();
       // $PN = PushNotificationTemplate::query()->where('notification_id',$id)->first();
//            $sms = SmsNotificationTemplate::query()->where('notification_id',$id)->first();
        if($request->email_subject){
            $emailTemplate->update([
                'body'=>$request->email_body,
                'subject'=>$request->email_subject,
                'is_active' => $request->email_active
            ]);
        }
//        if($request->pn_subject){
//            $PN->update([
//                'subject'=>$request->pn_subject,
//                'body'   =>$request->pn_body,
//                'link'   =>$request->pn_link,
//                'icon'   =>$request->pn_icon,
//                'is_active' => $request->pn_active
//            ]);
//        }
        return $this->returnCrudData('Notification updated',route('mailtemplate.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy( $id)
    {
    }
}
