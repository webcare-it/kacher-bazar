@extends('admin.master')

@push('style')
    <style type="text/css">
        .input-group-wrap {
            margin-bottom: 15px;
        }

        .input-group-wrap label {
            font-size: 15px;
            font-weight: 500;
            color: #000;
            margin-bottom: 3px;
        }

        .table td,
        .table th {
            vertical-align: middle;
            padding: 5px;
        }
    </style>
@endpush

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <form action="{{ url('/user/order/update/' . $order->id) }}" method="post" class="order-details-form form-group">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="customer-details-wrap card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <strong>Customer Details </strong>
                                {{-- <div>
                                @if ($order->status == 1)
                                    <a href="{{ url('/status/hold/' .$order?->id) }}" class="btn btn-sm btn-warning">Hold</a>
                                    <a href="{{ url('/status/complete/' .$order?->id) }}" class="btn btn-sm btn-success">Complete</a>
                                @elseif($order->status == 2)
                                    <a href="{{ url('/status/cancel/' .$order?->id) }}" class="btn btn-sm btn-secondary">Cancel</a>
                                    <a href="{{ url('/status/complete/' .$order?->id) }}" class="btn btn-sm btn-success">Complete</a>
                                @elseif($order->status == 3)
                                    <a href="{{ url('/order/pdf/'.$order->orderId) }}" class="btn btn-sm btn-success float-right">Invoice Download</a>
                                @else
                                    <a href="{{ url('/status/cancel/' .$order?->id) }}" class="btn btn-sm btn-secondary">Cancel</a>
                                    <a href="{{ url('/status/hold/' .$order?->id) }}" class="btn btn-sm btn-warning">Hold</a>
                                    <a href="{{ url('/status/complete/' .$order?->id) }}" class="btn btn-sm btn-success">Complete</a>
                                @endif
                            </div> --}}
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group-wrap">
                                            <label for="store">
                                                Store <span style="color: red;">*</span>
                                            </label>
                                            <input type="text" name="store" class="form-control" value="{{env('APP_NAME')}}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group-wrap">
                                            <label for="invoice">
                                                Invoice <span style="color: red;">*</span>
                                            </label>
                                            <input type="text" name="invoice" class="form-control"
                                                value="{{ $order->orderId ?? 'Orderid' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group-wrap">
                                            <label for="c_name">
                                                Customer Name <span style="color: red;">*</span>
                                            </label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ $order->name ?? 'Customer name' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group-wrap">
                                            <label for="c_phone">
                                                Customer Phone <span style="color: red;">*</span>
                                            </label>
                                            <input type="text" name="phone" class="form-control"
                                                value="{{ $order->phone ?? 'No phone' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-group-wrap">
                                            <label for="c_address">
                                                Customer Address <span style="color: red;">*</span>
                                            </label>
                                            <textarea class="form-control" rows="4" name="address">{{ $order->address ?? 'No address' }}</textarea>
                                            {{-- <input type="text" name="c_address" class="form-control" value="{{ $order->address ?? 'No address' }}"> --}}
                                        </div>
                                    </div>
                                    @if($order->notes)
                                    <div class="col-md-12">
                                        <div class="input-group-wrap">
                                            <label for="order_notes">
                                                Order Notes
                                            </label>
                                            <div class="form-control" style="background: #fff3cd; border-color: #ffc107; color: #856404;">
                                                {{ $order->notes }}
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-md-12">
                                        <div class="input-group-wrap">
                                            <label for="courier">
                                                Courier
                                            </label>
                                            <select name="courier" id="courier" class="form-control">
                                                <option selected disabled>-- Select Courier --</option>
                                                <option value="Steadfast" @if ($order->courier_name === 'Steadfast') selected @endif>
                                                    Steadfast</option>
                                                <option value="Pathao" @if ($order->courier_name === 'Pathao') selected @endif>
                                                    Pathao</option>
                                                <option value="Others" @if ($order->courier_name === 'Others') selected @endif>
                                                    Others</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="textareaWrapper" style="display: none;">
                                        <div class="input-group-wrap">
                                            <label for="otherCourierDetails">
                                                Other Courier Details
                                            </label>
                                            <textarea name="otherCourierDetails" id="otherCourierDetails" class="form-control">{{ $order->otherCourierDetails }}</textarea>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-12" id="cityZoneWrapper">
                                    <div class="input-group-wrap">
                                        <label for="city">
                                            City
                                        </label>
                                        <select name="city" id="city" class="form-control">
                                            <option selected disabled>-- Select City --</option>
                                            @foreach ($cities->data as $city)
                                            <option value="{{ $city->city_id }}" @if ($order->pathao_city_id == $city->city_id) selected @endif>{{ $city->city_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="hidden" name="city_name" id="city_name">
                                </div>
                                <div class="col-md-12" id="ZoneWrapper">
                                    <div class="input-group-wrap">
                                        <label for="zone">
                                            Zone
                                        </label>
                                        <select name="zone" id="zone" class="form-control">
                                            <option selected disabled>-- Select Zone --</option>
                                            @if ($order->pathao_zone_id != null)
                                            <option value="{{$order->pathao_zone_id}}" selected>{{$order->pathao_zone_name}}</option>
                                            @endif
                                        </select>
                                    </div>
                                    <input type="hidden" name="zone_name" id="zone_name" value="{{$order->pathao_zone_name}}">
                                </div> --}}
                                    <div class="col-md-12">
                                        <div class="input-group-wrap">
                                            <label for="pathao_special_note">
                                                Special Notes
                                            </label>
                                            <textarea class="form-control" rows="4" name="pathao_special_note">{{ $order->pathao_special_note ?? 'No Notes' }}</textarea>
                                            @if ($order->order_type == 'Dropshipping')
                                                <input type="text" name="steadfast_notes" value="প্রথমে এই সাব মার্চেন্ট
                                            নাম্বারে কল করবেন
                                            {{ $order->dropshipper->phone }} যদি এই
                                            নাম্বারে সমাধান না পাওয়া যায়
                                            তাহলে মার্চেন্ট নাম্বারে কল করবেন" readonly>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="order-details-wrap card">
                            <div class="card-header">
                                <strong>Order Details</strong>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th style="width: 20%;">Name</th>
                                        <th style="width: 10%;">Color</th>
                                        <th style="width: 10%;">Size</th>
                                        <th style="width: 10%;">Qty</th>
                                        <th style="width: 10%;">Unit Price</th>
                                        <th style="width: 10%;">Total Price</th>
                                        <th style="width: 20%;">Notes</th>
                                        <th style="width: 5%;">Action</th>
                                    </tr>
                                    @php
                                        $sum = 0;
                                    @endphp
                                    @foreach ($order->orderDetails as $orderDetail)
                                        <tr>
                                            <td>
                                                <img src="{{ asset('/product/images/' . $orderDetail->product?->image) }}"
                                                    height="40" width="40" /><br>
                                                {{ $orderDetail->product?->name ?? 'Product name' }}
                                            </td>
                                            @php
                                                    $colorVariations = App\Models\ProductColor::where('product_id', $orderDetail->product_id)->get();
                                                    $sizeVariations = App\Models\ProductSize::where('product_id', $orderDetail->product_id)->get();
                                                    @endphp
                                            <td>
                                                <select class="form-control" name="color"
                                                    id="color-{{ $orderDetail?->id }}"
                                                    onchange="productColor({{ $orderDetail }})">
                                                    @if ($orderDetail->color == null || $orderDetail->color == 'No color')
                                                        <option selected disabled>No Color</option>
                                                        @foreach ($colorVariations as $color)
                                                            <option value="{{ $color->color }}">{{ $color->color }}
                                                            </option>
                                                        @endforeach
                                                    @else
                                                        @foreach ($colorVariations as $color)
                                                            <option value="{{ $color->color }}"
                                                                {{ $color->color == $orderDetail->color ? 'selected' : '' }}>
                                                                {{ $color->color }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" name="size"
                                                    id="size-{{ $orderDetail?->id }}"
                                                    onchange="productSize({{ $orderDetail }})">
                                                    @foreach ($sizeVariations as $size)
                                                        <option value="{{ $size->size }}"
                                                                {{ $size->size == $orderDetail->size ? 'selected' : '' }}>
                                                                {{ $size->size }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge rounded-pill bg-primary">{{ $totalProductQty = $orderDetail?->qty }}</span>
                                                <input type="number" name="qty" id="qty-{{ $orderDetail?->id }}"
                                                    onblur="productQty({{ $orderDetail }})" value=""
                                                    placeholder="Qty" style="width:80px;" />
                                            </td>
                                            <td>
                                                <input type="number" name="regular_price"
                                                    id="regular_price-{{ $orderDetail?->id }}"
                                                    onblur="productPrice({{ $orderDetail }})"
                                                    value="{{ $total = $orderDetail->price }}"
                                                    class="form-control" />
                                            </td>
                                            <td>
                                                <input type="number" name=""
                                                    id="regular_price-{{ $orderDetail?->id }}"
                                                    onblur="productPrice({{ $orderDetail }})"
                                                    value="{{ $orderDetail->price * $orderDetail->qty }}"
                                                    class="form-control" readonly />
                                            </td>
                                            <td>
                                                <input type="text" name="notes" id="notes-{{ $orderDetail?->id }}" value="{{ $orderDetail->notes }}" class="form-control" readonly/>
                                            </td>
                                            <td>
                                                <a href="{{ url('/order/delete/' . $orderDetail->id) }}"
                                                    class="btn btn-sm btn-danger delete-btn">
                                                    <i class="bx bx-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @php
                                            $sum += $total * $orderDetail->qty;
                                        @endphp
                                        <input class="form-control" type="hidden" name="per_price" id="per_price"
                                            value="{{ $orderDetail->price ?? 'price' }}">
                                    @endforeach
                                </table>
                                <label
                                    style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Related
                                    Product</label>
                                <select class="form-control mb-3 select2" name="related_product_id">
                                    <option value="AL">Select A Related Product</option>
                                    @foreach (\App\Models\Product::orderBy('created_at', 'desc')->get() as $product)
                                        <option value="{{ $product->id }}">
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="mt-3 mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Sub Total</strong>
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" type="number" readonly name="price"
                                                id="sub_total" value="{{ $sum }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Delivery Charge</strong>
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" type="number" name="area" id="area"
                                                value="{{ $area = $order->area }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Charge Type</strong>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="delivery_charge_type" id="delivery_charge_type"
                                                class="form-control" required>
                                                <option selected disabled>-- Select delivery charge type --</option>
                                                <option value="COD" @if ($order->delivery_charge_type == 'COD') selected @endif>
                                                    COD</option>
                                                <option value="Advance" @if ($order->delivery_charge_type == 'Advance') selected @endif>
                                                    Advance</option>
                                                <option value="Others" @if ($order->delivery_charge_type == 'Others') selected @endif>
                                                    Others</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Discount</strong>
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="discount"
                                                onkeyup="orderDiscount(this.value)" id="discount"
                                                value="{{ $order->discount ?? 0 }}" placeholder="Enter Discount Price">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Advance</strong>
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="advance"
                                                onkeyup="orderAdvance(this.value)" id="advance"
                                                value="{{ $order->advance ?? 0 }}" placeholder="Enter Advance Price">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Total</strong>
                                        </div>
                                        <div class="col-md-6">
                                            @if ($order->discount != null && $order->advance == null)
                                                <input class="form-control total_price" type="text" name="total_price"
                                                       id="total_price" value="{{ (float) $sum + (float) $area - (float) $order->discount }}">
                                            @endif

                                            @if ($order->discount != null && $order->advance != null)
                                                @php
                                                    $x = (float) $sum + (float) $area;
                                                    $y = $x - (float) $order->discount;
                                                    $z = $y - (float) $order->advance;
                                                @endphp
                                                <input class="form-control total_price" type="text" name="total_price"
                                                       id="total_price" value="{{ $z }}">
                                            @endif

                                            @if ($order->advance == null && $order->discount == null)
                                                <input class="form-control total_price" type="text" name="total_price"
                                                       id="total_price" value="{{ (float) $sum + (float) $area }}">
                                            @endif

                                            @if ($order->advance != null && $order->discount == null)
                                                <input class="form-control total_price" type="text" name="total_price"
                                                       id="total_price" value="{{ (float) $order->price }}">
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <hr />
                                @if ($order->order_type == 'dropshipping' || $order->order_type == 'Dropshipping')
                                    <div class="mt-3 mb-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Charge</strong>
                                            </div>
                                            <div class="col-md-6">
                                                <input class="form-control total_price" type="text" name="area"
                                                    id="" value="{{ $order->area }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3 mb-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Payment Gateway</strong>
                                            </div>
                                            <div class="col-md-6">
                                                <input class="form-control total_price" type="text" name=""
                                                    id="" value="{{ $order->payment_gateway ?? '' }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3 mb-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Transaction ID</strong>
                                            </div>
                                            <div class="col-md-6">
                                                <input class="form-control total_price" type="text" name=""
                                                    id="" value="{{ $order->transaction_id ?? 0 }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer text-center">
                                <button type="submit" id="submit" class="btn btn-primary btn-sm">Update
                                    Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let orderId = {{ $order->id }};

        function deliveryCharge(e) {
            axios.post('/api/order/delivery/charge/update/' + orderId, {
                    area: e
                })
                .then(response => {
                    if (response.status == 200) {
                        //alert('Delivery charge has been updated.')
                        location.reload()
                    }
                }).catch(error => {
                    return confirm('Something is wrong, Please try again')
                })
        }

        function productPrice(orderDetailPrice) {
            let price = document.getElementById('regular_price-' + orderDetailPrice.id).value;
            axios.post('/api/order/price/update/' + orderDetailPrice.id, {
                    regular_price: price
                })
                .then(response => {
                    if (response.status == 200) {
                        //alert('Order Price has been updated.')
                        location.reload()
                    }
                }).catch(error => {
                    return confirm('Something is wrong, Please try again')
                })
        }

        function productQty(orderDetail) {
            let qty = document.getElementById('qty-' + orderDetail.id).value;
            axios.post('/api/order/product/qty/update/' + orderDetail.id, {
                    qty: qty
                })
                .then(response => {
                    if (response.status == 200) {
                        //alert('Qty has been updated.')
                        location.reload()
                    }
                }).catch(error => {
                    return confirm('Something is wrong, Please try again')
                })
        }

        function productColor(orderDetail) {
            let color = document.getElementById('color-' + orderDetail.id).value;
            axios.post('/api/order/product/color/update/' + orderDetail.id, {
                    color: color
                })
                .then(response => {
                    if (response.status == 200) {
                        Swal.fire('Product color has been updated')
                    }
                }).catch(error => {
                    Swal.fire('Something is wrong, Please try again')
                })
        }

        function productSize(orderDetail) {
            let size = document.getElementById('size-' + orderDetail.id).value;
            axios.post('/api/order/product/size/update/' + orderDetail.id, {
                    size: size
                })
                .then(response => {
                    if (response.status == 200) {
                        Swal.fire('Product size has been updated')
                    }
                }).catch(error => {
                    Swal.fire('Something is wrong, Please try again')
                })
        }
        let totalCost = document.getElementById('total_price').value;
        let showCost = document.getElementById('total_price');

        function orderAdvance(advance) {
            let afterAdvanceCost = parseInt(totalCost) - parseInt(advance);
            showCost.value = afterAdvanceCost;
        }

        let totalCostForDiscount = document.getElementById('total_price').value;
        let showDiscountCost = document.getElementById('total_price');

        function orderDiscount(discount) {
            let afterDiscountCost = parseInt(totalCostForDiscount) - parseInt(discount);
            showDiscountCost.value = afterDiscountCost;
        }

        //Code for fetching zone list....
        document.addEventListener("DOMContentLoaded", function() {
            const citySelect = document.getElementById("city");
            const zoneSelect = document.getElementById("zone");

            citySelect.addEventListener("change", function() {
                const selectedCityId = this.value;
                if (selectedCityId) {
                    fetch(`/get-zones/${selectedCityId}`)
                        .then(response => response.json())
                        .then(data => {
                            const zonesData = data.zones.data;

                            // Clear existing options
                            zoneSelect.innerHTML =
                                '<option selected disabled>-- Select Zone --</option>';

                            // Add new zone options
                            zonesData.forEach(zone => {
                                const option = document.createElement("option");
                                option.value = zone.zone_id;
                                option.textContent = zone.zone_name;
                                zoneSelect.appendChild(option);
                            });
                        })
                        .catch(error => console.error(error));
                } else {
                    // Reset zone select if no city is selected
                    zoneSelect.innerHTML = '<option selected disabled>-- Select Zone --</option>';
                }
            });
        });
        //Code for fetching zone list....

        //Code For set city_name in input field...

        const citySelect = document.getElementById('city');
        const cityInput = document.getElementById('city_name');

        citySelect.addEventListener('change', function() {
            const selectedOption = citySelect.options[citySelect.selectedIndex];
            cityInput.value = selectedOption.text;
        });
        //Code For set city_name in input field...

        //Code For set zone_name in input field...

        const zoneSelect = document.getElementById('zone');
        const zoneInput = document.getElementById('zone_name');

        zoneSelect.addEventListener('change', function() {
            const selectedOption = zoneSelect.options[zoneSelect.selectedIndex];
            zoneInput.value = selectedOption.text;
        });
        //Code For set zone_name in input field...

        //If Courier is Othres then City & Zone Will be hidden...
        const courierSelect = document.getElementById('courier');
        const cityZoneWrapper = document.getElementById('cityZoneWrapper');
        const ZoneWrapper = document.getElementById('ZoneWrapper');
        const textareaWrapper = document.getElementById('textareaWrapper');

        courierSelect.addEventListener('change', function() {
            if (courierSelect.value === 'Others') {
                cityZoneWrapper.style.display = 'none';
                ZoneWrapper.style.display = 'none';
                textareaWrapper.style.display = 'block';
            } else {
                cityZoneWrapper.style.display = 'block';
                ZoneWrapper.style.display = 'block';
                textareaWrapper.style.display = 'none';
            }
        });
        //If Courier is Othres then City & Zone Will be hidden...

        if (courierSelect.value === 'Others') {
            cityZoneWrapper.style.display = 'none';
            ZoneWrapper.style.display = 'none';
            textareaWrapper.style.display = 'block';
        }
    </script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select A Related Product", // Optional placeholder
                allowClear: true // Enables clearing the selection
            });
        });
    </script>
@endpush
