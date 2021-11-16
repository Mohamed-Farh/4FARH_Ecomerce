<?php

namespace App\Http\Livewire\Frontend;

use App\Models\PaymentMethod;
use App\Models\ProductCopon;
use App\Models\ShippingCompany;
use App\Models\UserAddress;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CheckoutComponent extends Component
{
    use LivewireAlert;

    public $cart_subtotal;
    public $cart_tax;
    public $cart_total;
    public $cart_copon;
    public $cart_shipping;
    public $cart_discount;
    public $copon_code;
    public $addresses;
    public $customer_address_id = 0;
    public $shipping_companies;
    public $shipping_company_id = 0;
    public $payment_methods;
    public $payment_method_id = 0;
    public $payment_method_code;

    protected $listeners = [
        'updateCart' => 'mount'
    ];

    public function mount()
    {
        $this->customer_address_id = session()->has('saved_customer_address_id') ? session()->get('saved_customer_address_id') : '';
        $this->shipping_company_id = session()->has('saved_shipping_company_id') ? session()->get('saved_shipping_company_id') : '';
        $this->payment_method_id = session()->has('saved_payment_method_id') ? session()->get('saved_payment_method_id') : '';

        $this->addresses = auth()->user()->addresses;

        $this->cart_subtotal = getNumbers()->get('subtotal');
        $this->cart_tax = getNumbers()->get('productTaxes');
        $this->cart_discount = getNumbers()->get('discount');
        $this->cart_shipping = getNumbers()->get('shipping');
        $this->cart_total = getNumbers()->get('total');
        if ($this->customer_address_id == '') {
            $this->shipping_companies = collect([]);
        } else {
            $this->updateShippingCompanies();
        }
        $this->payment_methods = PaymentMethod::whereStatus('1')->get();
    }

    public function applyDiscount()
    {
        if (getNumbers()->get('subtotal') > 0) {
            $copon = ProductCopon::whereCode($this->copon_code)->whereStatus('1')->first();
            if(!$copon) {
                $this->cart_copon = '';
                $this->alert('error', 'copon is invalid!');
            } else {
                $coponValue = $copon->discount($this->cart_subtotal);
                if ($coponValue > 0) {
                    session()->put('copon', [
                        'code' => $copon->code,
                        'value' => $copon->value,
                        'discount' => $coponValue,
                    ]);
                    $this->copon_code = session()->get('copon')['code'];
                    $this->emit('updateCart');

                    $this->alert('success', 'copon is applied successfully');
                } else {
                    $this->alert('error', 'product copon is invalid');
                }

            }

        } else {
            $this->cart_copon = '';
            $this->alert('error', 'No products available in your cart');
        }
    }

    public function removecopon()
    {
        session()->remove('copon');
        $this->copon_code = '';
        $this->emit('updateCart');
        $this->alert('success', 'Copon Is Removed');
    }

    public function updateShippingCompanies()
    {
        $addressCounty = UserAddress::whereId($this->customer_address_id)->first();
        $this->shipping_companies = ShippingCompany::whereHas('countries', function ($query) use ($addressCounty) {
            $query->where('country_id', $addressCounty->country_id);
        })->get();
    }

    public function updatingCustomerAddressId()
    {
        session()->forget('saved_customer_address_id');
        session()->forget('saved_shipping_company_id');
        session()->forget('shipping');
        session()->put('saved_customer_address_id', $this->customer_address_id);

        $this->customer_address_id = session()->has('saved_customer_address_id') ? session()->get('saved_customer_address_id') : '';
        $this->shipping_company_id = session()->has('saved_shipping_company_id') ? session()->get('saved_shipping_company_id') : '';
        $this->payment_method_id = session()->has('saved_payment_method_id') ? session()->get('saved_payment_method_id') : '';
        $this->emit('updateCart');
    }

    public function updatedCustomerAddressId()
    {
        session()->forget('saved_customer_address_id');
        session()->forget('saved_shipping_company_id');
        session()->forget('shipping');
        session()->put('saved_customer_address_id', $this->customer_address_id);

        $this->customer_address_id = session()->has('saved_customer_address_id') ? session()->get('saved_customer_address_id') : '';
        $this->shipping_company_id = session()->has('saved_shipping_company_id') ? session()->get('saved_shipping_company_id') : '';
        $this->payment_method_id = session()->has('saved_payment_method_id') ? session()->get('saved_payment_method_id') : '';
        $this->emit('updateCart');
    }

    public function updatingShippingCompanyId()
    {
        session()->forget('saved_shipping_company_id');
        session()->put('saved_shipping_company_id', $this->customer_address_id);

        $this->customer_address_id = session()->has('saved_customer_address_id') ? session()->get('saved_customer_address_id') : '';
        $this->shipping_company_id = session()->has('saved_shipping_company_id') ? session()->get('saved_shipping_company_id') : '';
        $this->payment_method_id = session()->has('saved_payment_method_id') ? session()->get('saved_payment_method_id') : '';
        $this->emit('updateCart');
    }

    public function updatedShippingCompanyId()
    {
        session()->forget('saved_shipping_company_id');
        session()->put('saved_shipping_company_id', $this->shipping_company_id);

        $this->customer_address_id = session()->has('saved_customer_address_id') ? session()->get('saved_customer_address_id') : '';
        $this->shipping_company_id = session()->has('saved_shipping_company_id') ? session()->get('saved_shipping_company_id') : '';
        $this->payment_method_id = session()->has('saved_payment_method_id') ? session()->get('saved_payment_method_id') : '';
        $this->emit('updateCart');
    }

    public function updateShippingCost()
    {
        $selectedShippingCompany = ShippingCompany::whereId($this->shipping_company_id)->first();
        session()->put('shipping', [
            'code' => $selectedShippingCompany->code,
            'cost' => $selectedShippingCompany->cost,
        ]);
        $this->emit('updateCart');
        $this->alert('success', 'Shipping cost is applied successfully');
    }

    public function updatePaymentMethod()
    {
        $payment_method = PaymentMethod::whereId($this->payment_method_id)->first();
        $this->payment_method_code = $payment_method->code;
    }

    public function render()
    {
        return view('livewire.frontend.checkout-component');
    }
}

