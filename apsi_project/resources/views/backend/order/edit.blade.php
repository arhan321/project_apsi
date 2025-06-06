@extends('backend.layouts.master')

@section('title','Order Detail')

@section('main-content')
<div class="card">
  <h5 class="card-header">Order Edit</h5>
  <div class="card-body">
    <form action="{{route('order.update',$order->id)}}" method="POST">
      @csrf
      @method('PATCH')
      <div class="form-group">
        <label for="status">Status kirim :</label>
        <select name="status" id="status" class="form-control">
          <option value="new" {{($order->status=='delivered' || $order->status=="process" || $order->status=="cancel" || $order->status=="sent") ? 'disabled' : ''}} {{(($order->status=='new')? 'selected' : '')}}>New</option>
          <option value="process" {{($order->status=='delivered' || $order->status=="cancel" || $order->status=="sent") ? 'disabled' : ''}} {{(($order->status=='process')? 'selected' : '')}}>Process</option>
          <option value="delivered" {{($order->status=="cancel" || $order->status=="sent") ? 'disabled' : ''}} {{(($order->status=='delivered')? 'selected' : '')}}>Delivered</option>
          <option value="cancel" {{($order->status=='delivered' || $order->status=="sent") ? 'disabled' : ''}} {{(($order->status=='cancel')? 'selected' : '')}}>Cancel</option>
          <option value="sent" {{($order->status=='delivered') ? 'disabled' : ''}} {{(($order->status=='sent')? 'selected' : '')}}>Sent</option>
        </select>
      </div>

      <div class="form-group">
        <label for="payment_status">Payment Status :</label>
        <select name="payment_status" id="payment_status" class="form-control">
            <option value="paid" {{($order->payment_status=='paid') ? 'selected' : ''}}>Paid</option>
            <option value="unpaid" {{($order->payment_status=='unpaid') ? 'selected' : ''}}>Unpaid</option>
        </select>
    </div>
      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
</div>

@endsection

@push('styles')
<style>
    .order-info,.shipping-info{
        background:#ECECEC;
        padding:20px;
    }
    .order-info h4,.shipping-info h4{
        text-decoration: underline;
    }
</style>
@endpush
