<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Product;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Presenters\BookmarkPresenter;
use App\Presenters\ServicePresenter;
use App\Transformers\ProductListTransformer;
use App\Transformers\ServiceRequestTransformer;
use App\User;
use App\Models\Rfp;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

/**
 * @group Bookmark
 */
class BookmarkController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * index.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $bookmarks = auth()->user()->bookmarks();
        $bookmarks = app(BookmarkPresenter::class)->paginate($bookmarks->get());
        if ($request->expectsJson()) {
            return $this->returnPaginatedApiData(
                $bookmarks, new ProductListTransformer(), ['sorting' => Bookmark::getSortingOptions(true)]
            );
        }
    }

    /**
     * store.
     * @bodyParam product_id required
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        if (!$this->checkExists($product->id)) {
            $bookmark = $product->bookmarks()->create(['user_id' => auth()->user()->id]);
            $data['id'] = $bookmark->id;
            if (!request()->is('api*')) {
                $data['action'] = route('bookmark.destroy', $bookmark->id);
            }
            return $this->returnCrudData(__('bookmark.added_to_bookmark'), null, 'success', $data);
        }
        return $this->returnCrudData(__('bookmark.already_in_bookmark'));
    }

    /**
     * delete.
     *
     * @param Bookmark $bookmark
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(Bookmark $bookmark)
    {
        $bookmark->delete();
        return $this->returnCrudData(__('bookmark.removed_from_bookmark'));
    }

    private function checkExists(string $product_id)
    {
        return auth()->user()->bookmarks()->where('product_id', $product_id)->count();
    }
}
