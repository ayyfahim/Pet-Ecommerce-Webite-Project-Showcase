<?php
namespace Database\Seeders;
use App\Models\MailTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table((new \App\Models\Notification())->getTable())->truncate();
        DB::table((new \App\Models\EmailNotificationTemplate())->getTable())->truncate();
        $project_name = config('app.name');
        $support = route('home');
        $events = [
            'email_verification', // 0
            'mobile_verification', // 1
            'forget_password', // 2
            'support', // 3
            'order_confirmation', // 4
            'order_ship', // 5
            'order_cancel', // 6
            'points_create', // 7
            'points_reminder', // 8
            'admin_order_create', // 9
            'supplier_order_create', // 10
            'wishlist_reminder', // 11
            'cart_reminder', // 12
            'admin_product_out_of_stock', // 13
            '', // 12

        ];
        $email_list = [
            [
                'subject' => 'Confirm your account, {{user-full-name}}',
                'body' => "Thank you for joining $project_name!<br><br>
                    Let’s get started! Please confirm your email address using the below link.<br><br>
                    <a class=\"btn-link\" href=\"{{link}}\">Verify My Email Address</a>",
                'event' => $events[0],
            ],
            [
                'subject' => "$project_name account password reset",
                'body' => "We just got a request to change your password on $project_name.<br><br>
                    <a class=\"btn-link\" href=\"{{link}}\">Change your password</a><br>
                    Didn't request a password change? Just ignore this message; no action needed from your side.<br>",
                'event' => $events[2],
            ],
            [
                'subject' => "New Submission from “Support” form",
                'body' => "This is a new submission from your website support form:<br><br>
                    <b>Name:</b> {{name}}<br>
                	<b>Email:</b> {{email}}<br>
                	<b>Phone:</b> {{phone}}<br>
                	<b>Message:</b> {{message}}<br>",
                'event' => $events[3],
            ],
            [
                'subject' => 'Your order: #{{order-short-id}} has been successfully confirmed',
                'body' => "Your order: #{{order-short-id}} has been successfully confirmed<br>
                {{voucher-code}}
                Total price: <b>{{total-price}} $</b><br>
                {{products}}<br>
                {{shipping-info}}<br>
                 Thank you for using $project_name.<br><br>
                <a href=\"{{order-link}}\">View Order</a>",
                'event' => $events[4],
            ],
            [
                'subject' => 'New order has been placed #{{order-short-id}}',
                'body' => "There's a new order has been placed #{{order-short-id}}<br>
                {{voucher-code}}
                Total price: <b>{{total-price}} $</b><br><br>
                {{products}}<br>
                {{voucher-code}}<br>
                {{shipping-info}}<br>
                <a href=\"{{admin-order-link}}\">View Order</a>",
                'event' => $events[9],
            ],
            [
                'subject' => 'New order has been placed #{{order-short-id}}',
                'body' => "There's a new order has been placed #{{order-short-id}}<br>
                {{products}}<br>
                {{voucher-code}}<br>
                {{shipping-info}}<br>"
                ,
                'event' => $events[10],
            ],
            [
                'subject' => 'Your order has been shipped | Order: #{{order-short-id}}',
                'body' => "We are glad to inform you that the Order: #{{order-short-id}} has been shipped and will be delivered soon.<br>
                Tracking Code: <b>{{tracking-code}}</b><br><br>
                <a href=\"{{order-link}}\">View Order</a>",
                'event' => $events[5],
            ],
            [
                'subject' => 'Order Cancelled | Order: #{{order-short-id}}',
                'body' => "This is an automatic notification to inform you that the order: #{{order-short-id}} has been cancelled
                        <br>
                        <b>{{reason}}</b>
                        <br>
                    If you have any further inquiries, feel free to contact us through the <a href=\"$support\">support form</a> on $project_name.",
                'event' => $events[6],
            ],
            [
                'subject' => "Congratulations! You've earned new points",
                'body' => "Congratulations! You've earned <b>{{points}} Points</b> from order <b>#{{order-short-id}}</b><br>
                            Your total points = <b>{{total-points}}</b><br>
                            Don't forget to exchange them in your next order<br><br>
                            <a href=\"{{order-link}}\">View Order</a>",
                'event' => $events[7],
            ],
            [
                'subject' => 'Reward Points Reminder',
                'body' => "Don't forget to use your reward points to get discount.
                <br> You've : {{total_reward_points}} points and you can exchange them for {{total_reward_points_exchange}} $!
                <br><br> <a class=\"btn-link\"  href=\"{{link}}\">Start Shopping</a>",
                'event' => $events[8],
            ],
            [
                'subject' => "You've left products in your wishlist",
                'body' => "Don't forget to use the products you've added in your wishlist.
                <br><br><a class=\"btn-link\"  href=\"{{wishlist-link}}\">View Wishlist</a>",
                'event' => $events[11],
            ],
            [
                'subject' => 'Complete your Purchase',
                'body' => "You've added products in your shopping cart and haven't completed your purchase.
                <br>You can complete it now while they're still available
                <br><br> <a class=\"btn-link\"  href=\"{{cart-link}}\">View Cart</a>",
                'event' => $events[12],
            ],
            [
                'subject' => 'Products about to get out of stock',
                'body' => "This is an automatic email to inform you that there're some products about to get out of stock.<br><br>
                {{products}}",
                'event' => $events[13],
            ],
//            [
//                "<a href=\"{{order-link}}\">{{order-short-id}}</a>",
//                'subject' => 'New order created - Order: #{{order-short-id}}',
//                'body' => "",
//                'event' => $events[9],
//            ],
        ];
        $email_list = collect($email_list);
        foreach ($events as $event) {
            $notification = \App\Models\Notification::create([
                'event' => $event,
                'title' => ucwords(str_replace('_', ' ', $event))
            ]);
            if ($email = $email_list->firstWhere('event', $event)) {
                $notification->email_notification()->create([
                    'subject' => $email['subject'],
                    'body' => $email['body'],
                ]);
            }
        }
    }
}
