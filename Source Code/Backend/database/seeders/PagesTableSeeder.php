<?php
namespace Database\Seeders;
use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PagesTableSeeder extends Seeder
{
    /**
     * Seed the User's table data.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table((new \App\Models\Page())->getTable())->truncate();
        $categories = ['About', 'Help & Support', 'Corporate'];
        $status = Page::getStatusFor('status');
        $page = Page::create([
            'status_id' => $status->firstWhere('order', 1)->id,
            'slug' => "About",
            'title' => "About",
            'content' => faker()->paragraph(7),
            'info' => [
                'title' => "Welcome to Dealaday",
                'vision' => faker()->paragraph(4),
                'mission' => faker()->paragraph(4),
            ],
            'type' => 'about',
            'category' => $categories[0],
            'order' => 1,
        ]);
        Page::create([
            'status_id' => $status->firstWhere('order', 1)->id,
            'slug' => "homepage",
            'title' => "Homepage",
            'content' => faker()->paragraph(7),
            'info' => [
                'title' => "Welcome to Dealaday",
                'vision' => faker()->paragraph(4),
                'mission' => faker()->paragraph(4),
            ],
            'type' => 'about',
            'category' => $categories[0],
            'order' => 1,
        ]);
        Page::create([
            'status_id' => $status->firstWhere('order', 1)->id,
            'slug' => "shop",
            'title' => "Shop",
            'content' => faker()->paragraph(7),
            'info' => [
                'title' => "Welcome to Dealaday",
                'vision' => faker()->paragraph(4),
                'mission' => faker()->paragraph(4),
            ],
            'type' => 'static',
            'category' => $categories[0],
            'order' => 1,
        ]);
        Page::create([
            'status_id' => $status->firstWhere('order', 1)->id,
            'slug' => "blog",
            'title' => "Blog",
            'content' => faker()->paragraph(7),
            'info' => [
                'title' => "Welcome to Dealaday",
                'vision' => faker()->paragraph(4),
                'mission' => faker()->paragraph(4),
            ],
            'type' => 'static',
            'category' => $categories[0],
            'order' => 1,
        ]);
        Page::create([
            'status_id' => $status->firstWhere('order', 1)->id,
            'slug' => "disclaimer",
            'title' => "Disclaimer",
            'content' => faker()->paragraph(7),
            'info' => [
                'title' => "Welcome to Dealaday",
                'vision' => faker()->paragraph(4),
                'mission' => faker()->paragraph(4),
            ],
            'type' => 'static',
            'category' => $categories[0],
            'order' => 1,
        ]);
        Page::create([
            'status_id' => $status->firstWhere('order', 1)->id,
            'slug' => "faq",
            'title' => "Faq",
            'content' => faker()->paragraph(7),
            'info' => [
                'title' => "Welcome to Dealaday",
                'vision' => faker()->paragraph(4),
                'mission' => faker()->paragraph(4),
            ],
            'type' => 'static',
            'category' => $categories[0],
            'order' => 1,
        ]);
        Page::create([
            'status_id' => $status->firstWhere('order', 1)->id,
            'slug' => "returns-and-refunds",
            'title' => "Returns and Refunds",
            'content' => faker()->paragraph(7),
            'info' => [
                'title' => "Welcome to Dealaday",
                'vision' => faker()->paragraph(4),
                'mission' => faker()->paragraph(4),
            ],
            'type' => 'static',
            'category' => $categories[0],
            'order' => 1,
        ]);
        Page::create([
            'status_id' => $status->firstWhere('order', 1)->id,
            'slug' => "reward-program",
            'title' => "Reward Program",
            'content' => faker()->paragraph(7),
            'info' => [
                'title' => "Welcome to Dealaday",
                'vision' => faker()->paragraph(4),
                'mission' => faker()->paragraph(4),
            ],
            'type' => 'about',
            'category' => $categories[0],
            'order' => 1,
        ]);
        Page::create([
            'status_id' => $status->firstWhere('order', 1)->id,
            'slug' => "terms-and-conditions",
            'title' => "Terms and Conditions",
            'content' => faker()->paragraph(25),
            'type' => 'static',
            'category' => $categories[1],
            'order' => 3,
        ]);
        Page::create([
            'status_id' => $status->firstWhere('order', 1)->id,
            'slug' => "privacy-policy",
            'title' => "Privacy Policy",
            'content' => faker()->paragraph(25),
            'type' => 'static',
            'category' => $categories[1],
            'order' => 4,
        ]);
        Page::create([
            'status_id' => $status->firstWhere('order', 1)->id,
            'slug' => "refund-policy",
            'title' => "Refund Policy",
            'content' => faker()->paragraph(25),
            'type' => 'static',
            'category' => $categories[1],
            'order' => 5,
        ]);
        Page::create([
            'status_id' => $status->firstWhere('order', 1)->id,
            'slug' => "contact-us",
            'title' => "Contact Us",
            'info' => [
                'office' => faker()->address,
                'postal' => faker()->address,
                'email' => faker()->email,
                'phone' => faker()->phoneNumber,
            ],
            'type' => 'contact',
            'order' => 6,
        ]);
    }
}
