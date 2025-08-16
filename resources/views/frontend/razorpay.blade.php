<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var options = {
        "key": "{{ $razorpayKey }}",
        "amount": "{{ $amount * 100 }}",
        "currency": "INR",
        "name": "{{ config('app.name') }}",
        "description": "Order Payment",
        "order_id": "{{ $razorpayOrder['id'] }}",
        "handler": function (response){
            // POST to your server to verify and mark paid
            window.location.href = "{{ route('order.payment.verify') }}?payment_id=" + response.razorpay_payment_id + "&order_id={{ $order->id }}";
        },
        "prefill": {
            "name": "{{ $user->name ?? '' }}",
            "email": "{{ $user->email ?? '' }}"
        },
        "theme": {
            "color": "#3399cc"
        }
    };
    var rzp = new Razorpay(options);
    rzp.open();
</script>
