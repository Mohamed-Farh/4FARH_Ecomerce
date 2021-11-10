<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PaymentMethodRequest;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability('superAdmin', 'manage_payment_methods,show_payment_methods')){
            return redirect('admin/index');
        }

        $payment_methods = PaymentMethod::query()
            ->when(\request()->keyword != '', function ($q){
                $q->search(\request()->keyword);
            })
            ->when(\request()->status != '', function ($q){
                $q->whereStatus(\request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);
        return view('backend.payment_methods.index', compact('payment_methods'));
    }

    public function create()
    {
        if (!auth()->user()->ability('superAdmin', 'create_payment_methods')){
            return redirect('admin/index');
        }

        return view('backend.payment_methods.create');
    }

    public function store(PaymentMethodRequest $request)
    {
        if (!auth()->user()->ability('superAdmin', 'create_payment_methods')){
            return redirect('admin/index');
        }

        PaymentMethod::create($request->validated());

        return redirect()->route('admin.payment_methods.index')->with([
            'message'    => 'Payment Method Created Successfully',
            'alert-type' => 'success'
        ]);

    }

    public function show(PaymentMethod $payment_method)
    {
        if (!auth()->user()->ability('superAdmin', 'display_payment_methods')){
            return redirect('admin/index');
        }
        return view('backend.payment_methods.show', compact('payment_method'));
    }

    public function edit(PaymentMethod $payment_method)
    {
        if (!auth()->user()->ability('superAdmin', 'update_payment_methods')){
            return redirect('admin/index');
        }

        return view('backend.payment_methods.edit', compact('payment_method'));
    }

    public function update(PaymentMethodRequest $request, PaymentMethod $payment_method)
    {

        if (!auth()->user()->ability('superAdmin', 'update_payment_methods')){
            return redirect('admin/index');
        }

        $payment_method->update($request->validated());
        dd($payment_method);
        return redirect()->route('admin.payment_methods.index')->with([
            'message'    => 'Payment Method Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    public function destroy(PaymentMethod $payment_method)
    {
        if (!auth()->user()->ability('superAdmin', 'delete_payment_methods')){
            return redirect('admin/index');
        }

        $payment_method->delete();

        return redirect()->route('admin.payment_methods.index')->with([
            'message'    => 'Payment Method Deleted Successfully',
            'alert-type' => 'success'
        ]);
    }
}
