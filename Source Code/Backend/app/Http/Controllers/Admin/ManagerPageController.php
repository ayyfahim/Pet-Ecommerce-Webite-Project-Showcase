<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageUpdate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;
use Spatie\MediaLibrary\Models\Media;

/**
 * @group Manger-System-Pages
 */
class ManagerPageController extends Controller
{

    public function __construct()
    {
    }

    /**
     * index.
     * @return Response
     */
    public function index()
    {
        return view('pages.pages.manager.index', [
            'breadcrumb' => $this->breadcrumb([], 'Pages'),
            'pages' => Page::orderBy('order')->get(),
        ]);
    }

    /**
     * create.
     */
    public function create()
    {
        return view('pages.pages.manager.create', array_merge($this->commonData(), [
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Pages',
                    'route' => route('content.admin.page.index')
                ]
            ], 'Add New Page'),
        ]));
    }

    /**
     * store.
     *
     * @param PageUpdate $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function store(PageUpdate $request)
    {
        $this->commonCrud($request);
        return $this->returnCrudData('Created Successfully', route('content.admin.page.index'));
    }

    /**
     * edit.
     *
     * @param Page $page
     * @return Response
     */
    public function edit(Page $page)
    {
        return view('pages.pages.manager.edit', array_merge($this->commonData(), [
            'breadcrumb' => $this->breadcrumb(
                [['title' => 'Pages', 'route' => route('content.admin.page.index')]], 'Edit ' . $page->title),
            'page' => $page,
        ]));
    }

    public function show_dump(Page $page)
    {
        dd($page);
    }

    /**
     * update.
     *
     * @param PageUpdate $request
     * @param Page $page
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function update(PageUpdate $request, Page $page)
    {
        $this->commonCrud($request, $page);
        return $this->returnCrudData('Updated Successfully', route('content.admin.page.index'));
    }
    public function destroy(Page $page)
    {
        $page->delete();
        return $this->returnCrudData('Deleted Successfully', route('content.admin.page.index'));
    }
    private function commonCrud(PageUpdate $request, Page $page = null)
    {
        $data = $request->except('redirect_to', 'slug', 'media_to_delete', 'cover', 'gallery', 'faq');
        $data['slug'] = $request->slug ?: $request->title;
        if ($page) {
            $page->update($data);
        } else {
            $page = Page::create($data);
        }
        if ($cover = $request->cover) {
            try {
                $page->addHashedMedia($cover)->toMediaCollection('cover');
            } catch (DiskDoesNotExist $e) {
            } catch (FileDoesNotExist $e) {
            } catch (FileIsTooBig $e) {
            }
        }
        if ($gallery = $request->gallery) {
            foreach ($gallery as $one) {
                try {
                    $page->addHashedMedia($one)->toMediaCollection('gallery');
                } catch (DiskDoesNotExist $e) {
                } catch (FileDoesNotExist $e) {
                } catch (FileIsTooBig $e) {
                }
            }
        }
        if ($media_to_delete = $request->media_to_delete) {
            foreach ($media_to_delete as $media_id) {
                if ($media = Media::find($media_id)) {
                    $media->delete();
                }
            }
        }
    }

    private function commonData()
    {
        $config = Page::getStatusFor();
        return [
            'categories' => app(Page::class)->categories,
            'status' => $config['status']
        ];
    }
}
