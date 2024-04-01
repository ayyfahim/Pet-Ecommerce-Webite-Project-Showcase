<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EmailTemplateRequest;
use App\Models\EmailTemplate;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmailTemplateUpdate;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * @group Manger-System-EmailTemplates
 */
class ManagerEmailTemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * index.
     * @return Response
     */
    public function index()
    {
        return view('pages.email_templates.manager.index', [
            'breadcrumb' => $this->breadcrumb([], 'Email Templates'),
            'email_templates' => Notification::whereHas('email_notification')->paginate(9),
        ]);
    }

    /**
     * edit.
     *
     * @param Notification $email_template
     * @return Response
     */
    public function edit(Notification $notification)
    {
        return view('pages.email_templates.manager.edit', [
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Email Templates',
                    'route' => route('content.admin.email_template.index')
                ]
            ], 'Edit ' . $notification->title),
            'email_template' => $notification,
        ]);
    }
    /**
     * edit.
     *
     * @param Notification $email_template
     * @return Response
     */
    public function show(Notification $notification)
    {

        return view('emails.en.email', [
            'userName' => auth()->user()->full_name,
            'body' => $notification->email_notification->replaceData([])['body'],
        ]);
    }

    /**
     * update.
     *
     * @param EmailTemplateRequest $request
     * @param Notification $notification
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function update(EmailTemplateRequest $request, Notification $notification)
    {
        $notification->email_notification->update($request->except('redirect_to'));
        return $this->returnCrudData('Updated Successfully', route('content.admin.email_template.index'));
    }
}
