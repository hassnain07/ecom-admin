<div class="table-responsive">
    <table class="table table-bordered">
        <tr>
            <th>Customer Name</th>
            <td>{{ $order->customer_name }}</td>
        </tr>
        <tr>
            <th>Phone</th>
            <td>{{ $order->phone }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                @if($order->status == 'completed')
                    <span class="badge bg-success">Completed</span>
                @elseif($order->status == 'processing')
                    <span class="badge bg-warning">Processing</span>
                @elseif($order->status == 'cancel')
                    <span class="badge bg-danger">Canceled</span>
                @else
                    <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                @endif
            </td>
        </tr>
        <tr>
            <th>Total</th>
            <td>{{ number_format($order->total, 2) }}</td>
        </tr>
        <tr>
            <th>Store</th>
            <td>{{ $order->Details->first()->product->store->name ?? 'N/A' }}</td>
        </tr>
    </table>
</div>

<h6 class="mt-4">Order Items</h6>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Product</th>
                <th>Variation</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->Details as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                    <td>{{ $item->variation }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 2) }}</td>
                    <td>{{ number_format($item->quantity * $item->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>