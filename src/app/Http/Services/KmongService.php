<?php

namespace App\Http\Services;

use App\Contracts\OnlineShopContract;
use App\Models\KmongOrder;
use App\Models\KmongProduct;
use Illuminate\Database\Eloquent\Collection;

class KmongService implements OnlineShopContract
{
    /**
     * 상품을 주문합니다.
     *
     * @param integer $productId
     * @param integer $status
     * @return boolean
     */
    public function order(int $productId, int $status = KmongOrder::STATUS_ORDER_REQUEST): bool
    {
        if (!$this->getProduct($productId)) {
            return false;
        }

        $model = new KmongOrder();
        $model->member_id = auth()->id();
        $model->goods_id = $productId;
        $model->status = $status;

        return $model->save();
    }

    /**
     * 현재 회원의 주문리스트를 가져옵니다.
     *
     * @return Collection
     */
    public function orderList(): array
    {
        $result = [];
        $list = KmongOrder::where('member_id', auth()->id())
                ->get();

        foreach ($list as $order) {
            $pusher = $order->toArray();
            $pusher['status_translated'] = $order->getStatusText();

            // TODO 실제로 많은 수의 리스트를 가져올 때는 `JOIN`을 통해서 일괄적으로 상품의 정보를 가져오는게 좋습니다.
            // 해당 프로젝트에서는 과제의 특성을 갖고 있음에 성능적인 측면은 생략합니다.
            $pusher['product_info'] = $order->productInfo;

            $result[] = $pusher;
        }

        return $result;
    }

    /**
     * 상품 정보를 가져옵니다.
     *
     * @param integer $productId
     * @return nullable|KmongProduct
     */
    public function getProduct(int $productId): ?KmongProduct
    {
        return KmongProduct::where('display', KmongProduct::DISPLAY_SHOW)
                ->where('id', $productId)
                ->first();
    }
}
