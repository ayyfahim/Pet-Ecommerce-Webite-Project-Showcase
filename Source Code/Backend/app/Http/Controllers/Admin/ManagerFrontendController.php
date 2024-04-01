<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageUpdate;
use App\Models\FrontendAboutUs;
use App\Models\FrontendHomepage;
use App\Models\FrontendRewardProgram;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
class ManagerFrontendController extends Controller
{

    public function __construct()
    {
    }

    public function homepage()
    {
        $page = FrontendHomepage::first();
        return view('pages.frontend.manager.homepage', [
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Pages',
                    'route' => route('content.admin.page.index')
                ]
            ], 'Homepage'),
            'page' => $page

        ]);
    }

    public function reward_program()
    {
        $page = FrontendRewardProgram::first();
        return view('pages.frontend.manager.reward_program', [
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Pages',
                    'route' => route('content.admin.page.index')
                ]
            ], 'Reward Program'),
            'page' => $page

        ]);
    }

    public function about_us()
    {
        $page = FrontendAboutUs::first();
        return view('pages.frontend.manager.about_us', [
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Pages',
                    'route' => route('content.admin.page.index')
                ]
            ], 'About Us'),
            'page' => $page

        ]);
    }

    public function homepageStore(Request $request)
    {
        try {
            $data = $request->except('banner_section_image', 'ingredient_section_main_image', 'ingr_1_image', 'ingr_2_image', 'ingr_3_image', 'ingr_4_image', 'ingr_5_image', 'ingr_6_image', 'why_us_section_image', 'review_1_image', 'review_2_image', 'review_3_image', 'how_it_works_section_main_image', 'sub_banner_1_icon', 'sub_banner_2_icon', 'sub_banner_3_icon', 'sub_banner_4_icon', 'why_us_1_icon', 'why_us_2_icon', 'why_us_3_icon', 'why_us_4_icon', 'why_us_5_icon', 'why_us_6_icon');

            if ($page = FrontendHomepage::first()) {

                $page->update($data);

                if ($request->banner_section_image) {
                    $page->addHashedMedia($request->banner_section_image)
                        ->toMediaCollection('banner_section_image');
                }

                if ($request->banner_section_mobile_image) {
                    $page->addHashedMedia($request->banner_section_mobile_image)
                        ->toMediaCollection('banner_section_mobile_image');
                }

                if ($request->ingredient_section_main_image) {
                    $page->addHashedMedia($request->ingredient_section_main_image)
                        ->toMediaCollection('ingredient_section_main_image');
                }

                if ($request->ingr_1_image) {
                    $page->addHashedMedia($request->ingr_1_image)
                        ->toMediaCollection('ingr_1_image');
                }

                if ($request->ingr_2_image) {
                    $page->addHashedMedia($request->ingr_2_image)
                        ->toMediaCollection('ingr_2_image');
                }

                if ($request->ingr_3_image) {
                    $page->addHashedMedia($request->ingr_3_image)
                        ->toMediaCollection('ingr_3_image');
                }

                if ($request->ingr_4_image) {
                    $page->addHashedMedia($request->ingr_4_image)
                        ->toMediaCollection('ingr_4_image');
                }

                if ($request->ingr_5_image) {
                    $page->addHashedMedia($request->ingr_5_image)
                        ->toMediaCollection('ingr_5_image');
                }

                if ($request->ingr_6_image) {
                    $page->addHashedMedia($request->ingr_6_image)
                        ->toMediaCollection('ingr_6_image');
                }

                if ($request->why_us_section_image) {
                    $page->addHashedMedia($request->why_us_section_image)
                        ->toMediaCollection('why_us_section_image');
                }

                if ($request->review_1_image) {
                    $page->addHashedMedia($request->review_1_image)
                        ->toMediaCollection('review_1_image');
                }

                if ($request->review_2_image) {
                    $page->addHashedMedia($request->review_2_image)
                        ->toMediaCollection('review_2_image');
                }

                if ($request->review_3_image) {
                    $page->addHashedMedia($request->review_3_image)
                        ->toMediaCollection('review_3_image');
                }

                if ($request->how_it_works_section_main_image) {
                    $page->addHashedMedia($request->how_it_works_section_main_image)
                        ->toMediaCollection('how_it_works_section_main_image');
                }

                if ($request->how_it_works_section_bubble_image) {
                    $page->addHashedMedia($request->how_it_works_section_bubble_image)
                        ->toMediaCollection('how_it_works_section_bubble_image');
                }

                if ($request->sub_banner_1_icon) {
                    $page->addHashedMedia($request->sub_banner_1_icon)
                        ->toMediaCollection('sub_banner_1_icon');
                }

                if ($request->sub_banner_2_icon) {
                    $page->addHashedMedia($request->sub_banner_2_icon)
                        ->toMediaCollection('sub_banner_2_icon');
                }

                if ($request->sub_banner_3_icon) {
                    $page->addHashedMedia($request->sub_banner_3_icon)
                        ->toMediaCollection('sub_banner_3_icon');
                }

                if ($request->sub_banner_4_icon) {
                    $page->addHashedMedia($request->sub_banner_4_icon)
                        ->toMediaCollection('sub_banner_4_icon');
                }

                if ($request->why_us_1_icon) {
                    $page->addHashedMedia($request->why_us_1_icon)
                        ->toMediaCollection('why_us_1_icon');
                }

                if ($request->why_us_2_icon) {
                    $page->addHashedMedia($request->why_us_2_icon)
                        ->toMediaCollection('why_us_2_icon');
                }

                if ($request->why_us_3_icon) {
                    $page->addHashedMedia($request->why_us_3_icon)
                        ->toMediaCollection('why_us_3_icon');
                }

                if ($request->why_us_4_icon) {
                    $page->addHashedMedia($request->why_us_4_icon)
                        ->toMediaCollection('why_us_4_icon');
                }

                if ($request->why_us_5_icon) {
                    $page->addHashedMedia($request->why_us_5_icon)
                        ->toMediaCollection('why_us_5_icon');
                }

                if ($request->why_us_6_icon) {
                    $page->addHashedMedia($request->why_us_6_icon)
                        ->toMediaCollection('why_us_6_icon');
                }

            } else {
                $page = FrontendHomepage::create($data);

                if ($request->banner_section_image) {
                    $page->addHashedMedia($request->banner_section_image)
                        ->toMediaCollection('banner_section_image');
                }

                if ($request->banner_section_mobile_image) {
                    $page->addHashedMedia($request->banner_section_mobile_image)
                        ->toMediaCollection('banner_section_mobile_image');
                }

                if ($request->ingredient_section_main_image) {
                    $page->addHashedMedia($request->ingredient_section_main_image)
                        ->toMediaCollection('ingredient_section_main_image');
                }

                if ($request->ingr_1_image) {
                    $page->addHashedMedia($request->ingr_1_image)
                        ->toMediaCollection('ingr_1_image');
                }

                if ($request->ingr_2_image) {
                    $page->addHashedMedia($request->ingr_2_image)
                        ->toMediaCollection('ingr_2_image');
                }

                if ($request->ingr_3_image) {
                    $page->addHashedMedia($request->ingr_3_image)
                        ->toMediaCollection('ingr_3_image');
                }

                if ($request->ingr_4_image) {
                    $page->addHashedMedia($request->ingr_4_image)
                        ->toMediaCollection('ingr_4_image');
                }

                if ($request->ingr_5_image) {
                    $page->addHashedMedia($request->ingr_5_image)
                        ->toMediaCollection('ingr_5_image');
                }

                if ($request->ingr_6_image) {
                    $page->addHashedMedia($request->ingr_6_image)
                        ->toMediaCollection('ingr_6_image');
                }

                if ($request->why_us_section_image) {
                    $page->addHashedMedia($request->why_us_section_image)
                        ->toMediaCollection('why_us_section_image');
                }

                if ($request->review_1_image) {
                    $page->addHashedMedia($request->review_1_image)
                        ->toMediaCollection('review_1_image');
                }

                if ($request->review_2_image) {
                    $page->addHashedMedia($request->review_2_image)
                        ->toMediaCollection('review_2_image');
                }

                if ($request->review_3_image) {
                    $page->addHashedMedia($request->review_3_image)
                        ->toMediaCollection('review_3_image');
                }

                if ($request->how_it_works_section_main_image) {
                    $page->addHashedMedia($request->how_it_works_section_main_image)
                        ->toMediaCollection('how_it_works_section_main_image');
                }

                if ($request->how_it_works_section_bubble_image) {
                    $page->addHashedMedia($request->how_it_works_section_bubble_image)
                        ->toMediaCollection('how_it_works_section_bubble_image');
                }

                if ($request->sub_banner_1_icon) {
                    $page->addHashedMedia($request->sub_banner_1_icon)
                        ->toMediaCollection('sub_banner_1_icon');
                }

                if ($request->sub_banner_2_icon) {
                    $page->addHashedMedia($request->sub_banner_2_icon)
                        ->toMediaCollection('sub_banner_2_icon');
                }

                if ($request->sub_banner_3_icon) {
                    $page->addHashedMedia($request->sub_banner_3_icon)
                        ->toMediaCollection('sub_banner_3_icon');
                }

                if ($request->sub_banner_4_icon) {
                    $page->addHashedMedia($request->sub_banner_4_icon)
                        ->toMediaCollection('sub_banner_4_icon');
                }

                if ($request->why_us_1_icon) {
                    $page->addHashedMedia($request->why_us_1_icon)
                        ->toMediaCollection('why_us_1_icon');
                }

                if ($request->why_us_2_icon) {
                    $page->addHashedMedia($request->why_us_2_icon)
                        ->toMediaCollection('why_us_2_icon');
                }

                if ($request->why_us_3_icon) {
                    $page->addHashedMedia($request->why_us_3_icon)
                        ->toMediaCollection('why_us_3_icon');
                }

                if ($request->why_us_4_icon) {
                    $page->addHashedMedia($request->why_us_4_icon)
                        ->toMediaCollection('why_us_4_icon');
                }

                if ($request->why_us_5_icon) {
                    $page->addHashedMedia($request->why_us_5_icon)
                        ->toMediaCollection('why_us_5_icon');
                }

                if ($request->why_us_6_icon) {
                    $page->addHashedMedia($request->why_us_6_icon)
                        ->toMediaCollection('why_us_6_icon');
                }
            }
            return $this->returnCrudData('Created Successfully', route('content.admin.page.index'));
        } catch (\Throwable $exception) {
            return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
    }

    public function rewardProgramStore(Request $request)
    {
        try {
            $data = $request->except('how_it_works_1_icon', 'how_it_works_2_icon', 'how_it_works_3_icon', 'how_to_collect_image', 'banner_image');

            if ($page = FrontendRewardProgram::first()) {
                $page->update($data);
            } else {
                $page = FrontendRewardProgram::create($data);
            }

            if ($request->how_it_works_1_icon) {
                $page->addHashedMedia($request->how_it_works_1_icon)
                    ->toMediaCollection('how_it_works_1_icon');
            }

            if ($request->how_it_works_2_icon) {
                $page->addHashedMedia($request->how_it_works_2_icon)
                    ->toMediaCollection('how_it_works_2_icon');
            }

            if ($request->how_it_works_3_icon) {
                $page->addHashedMedia($request->how_it_works_3_icon)
                    ->toMediaCollection('how_it_works_3_icon');
            }

            if ($request->how_to_collect_image) {
                $page->addHashedMedia($request->how_to_collect_image)
                    ->toMediaCollection('how_to_collect_image');
            }

            if ($request->banner_image) {
                $page->addHashedMedia($request->banner_image)
                    ->toMediaCollection('banner_image');
            }

            return $this->returnCrudData('Created Successfully', route('content.admin.page.index'));
        } catch (\Throwable $exception) {
            return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
    }

    public function aboutUsStore(Request $request)
    {
        try {
            $data = $request->except('banner_section_image', 'our_mission_image', 'customised_options_section_image', 'why_section_image', 'options_image', 'our_story_image');

            if ($page = FrontendAboutUs::first()) {
                $page->update($data);
            } else {
                $page = FrontendAboutUs::create($data);
            }

            if ($request->banner_section_image) {
                $page->addHashedMedia($request->banner_section_image)
                    ->toMediaCollection('banner_section_image');
            }

            if ($request->our_mission_image) {
                $page->addHashedMedia($request->our_mission_image)
                    ->toMediaCollection('our_mission_image');
            }

            if ($request->customised_options_section_image) {
                $page->addHashedMedia($request->customised_options_section_image)
                    ->toMediaCollection('customised_options_section_image');
            }

            if ($request->why_section_image) {
                $page->addHashedMedia($request->why_section_image)
                    ->toMediaCollection('why_section_image');
            }

            if ($request->options_image) {
                $page->addHashedMedia($request->options_image)
                    ->toMediaCollection('options_image');
            }

            if ($request->our_story_image) {
                $page->addHashedMedia($request->our_story_image)
                    ->toMediaCollection('our_story_image');
            }

            return $this->returnCrudData('Created Successfully', route('content.admin.page.index'));
        } catch (\Throwable $exception) {
            return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
    }
}
