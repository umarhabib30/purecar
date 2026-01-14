<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stripe Payment</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @elseif ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('payment.process') }}" method="POST" id="payment-form">
        @csrf
        <div>
            <label for="card-element">Credit or debit card</label>
            <div id="card-element"></div>
            <div id="card-errors" role="alert"></div>
        </div>
        <button type="submit" id="submit">Pay</button>
    </form>

    <script>
        var stripe = Stripe('{{ $stripeKey }}');
        var elements = stripe.elements();
        var card = elements.create('card');
        card.mount('#card-element');

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            stripe.createToken(card).then(function (result) {
                if (result.error) {
                    document.getElementById('card-errors').textContent = result.error.message;
                } else {
                    stripeTokenHandler(result.token);
                }
            });
        });

        var form = document.getElementById('payment-form');
var submitButton = document.getElementById('submit');

form.addEventListener('submit', function(event) {
    event.preventDefault();
    submitButton.textContent = 'Processing...';

    stripe.createToken(card).then(function(result) {
        if (result.error) {
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
            submitButton.textContent = 'Pay'; // Reset button text
        } else {
            stripeTokenHandler(result.token);
        }
    });
});

function stripeTokenHandler(token) {
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);

    form.submit(); // Submit the form
}

    </script>
</body>
</html>
