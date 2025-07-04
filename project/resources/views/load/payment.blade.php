@php

$pay_data = $gateway->convertAutoData();

@endphp

@if($payment == 'cod')

<input type="hidden" name="method" value="{{ $gateway->title }}">

@endif

@if($payment == 'payincredit')

<input type="hidden" name="method" value="{{ $gateway->title }}">
<div class="col-lg-12">
    <div class="input-wrapper">
      {{-- <label class="label-cls" for="cardNumbera">@lang('Card Number')</label>
      <input class="input-cls card-elements" autocomplete="off" autofocus oninput="validateCard(this.value);"
        id="cardNumbera" name="cardNumber" type="text" placeholder="@lang('Card Number')">
      <span id="errCard"></span> --}}
      <div id="pay-warning"></div>
      <div class="form-group">
        <label for="payment_time" class="form-label">Payment Time</label>
        <select name="payment_time" id="payment_time" class="form-control">
          <option selected disabled>Select Time</option>
          <option value="days_7">Within 7 Days</option>
          <option value="days_7_30">Within 30 Days</option>
        </select>
      </div>
    </div>
  </div>
</div>

@endif

@if($payment == 'paypal')

<input type="hidden" name="method" value="{{ $gateway->name }}">

@endif

@if($payment == 'instamojo')

<input type="hidden" name="method" value="{{ $gateway->name }}">

@endif

@if($payment == 'razorpay')

<input type="hidden" name="method" value="{{ $gateway->name }}">

@endif

@if($payment == 'paytm')

<input type="hidden" name="method" value="{{ $gateway->name }}">

@endif


@if($payment == 'sslcommerz')

<input type="hidden" name="method" value="{{ $gateway->name }}">

@endif

@if($payment == 'flutterwave')

<input type="hidden" name="method" value="{{ $gateway->name }}">

@endif

@if($payment == 'paystack')

<input type="hidden" name="txnid" id="ref_id" value="">
<input type="hidden" name="sub" id="sub" value="0">
<input type="hidden" name="method" value="{{ $gateway->name }}">

@endif

@if($payment == 'voguepay')

<input type="hidden" name="txnid" id="ref_id" value="">
<input type="hidden" name="sub" id="sub" value="0">
<input type="hidden" name="method" value="{{ $gateway->name }}">

@endif

@if($payment == 'mollie')

<input type="hidden" name="method" value="{{ $gateway->name }}">

@endif

@if($payment == 'authorize.net')

<div class="row">

  <input class="d-none" type="hidden" name="method" value="{{ $gateway->name }}">


  <div class="col-lg-6">
    <div class="input-wrapper">
      <label class="label-cls" for="cardNumbera">@lang('Card Number')</label>
      <input class="input-cls card-elements" autocomplete="off" autofocus oninput="validateCard(this.value);"
        id="cardNumbera" name="cardNumber" type="text" placeholder="@lang('Card Number')">
      <span id="errCard"></span>
    </div>
  </div>


  <div class="col-lg-6">
    <div class="input-wrapper">
      <label class="label-cls" for="cardCode">@lang('Card Code')</label>
      <input class="input-cls card-elements" autocomplete="off" oninput="validateCVC(this.value);" id="cardCode"
        name="cardCode" type="text" placeholder="@lang('Card Code')">
      <span id="errCVC"></span>
    </div>
  </div>


  <div class="col-lg-6">
    <div class="input-wrapper">
      <label class="label-cls" for="month">@lang('Month')</label>
      <input class="input-cls card-elements" autocomplete="off" id="month" name="month" type="text"
        placeholder="@lang('Month')">
    </div>
  </div>


  <div class="col-lg-6">
    <div class="input-wrapper">
      <label class="label-cls" for="year">@lang('Year')</label>
      <input class="input-cls card-elements" autocomplete="off" id="year" name="year" type="text"
        placeholder="@lang('Year')">
    </div>
  </div>
</div>







<script type="text/javascript">
  var cnstatus = false;
  var dateStatus = false;
  var cvcStatus = false;

  function validateCard(cn) {
    "use strict";
    cnstatus = Stripe.card.validateCardNumber(cn);
    if (!cnstatus) {
      $("#errCard").html('{{ __("Card number not valid") }}');
    } else {
      $("#errCard").html('');
    }
  }

  function validateCVC(cvc) {
    "use strict";
    cvcStatus = Stripe.card.validateCVC(cvc);
    if (!cvcStatus) {
      $("#errCVC").html('{{ __("CVC number not valid") }}');
    } else {
      $("#errCVC").html('');
    }

  }



</script>


@endif



@if ($gateway->keyword == 'mercadopago')

@php
$paydata = $gateway->convertAutoData();
@endphp

<div id="cardNumber"></div>
<div id="expirationDate"></div>
<div id="securityCode"> </div>


<div class="form-group pb-2">
  <input class="form-control" type="text" id="cardholderName" data-checkout="cardholderName"
    placeholder="{{ __('Card Holder Name') }}" required />
</div>
<div class="form-group py-2">
  <input class="form-control" type="text" id="docNumber" data-checkout="docNumber"
    placeholder="{{ __('Document Number') }}" required />
</div>
<div class="form-group py-2">
  <select id="docType" class="form-control" name="docType" data-checkout="docType" type="text"></select>
</div>




<script>
  var mp = new MercadoPago("{{ $paydata['public_key'] }}");
  var cardNumberElement = mp.fields.create('cardNumber', {
    placeholder: "Card Number"
  }).mount('cardNumber');

  var expirationDateElement = mp.fields.create('expirationDate', {
    placeholder: "MM/YY",
  }).mount('expirationDate');

  var securityCodeElement = mp.fields.create('securityCode', {
    placeholder: "Security Code"
  }).mount('securityCode');


  (async function getIdentificationTypes() {
    try {
      var identificationTypes = await mp.getIdentificationTypes();

      var identificationTypeElement = document.getElementById('docType');

      createSelectOptions(identificationTypeElement, identificationTypes);

    } catch (e) {
      return console.error('Error getting identificationTypes: ', e);
    }
  })();

  function createSelectOptions(elem, options, labelsAndKeys = {
    label: "name",
    value: "id"
  }) {

    var {
      label,
      value
    } = labelsAndKeys;


    var tempOptions = document.createDocumentFragment();

    options.forEach(option => {
      var optValue = option[value];
      var optLabel = option[label];

      var opt = document.createElement('option');
      opt.value = optValue;
      opt.textContent = optLabel;


      tempOptions.appendChild(opt);
    });

    elem.appendChild(tempOptions);
  }
  cardNumberElement.on('binChange', getPaymentMethods);
  async function getPaymentMethods(data) {
    var {
      bin
    } = data
    var {
      results
    } = await mp.getPaymentMethods({
      bin
    });
    console.log(results);
    return results[0];
  }

  async function getIssuers(paymentMethodId, bin) {
    var issuears = await mp.getIssuers({
      paymentMethodId,
      bin
    });

    return issuers;
  };

  async function getInstallments(paymentMethodId, bin) {
    var installments = await mp.getInstallments({
      amount: document.getElementById('transactionAmount').value,
      bin,
      paymentTypeId: 'credit_card'
    });

  };

  async function createCardToken() {
    var token = await mp.fields.createCardToken({
      cardholderName,
      identificationType,
      identificationNumber,
    });

  }
  var doSubmit = false;
  $(document).on('submit', '#mercadopago', function (e) {
    getCardToken();
    e.preventDefault();
  });
  async function getCardToken() {
    if (!doSubmit) {
      let $form = document.getElementById('mercadopago');
      var token = await mp.fields.createCardToken({
        cardholderName: document.getElementById('cardholderName').value,
        identificationType: document.getElementById('docType').value,
        identificationNumber: document.getElementById('docNumber').value,
      })
      setCardTokenAndPay(token.id)
    }
  };

  function setCardTokenAndPay(token) {
    let form = document.getElementById('mercadopago');
    let card = document.createElement('input');
    card.setAttribute('name', 'token');
    card.setAttribute('type', 'hidden');
    card.setAttribute('value', token);
    form.appendChild(card);
    doSubmit = true;
    form.submit();
  };
</script>
@endif


@if($payment == 'other')

<input type="hidden" name="method" value="{{ $gateway->title }}">

<div class="row">

  <div class="col-lg-12 pb-2">

    {!! clean($gateway->details , array('Attr.EnableID' => true)) !!}

  </div>


  <div class="col-lg-6">
    <label>{{ __('Transaction ID#') }} *</label>
    <input class="form-control" name="txnid" type="text" required="" placeholder="{{ __('Transaction ID#') }}" />
  </div>

</div>

@endif