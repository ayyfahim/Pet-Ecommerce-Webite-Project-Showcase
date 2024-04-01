<?php
namespace Database\Seeders;
use App\Models\Cart;
use App\Models\Order;
use App\Models\RfpProposal;
use App\Models\PaymentMethod;
use App\Models\ServiceRequest;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run()
    {
        for ($i = 0; $i < 30; $i++) {
            $sr = ServiceRequest::inRandomOrder()->first();
            $sr->order()->create();
            $proposal = RfpProposal::inRandomOrder()->first();
            $proposal->order()->create();
        }
    }
}
