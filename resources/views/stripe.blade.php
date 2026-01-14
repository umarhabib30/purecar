<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center mt-5">Stripe Payment Integration Example</h1>

    @if (Session::has('success'))
        <div class="alert alert-success text-center mt-3">
            {{ Session::get('success') }}
        </div>
    @endif

    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <form action="{{ route('stripe.post') }}" method="post" id="payment-form">
                @csrf

                <div class="form-group">
                    <label for="name">Name on Card</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" required>
                </div>

                <div class="form-group">
                    <label for="card-element">Credit or Debit Card</label>
                    <div id="card-element" class="form-control">
                    </div>
                    <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                </div>

                <button class="btn btn-primary btn-lg btn-block mt-3" type="submit">Pay Now ($100)</button>
            </form>
        </div>
    </div>
</div>

<script>
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');
    const elements = stripe.elements();
    const card = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                '::placeholder': {
                    color: '#aab7c4',
                },
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a',
            },
        },
    });
    card.mount('#card-element');
    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const { token, error } = await stripe.createToken(card);

        if (error) {
            const errorElement = document.getElementById('card-errors');
            errorElement.textContent = error.message;
        } else {
            const hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }
    });
</script>


</body>
</html>
