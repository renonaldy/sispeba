<?php

namespace App\Console\Commands;

use App\Events\TrackingUpdated;
use App\Models\Pengiriman;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdatePengirimanStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-pengiriman-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status pengiriman secara otomatis berdasarkan waktu';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $now = Carbon::now();

        // 1. Pickup -> Transit (>1 hari)
        $pickupPengiriman = Pengiriman::where('status', 'pickup')->get();
        foreach ($pickupPengiriman as $item) {
            $lastStatus = $item->statuses()->latest('waktu_status')->first();
            if ($lastStatus && $now->diffInHours($lastStatus->waktu_status) > 24) {
                $item->status = 'transit';
                $item->lokasi_terakhir = 'Menuju tujuan';
                $item->save();

                $item->statuses()->create([
                    'status' => 'transit',
                    'waktu_status' => $now,
                ]);

                event(new TrackingUpdated($item->no_resi, 'transit', $now));
                Log::info("Auto-update: {$item->no_resi} -> transit");
            }
        }

        // 2. Transit -> Delivered (>2 hari)
        $transitPengiriman = Pengiriman::where('status', 'transit')->get();
        foreach ($transitPengiriman as $item) {
            $lastStatus = $item->statuses()->latest('waktu_status')->first();
            if ($lastStatus && $now->diffInHours($lastStatus->waktu_status) > 48) {
                $item->status = 'delivered';
                $item->lokasi_terakhir = 'Sudah diterima';
                $item->save();

                $item->statuses()->create([
                    'status' => 'delivered',
                    'waktu_status' => $now,
                ]);

                event(new TrackingUpdated($item->no_resi, 'delivered', $now));
                Log::info("Auto-update: {$item->no_resi} -> delivered");
            }
        }

        $this->info('Status pengiriman diperbarui otomatis.');
    }
}
