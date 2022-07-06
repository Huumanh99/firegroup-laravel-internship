<?php

namespace App\Http\Controllers;

use App\Models\Shopify;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ShopifyController extends Controller
{
    public function shopify(Request $request)
    {
    //    $shop = $request->shop;
       $name = $request->input('name');
       $fullname = $name .'.myshopify.com';
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
        $uri = 'https://'.$domain.'/admin/api/2022-07/shop.json?';
        $resShop = $client->request('GET', $uri, [
            'headers' => [
                'X-Shopify-Access-Token' => $accessToken,
            ]
        ]);
        
        $data = (array) json_decode($resShop->getBody());

        $getfilter = $data['shop'];
        Shopify::create([
            'name'=> $getfilter->name, 
            'domain' => $domain,
            'email' => $getfilter->email,
            'shopify_domain'=> $domain,
            'plan_name' => $getfilter->plan_name,
            'access_token' => $accessToken,
        ]);
    }
    
    public function getAccessToken(string $code, string $domain)
    {
        $client = New Client();
        $response = $client->post(
            "https://" . $domain . "/admin/oauth/access_token",
            [
                'form_params' => [
                    'client_id' =>"654f376a65553734fc2003c474fabc65",
                    'client_secret' => "8db2f21a512004a3b6b8d878a44573f3",
                    'code' => $code,
                ]
            ]
        );
        return json_decode($response->getBody()->getContents());
    }

    public function pageTest()
    {
        return view('products.page');
    }
}

