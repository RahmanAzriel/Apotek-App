<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::with('user')->orderBy('created_at', 'DESC')->get();
    }


    public function headings(): array
    {
        return [
            'ID',
            'Cashier ',
            'Medicines',
            'Buyer',
            'Total Price',
            'Date',
        ];
    }

    public function map($order): array
    {
        $daftarObat = "";
        foreach ($order->medicines as $key => $value) {
            $obat = $key+1 . ". " . $value['name_medicine'] . " ( " . $value['qty'] . " Pcs) $. " . number_format($value['total_price'], 2, '.', ',') . ",";
            $daftarObat .= $obat;
        }
        return [
            $order->id,
            $order->user->name,
            $daftarObat,
            $order->name_customer,
            "$ " . number_format($order->total_price, 2, '.', ','),
            $order->created_at->isoFormat('dddd, D MMMM Y HH:mm:ss')
        ];
    }
}
