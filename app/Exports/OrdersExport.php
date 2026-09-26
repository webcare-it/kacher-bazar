<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $orderIds;

    function __construct($orderIds) {
        $this->orderIds = $orderIds;
    }

    public function collection()
    {
       return Order::with('orderDetails', 'admin')->whereIn('id', $this->orderIds)->get();

    }

    public function map($order) : array {
        foreach($order->orderDetails as $details){
            $productNames[] = $details->product->name;
        }
        $combinedProductNames = implode(', ', $productNames);
        return [
            'parcel',
            'salebaz.com',
            $order->orderId,
            $order->name,
            $order->phone,
            $order->pathao_city_name,
            $order->pathao_zone_name,
            '1',
            $order->address,
            $order->price,
            '1',
            '0.5',
            $combinedProductNames,
            $order->pathao_special_note,

        ] ;
    }

    public function headings() : array {
        return [
            'ItemType(*)',
            'StoreName(*)',
            'MerchantOrderId',
            'RecipientName(*)',
            'RecipientPhone(*)',
            'RecipientCity(*)',
            'RecipientZone(*)',
            'RecipientArea',
            'RecipientAddress(*)',
            'AmountToCollect(*)',
            'ItemQuantity(*)',
            'ItemWeight(*)',
            'ItemDesc',
            'SpecialInstruction',
        ];
    }
}
