<?php

namespace App\Http\Controllers;

use App\Models\Shopify;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShopifyController extends Controller
{
    public function shopify(Request $request)
    {
        $name = $request->input('name');
        $fullname = $name . '.myshopify.com';
        $api_key = '654f376a65553734fc2003c474fabc65';
        $scopes = 'write_orders,read_customers';
        $redirect_uri = "http://127.0.0.1:8000/shopify/url";
        $html =  "https://$fullname/admin/oauth/authorize?client_id=$api_key&scope=$scopes&redirect_uri=$redirect_uri";

        return redirect($html);
    }

    public function generateCode(Request $request)
    {
        $code = $request->code;
        $domain = $request->shop;
        $data = $this->getAccessToken($code, $domain);
        $accessToken = $data->access_token;
        $client = new Client();
        $uri = 'https://' . $domain . '/admin/api/2022-07/shop.json?';
        $resShop = $client->request('GET', $uri, [
            'headers' => [
                'X-Shopify-Access-Token' => $accessToken,
            ]
        ]);

        $data = (array) json_decode($resShop->getBody());
        $getfilter = $data['shop'];

        if (Shopify::where('email', $getfilter->email)->first()) {
            Shopify::where('email', $getfilter->email)->update([
                'access_token' => $accessToken,
            ]);
        } else {
            Shopify::create([
                'name' => $getfilter->name,
                'domain' => $domain,
                'email' => $getfilter->email,
                'shopify_domain' => $domain,
                'plan_name' => $getfilter->plan_name,
                'access_token' => $accessToken,
            ]);
        }
    }

    public function getAccessToken(string $code, string $domain)
    {
        $client = new Client();
        $response = $client->post(
            "https://" . $domain . "/admin/oauth/access_token",
            [
                'form_params' => [
                    'client_id' => "654f376a65553734fc2003c474fabc65",
                    'client_secret' => "8db2f21a512004a3b6b8d878a44573f3",
                    'code' => $code,
                ]
            ]
        );
        return json_decode($response->getBody()->getContents());
    }

    public function shopifyName()
    {
        return view('shopify.listShop', [
            'currentPage' => 'shopify'
        ]);
    }

    public function createWebhook()
    {
        $client = new Client();
        $url = 'https://manh-store123.myshopify.com/admin/api/2022-07/webhooks.json';

        $resShop = $client->request('POST', $url, [
            'headers' => [
                'X-Shopify-Access-Token' => 'shpua_feb8882df2b643e3290aa807f7086636',
            ],
            'form_params' => [
                'webhook' => [
                    'topic' => 'customers/create',
                    'format' => 'json',
                    'address' => 'https://3bbe-113-161-32-170.ap.ngrok.io/api/createProduct',
                ],

            ]
        ]);
        dd($resShop->getBody()->getContents());
    }

    public function createProduct()
    {
        echo ('hello');
    }
}
