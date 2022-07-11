<?php

namespace App\Http\Controllers;

use App\Jobs\createProduct;
use App\Jobs\deleteProduct;
use App\Models\Product;
use App\Models\Productlist;
use App\Models\Shopify;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShopifyController extends Controller
{
    public function shopify(Request $request)
    {
        $name = $request->input('name');
        $fullname = $name . '.myshopify.com';
        $api_key = '654f376a65553734fc2003c474fabc65';
        $scopes = 'write_orders,read_customers,read_products,write_products,read_product_listings';
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
        $this->createWebhook();

        return redirect()->route('shopifyName');
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
        $client = new Client();
        $url = 'https://manh-store123.myshopify.com/admin/api/2022-07/products.json';

        $resShop = $client->request('get', $url, [
            'headers' => [
                'X-Shopify-Access-Token' => 'shpua_feb8882df2b643e3290aa807f7086636',
            ],
        ]);

        $data = (array)json_decode($resShop->getBody()->getContents());

        foreach ($data['products'] as $item) {
            if (empty(Productlist::find($item->id))) {
                $data = [
                    'id' =>   $item->id,
                    'body_html' => $item->body_html,
                    'title' => $item->title,
                    'handle' => $item->handle,
                    'status' => $item->status,
                    //  'image'=> $item->image,
                ];
                Productlist::create($data);
            }
        }
        $products = DB::table('productslist')->get();

        return view('shopify.listShop', [
            'currentPage' => 'shopify',
            'products' => $products
        ]);
    }
    //createProduct webhook
    public function createWebhook()
    {
        $client = new Client();
        $url = 'https://manh-store123.myshopify.com/admin/api/2022-07/webhooks.json';

        $client->request('POST', $url, [
            'headers' => [
                'X-Shopify-Access-Token' => 'shpua_feb8882df2b643e3290aa807f7086636',
            ],
            'form_params' => [
                'webhook' => [
                    'topic' => 'products/create',
                    'format' => 'json',
                    'address' => 'https://cd44-2402-800-63ba-cace-18fe-103b-66d3-6a34.ap.ngrok.io/api/createProduct',
                ],
            ]
        ]);
    }

    public function createProduct(Request $request)
    {
        $job = new createProduct($request->all());
        dispatch($job)->delay(now()->addSecond(1));
    }

    public function updateProduct()
    {
        $client = new Client();
        $url = 'https://manh-store123.myshopify.com/admin/api/2022-07/webhooks.json';

        $client->request('POST', $url, [
            'headers' => [
                'X-Shopify-Access-Token' => 'shpua_feb8882df2b643e3290aa807f7086636',
            ],
            'form_params' => [
                'webhook' => [
                    'topic' => 'products/update',
                    'format' => 'json',
                    'address' => 'https://cd44-2402-800-63ba-cace-18fe-103b-66d3-6a34.ap.ngrok.io/api/updatePro',
                ],
            ]
        ]);
    }

    public function updatePro(Request $request)
    {

        Productlist::where('id', '=', $request->input('id'))->update([
            'id' =>    $request->input('id'),
            'body_html' =>  $request->input('body_html'),
            'title' =>  $request->input('title'),
            'handle' =>  $request->input('handle'),
            'status' =>  $request->input('status'),
        ]);
    }

    public function deleteProductWebhook()
    {
        $client = new Client();
        $url = 'https://manh-store123.myshopify.com/admin/api/2022-07/webhooks.json';

        $client->request('POST', $url, [
            'headers' => [
                'X-Shopify-Access-Token' => 'shpua_feb8882df2b643e3290aa807f7086636',
            ],
            'form_params' => [
                'webhook' => [
                    'topic' => 'products/delete',
                    'format' => 'json',
                    'address' => 'https://cd44-2402-800-63ba-cace-18fe-103b-66d3-6a34.ap.ngrok.io/api/deletePr',
                ],
            ]
        ]);
    }

    public function deletePr(Request $request)
    {
        $id = $request->input('id');
        Productlist::where('id', '=', $id)->delete();
    }

    public function delete(Request $request, $id)
    {
        $client = new Client();
        $url = 'https://manh-store123.myshopify.com/admin/api/2022-07/products/' . $id . '.json';

        $client->request('DELETE', $url, [
            'headers' => [
                'X-Shopify-Access-Token' => 'shpua_feb8882df2b643e3290aa807f7086636',
            ],
        ]);
        Productlist::where('id', '=', $id)->delete();
        return redirect()->back();
    }

    public function edit($id)
    {
        $product = DB::table('productslist')->where('id', '=', $id)->get();
        return view(
            'shopify.edit',
            [
                'product' => $product,
                'currentPage' => 'shopify'
            ]
        );
        return redirect()->back();
    }

    // Update values into DB
    public function update(Request $request, $id)
    {
        Productlist::find($id);
        DB::table('productslist')->where('id', $id)
            ->update(
                [
                    'user_id' => $request->input('user_id'),
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'quantity' => $request->input('quantity'),
                    'status' => $request->input('status'),
                    'category_id' => $request->input('category_id'),
                    'price' => $request->input('price')
                ]
            );

        // Redirect to tasks url
        return redirect()->route('shopifyName');
    }
}
