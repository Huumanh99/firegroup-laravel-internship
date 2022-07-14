<?php

namespace App\Jobs;

use App\Models\Productlist;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class createProduct implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $request;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $product = $this->request;

        if ($product['image'] === null) {
           $data = $this->image($product);
        } else {
          $dataImgae = $this->image($product);
          $dataSrc = ['image'=> $product['image']['src']];
          $data = array_merge($dataImgae, $dataSrc);
        }
        
      Productlist::create($data);
    }

    public function image($product){
        $data = [];
        $data = [
            'id' =>   $product['id'],
            'body_html' => $product['body_html'],
            'title' => $product['title'],
            'handle' => $product['handle'],
            'status' => $product['status'],
        ];

        return $data;
    }
}
