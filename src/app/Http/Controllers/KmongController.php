<?php

namespace App\Http\Controllers;

use App\Contracts\OnlineShopContract;
use App\Http\Controllers\Traits\ResponseFormatGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KmongController extends Controller
{
    /**
     * 통일된 응답결과를 사용하기 위한 메소드가 포함돼 있습니다.
     */
    use ResponseFormatGenerator;

    private OnlineShopContract $onlineShop;

    /**
     * Construct
     *
     * @param OnlineShopContract $onlineShop
     */
    public function __construct(OnlineShopContract $onlineShop)
    {
        $this->onlineShop = $onlineShop;
    }

    /**
     * 주문을 실행합니다.
     *
     * @param Request $request
     * @return void
     */
    public function order(Request $request)
    {
        request()->validate([
            'product_id' => 'required|integer',
        ]);

        if (!$this->onlineShop->order($request->get('product_id'))) {
            return response()->json(
                $this->resformat(false, '주문 실패')
            );
        }

        return response()->json(
            $this->resformat(true, '주문 성공')
        );
    }

    /**
     * 상품 정보를 조회합니다.
     *
     * @param integer $productId
     * @return void
     */
    public function getProduct(int $productId)
    {
        $item = $this->onlineShop->getProduct($productId);

        return response()->json(
            $this->resformat((bool) $item, ['items' => $item])
        );
    }

    /**
     * 현재 세션의 주문내역을 가져옵니다.
     *
     * @return void
     */
    public function orderList()
    {
        return response()->json(
            $this->resformat(true, ['items' => $this->onlineShop->orderList()])
        );
    }
}
