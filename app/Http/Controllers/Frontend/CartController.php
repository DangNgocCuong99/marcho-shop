<?php

namespace App\Http\Controllers\Frontend;

use Cart;
use App\Models\Attribute;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = Cart::name('shopping');
        $items = $cart->getItems();
        $total = $cart->getItemsSubtotal();
        $subtotal = $cart->getSubtotal();
        $action = $cart->sumActionsAmount();
        $quantity = $cart->sumItemsQuantity();

        // dd($items);

        return view('frontend.cart', compact(
            'items',
            'total',
            'subtotal',
            'action',
            'quantity',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $product = Product::find($request->product);

        if ($product->attributes()->count() > 0) {
            $productAttr = $product->attributes()->where('default', 1)->first();

            if (isset($productAttr->sale_price)) {
                $product->price = $productAttr->price;

                if (!is_null($productAttr->sale_price)) {
                    $product->price = $productAttr->sale_price;
                }
            }
        }

        $options = [];

        if ($request->has('productAttribute')) {
            $productAttribute = ProductAttribute::find($request->productAttribute);
            $attrValues = $productAttribute->attributesValues;
            $product->price = $productAttribute->price;

            if ($productAttribute->sale_price) {
                $product->price = $productAttribute->sale_price;
            }

            $options['product_attribute_id'] = $productAttribute->id;

            foreach ($attrValues as $value) {
                $attr = Attribute::find($value->attribute_id);
                $options[$attr->slug] = [
                    'value' => $value->value,
                    'code' => $value->code
                ];
            }

            // dd($options);
        }

        $cart = Cart::name('shopping');

        $cart->addItem([
            'model' => $product,
            'id' => $product->id,
            'title' => $product->name,
            'quantity' => $request->quantity,
            'price' => $product->price,
            'options' => $options,
        ]);

        return redirect()->route('cart.index')->withSuccess('Th??m v??o gi??? th??nh c??ng');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());

        try {
            $cart = Cart::name('shopping');

            $item = $cart
                ->updateItem($id, [
                    'quantity' => $request->get('quantity'),
                ])
                ->getDetails();

            $total = $cart->getTotal();
            $subtotal = $cart->getSubtotal();
            $count = $cart->sumItemsQuantity();

            // dd($item);

            return response()->json([
                'success' => true,
                'msg' => 'C???p nh???t gi??? h??ng th??nh c??ng!',
                'item_total' => number_format($item->total_price, 0) . '??',
                'cart_total' => number_format($total, 0) . '??',
                'cart_subtotal' => number_format($subtotal, 0) . '??',
                'cart_count' => number_format($count, 0),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Kh??ng th??? c???p nh???t gi??? h??ng, h??y th??? l???i!',
            ]);
        }
    }

    /**
     * Discount the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function discount(Request $request)
    {
        // dd($request->all());

        try {
            $cart = Cart::name('shopping');

            $cart->applyAction([
                'group'      => 'Discount',
                'id'         => 1,
                'title'      => 'Sale 10%',
                'value'      => '-10%',
            ]);

            return redirect()->route('cart.index')->withSuccess('Th??m v??o gi??? th??nh c??ng');
        } catch (\Exception $e) {
            return redirect()->route('cart.index')->withError('Th??m v??o gi??? th???t b???i');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart = Cart::name('shopping');
        $cart->removeItem($id);

        return redirect()->route('cart.index')->withSuccess('X??a s???n ph???m trong gi??? h??ng th??nh c??ng');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function clear()
    {
        $cart = Cart::name('shopping');
        $cart->clearItems();

        return redirect()->route('cart.index')->withSuccess('X??a gi??? h??ng th??nh c??ng');
    }
}
