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
use Illuminate\Support\Facades\Validator;

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
        $client = new Client();

        $code = $request->code;
        $domain = $request->shop;
        $data = $this->getAccessToken($code, $domain);
        $accessToken = $data->access_token;

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

    //Get access token 
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
                $dataProduct = [
                    'id' =>   $item->id,
                    'body_html' => $item->body_html,
                    'title' => $item->title,
                    'handle' => $item->handle,
                    'status' => $item->status,
                    'image' =>  $item->image,
                ];

                Productlist::create($dataProduct);
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
        $topics = [
            '0' => [
                'nameTopic' => 'products/create',
                'address' => 'https://0211-113-161-32-170.ap.ngrok.io/api/createProductOnShopify'
            ],
            '1' => [
                'nameTopic' => 'products/update',
                'address' => 'https://0211-113-161-32-170.ap.ngrok.io/api/updateProductOnShopify'
            ],
            '2' => [
                'nameTopic' => 'products/delete',
                'address' => 'https://0211-113-161-32-170.ap.ngrok.io/api/deleteProductOnShopify'
            ]
        ];

        foreach ($topics as $key => $value) {

            $client = new Client();

            $url = 'https://manh-store123.myshopify.com/admin/api/2022-07/webhooks.json';
            $client->request('POST', $url, [
                'headers' => [
                    'X-Shopify-Access-Token' => 'shpua_feb8882df2b643e3290aa807f7086636',
                ],
                'form_params' => [
                    'webhook' => [
                        'topic' => $topics[$key]['nameTopic'],
                        'format' => 'json',
                        'address' => $topics[$key]['address'],
                    ],
                ]
            ]);
        }

        return redirect()->back();
    }

    //Create products on Shopify, (Queue)
    public function createProductOnShopify(Request $request)
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
                    'address' => 'https://0211-113-161-32-170.ap.ngrok.io/api/updateProductOnShopify',
                ],
            ]
        ]);
    }

    //Update Product on Shopify
    public function updateProductOnShopify(Request $request)
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
                    'address' => 'https://0211-113-161-32-170.ap.ngrok.io/api/deleteProductOnShopify',
                ],
            ]
        ]);
    }

    //Delete Product on Shopify
    public function deleteProductOnShopify(Request $request)
    {
        $id = $request->input('id');
        Productlist::where('id', '=', $id)->delete();
    }

    //Delete Product on Local
    public function deleteProducLocal(Request $request, $id)
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

    //Edit Product on Local
    public function editProductLocal($id)
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

    // Update products on local
    public function updateProductLocal(Request $request, $id)
    {
        $client = new Client();

        $data = [
            'body_html' => $request->input('body_html'),
            'handle' => $request->input('handle'),
            'title' => $request->input('title'),
            'status' => $request->input('status'),
            'image' => $request->image,
        ];
        

        $url = 'https://manh-store123.myshopify.com/admin/api/2022-07/products/' . $id . '.json';
        $getalldata = $client->request('PUT', $url, [
            'headers' => [
                'X-Shopify-Access-Token' => 'shpua_feb8882df2b643e3290aa807f7086636',
            ],
            'query' => [
                'product' => [
                    'title' => $data['title'],
                    'handle' => $data['handle'],
                    'image' => $request->image,
                    'body_html' => $data['body_html'],
                ],
            ]
        ]);

        $image = $data['image'];
        
        $getDataUpdate = (array)json_decode($getalldata->getBody()->getContents());

        $id = $getDataUpdate['product']->id;
        $image_id = $getDataUpdate['product']->image->id;

        $urlProductImage = 'https://manh-store123.myshopify.com/admin/api/2022-07/products/' . $id . '/images/' . $image_id . '.json';
        $client->request('PUT', $urlProductImage, [
            'headers' => [
                'X-Shopify-Access-Token' => 'shpua_feb8882df2b643e3290aa807f7086636',
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'image' => [
                    'attachment' => base64_encode(file_get_contents($image)),
                    'filename' => $image->getClientOriginalName()
                ],
            ]
        ]);
        // Redirect to tasks url
        return redirect()->route('shopifyName');
    }

    public function createShopify()
    {
        return view(
            'shopify.create',
            [
                'currentPage' => 'shopify'
            ]
        );
    }

    //create products on local
    public function createProductLocal(Request $request)
    {
        $client = new Client();

        $data = Validator::make($request->all(), [
            'body_html' => 'required',
            'handle' => 'required',
            'title' => 'required',
            'status' => 'required',
        ]);

        if ($data->fails()) {

            session()->flash('error', 'Please enter the correct fields');

            return redirect()->back();
        } else {
            $data = [
                'body_html' => $request->input('body_html'),
                'handle' => $request->input('handle'),
                'title' => $request->input('title'),
                'status' => $request->input('status'),
                'image' => $request->image,
            ];
            $image = $data['image'];


            $url = 'https://manh-store123.myshopify.com/admin/api/2022-07/products.json';
            $response = $client->request('POST', $url, [
                'headers' => [
                    'X-Shopify-Access-Token' => 'shpua_feb8882df2b643e3290aa807f7086636',
                    'Content-Type' => 'application/json',
                ],
                'query' => [
                    'product' => [
                        'title' => $data['title'],
                        'handle' => $data['handle'], 
                        'body_html' => $data['body_html'],
                    ]
                ],
            ]);

            $getdata = (array)json_decode($response->getBody());
            $id = $getdata['product']->id;

            $urlProductImage = 'https://manh-store123.myshopify.com/admin/api/2022-07/products/' . $id . '/images.json';
            $client->request('POST', $urlProductImage, [
                'headers' => [
                    'X-Shopify-Access-Token' => 'shpua_feb8882df2b643e3290aa807f7086636',
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'image' => [
                        'attachment' => base64_encode(file_get_contents($image)),
                        'filename' => $image->getClientOriginalName(),
                    ]
                ]
            ]);
        }
        return redirect()->back();
    }
}
