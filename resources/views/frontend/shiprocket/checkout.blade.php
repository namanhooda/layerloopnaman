<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Shiprocket Checkout</title>

    <link rel="stylesheet"
          href="https://checkout-ui.shiprocket.com/assets/styles/shopify.css">
</head>
<body>

<button id="buyNow">Checkout</button>

<script src="https://checkout-ui.shiprocket.com/assets/js/channels/shopify.js"></script>

<script>

document.getElementById('buyNow').addEventListener('click', async function (event) {

    try {

        const response = await fetch('/shiprocket/token');

        const data = await response.json();

        console.log(data);

        if (!data.success) {
            alert('Unable to generate token');
            return;
        }

        HeadlessCheckout.addToCart(
            event,
            data.access_token,
            {
                fallbackUrl: "{{ url('/checkout') }}",
                isInitiatedFromApp: false
            }
        );

    } catch (err) {
        console.error(err);
        alert('Something went wrong');
    }

});

</script>

</body>
</html>