<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderFilterRequest;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //filtred by request query: created_at,created_at_to,created_at_from,sort,limit
    //sort =-id -> order by id desc, sort=id -> order by id asc
    public function index(): JsonResponse
    {
        $order = app(Pipeline::class)
            ->send(Order::query()->with('products', 'user'))
            ->through(
                [
                    \App\QueryFilters\CreatedAt::class,
                    \App\QueryFilters\Sort::class,
                    \App\QueryFilters\PaginateCustom::class,
                ]
            )->thenReturn();

        return response()->json($order);
    }

    public function store(OrderStoreRequest $request): JsonResponse
    {
        $order_data = $request->only('order_date', 'phone', 'lng', 'lat');
        $order_data['user_id'] = auth()->id();
        try {
            DB::beginTransaction();
            $order = Order::query()->create($order_data);
            foreach ($request->products as $product) {
                OrderProduct::query()->create(
                    [
                        'order_id' => $order->id,
                        'product_id' => $product['id'],
                        'product_count' => $product['count'],
                        'amount' => Product::find($product['id'])->value('price') * $product['count']

                    ]
                );
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return response()->json(new OrderResource($order));
    }

    public function show($id): JsonResponse
    {
        return response()->json(
            new OrderResource(
                Order::where('id', $id)->with('products', 'user')->firstOrFail()
            )
        );
    }

    public function update(OrderUpdateRequest $request, $id): JsonResponse
    {
        $order_data = $request->only('order_date', 'phone', 'lng', 'lat');
        $order = Order::query()->findOrFail($id);
        try {
            DB::beginTransaction();
            $order->update($order_data);
            if ($request->has('products')) {
                OrderProduct::query()->where('order_id', $order->id)->delete();
                foreach ($request->products as $product) {
                    OrderProduct::query()->create(
                        [
                            'order_id' => $order->id,
                            'product_id' => $product['id'],
                            'product_count' => $product['count'],
                            'amount' => Product::find($product['id'])->value('price') * $product['count']

                        ]
                    );
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return response()->json(new OrderResource($order));
    }

    public function destroy($id): JsonResponse
    {
        return response()->json(Order::destroy($id));
    }
}
