<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressStore;
use App\Models\Address;
use App\Models\AddressInfo;
use App\Transformers\AddressTransformer;
use App\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Throwable;

/**
 * @group Address
 */
class AddressController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * store
     *
     * @param AddressStore $request
     * @bodyParam name string required
     * @bodyParam title string required
     * @bodyParam business_name string optional
     * @bodyParam email string required
     * @bodyParam phone string required
     * @bodyParam street_address string required
     * @bodyParam area string required [Suburb]
     * @bodyParam city string required
     * @bodyParam country string required [Hidden Input]
     * @bodyParam postal_code string required
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws Throwable
     */
    public function store(AddressStore $request)
    {
        try {
            $address = DB::transaction(function () use ($request) {
                $authUser = auth()->user();
                $address = $authUser->addresses()->create([
                    'default' => $authUser->addresses()->count() == 0
                ]);
                $address->infos()->create($request->except('default'));
                return fractal($address, new AddressTransformer())->toArray()['data'];
            });
            return $this->returnCrudData(__('system_messages.common.create_success'), null, 'success', $address);
        } catch (Exception $exception) {
            return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
    }


    /**
     * update
     *
     * @param AddressStore $request
     * @param Address $address
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws Throwable
     * @bodyParam name string required
     * @bodyParam title string required
     * @bodyParam business_name string optional
     * @bodyParam email string required
     * @bodyParam phone string required
     * @bodyParam street_address string required
     * @bodyParam area string required [Suburb]
     * @bodyParam city string required
     * @bodyParam country string required [Hidden Input]
     * @bodyParam postal_code string required
     */
    public function update(AddressStore $request, Address $address)
    {
        try {
            DB::transaction(function () use ($request, $address) {
                $authUser = auth()->user();
                $user = ($request->user_id && $authUser->hasManagerAccess()) ? User::find($request->user_id) : $authUser;
                if (!empty($request->except('default', 'user_id'))) {
                    $address->infos()->create($request->except('default', 'user_id'));
                }
                if ($request->has('default')) {
                    $default = is_string($request->default)
                        ? $request->default === 'true'
                        : $request->default;
                    if ($default) {
                        $address->update(['default' => true]);
                        $user->addresses()->where('id', '!=', $address->id)->where('default', true)->update(['default' => false]);
                    }
                }
            });
            return $this->returnCrudData(__('system_messages.common.update_success'), $request->redirect_to);
        } catch (Exception $exception) {
            return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
    }
    public function updateInfo(AddressStore $request, AddressInfo $addressInfo)
    {
        try {
            $addressInfo->update($request->input());
            return $this->returnCrudData(__('system_messages.common.update_success'));
        } catch (Exception $exception) {
            return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
    }

    public function index(Request $request)
    {
        $addresses = auth()->user()->addresses->sortByDesc('created_at');
        $addresses = $addresses->filter(fn ($item) => $item->default === true)
        ->concat($addresses->reject(fn ($item) => $item->default === true));
        return $this->returnCrudData(
            '',
            null,
            'success',
            fractal($addresses, new AddressTransformer())->toArray()['data']
        );
    }

    public function destroy(Address $address)
    {
        if (!$address) return $this->returnCrudData('', null, 'error');
        $address->delete();
        $user =  auth()->user();
        if ($address->default == true) {
            $user->first_latest_address()->update(['default' => true]);
        } elseif (!$user->addresses()->where('id', '!=', $address->id)->where('default', true)->first()) {
            $user->first_latest_address()->update(['default' => true]);
        }
        return $this->returnCrudData(__('system_messages.common.success'));
    }

    /**
     * SHOW
     *
     * @param Address $address.
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws Exception
     */
    public function show(Address $address)
    {
        try {
            $authUser = auth()->user();
            if ($authUser->addresses()->where('id', $address->id)->exists()) {
                return $this->returnCrudData('View address', null, 'success', [
                    'address' => fractal($address, new AddressTransformer())->toArray()['data']
                ]);
            } else {
                return $this->returnCrudData('Address not found', null, 'error', ['address' => []]);
            }
        } catch (Exception $exception) {
            return $this->returnCrudData($exception->getMessage(), null, 'error', ['address' => []]);
        }
    }
}
