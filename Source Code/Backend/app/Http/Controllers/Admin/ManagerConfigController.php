<?php

namespace App\Http\Controllers\Admin;

use App\Models\ConfigData;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ConfigDataRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;

class ManagerConfigController extends Controller
{

    public function __construct()
    {
    }

    /**
     * index
     * @param $group
     * @return Renderable
     */
    public function index($group)
    {

        if (!in_array($group, app(ConfigData::class)->groups))
            abort(404);
        $title = ucwords(str_replace('_', ' ', $group));
        $config_data = ConfigData::findByGroup($group);
        return view('pages.config_data.manager.index', [
            'config_data' => $config_data->get(),
            'title' => $title,
            'breadcrumb' => $this->breadcrumb([], $title),
            'group' => $group
        ]);
    }

    public function authorizeInstagram()
    {
        $insta_username = ConfigData::where('group', 'social_media')->where('title', 'instagram')->first()->value;

        if (!$insta_username) {
            return $this->returnCrudData('Please add your instagram username', null, 'error');
        }

        $exist = \Dymantic\InstagramFeed\Profile::for($insta_username);

        if ($exist) {
            $profile = $exist;
        } else {
            $profile = \Dymantic\InstagramFeed\Profile::new($insta_username);
        }

        // dd($profile->getInstagramAuthUrl());

        return redirect()->away($profile->getInstagramAuthUrl());
    }


    /**
     * update
     *
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function update(Request $request)
    {
        try {
            foreach ($request->config as $item) {
                if ($configData = ConfigData::find($item['id'])) {
                    if (array_key_exists('value', $item)) {
                        $configData->update([
                            'value' => $item['value']
                        ]);
                    } elseif (isset($item['cover'])) {
                        $configData->addHashedMedia($item['cover'])
                            ->toMediaCollection('cover');
                    }
                }
            }
            return $this->returnCrudData('Updated Successfully');
        } catch (Exception $exception) {
            return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
    }

    // Other Methods

    private function commonData()
    {
        return [
        ];
    }
}
