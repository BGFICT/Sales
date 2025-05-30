@extends('backend.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Mpesa Payment Lists</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        {{-- @if(count($mpesa_payments)>0) --}}
        {{-- @if(count($MpesaPayments)>0) --}}
        @if($mpesa_orders->count() > 0)
        <table class="table table-bordered" id="order-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>S.N.</th>
              <th>Receipt</th>
              <th>Order_id</th>
              <th>Name</th>
              <th>Phone No.</th>
              <th>Email</th>
              <th>Total Amount</th>
              <th>Time</th>
              {{-- <th>Status</th> --}}
              <th>Actions</th>
              </tr>
          </thead>
          <tfoot>
            <tr>
              <th>S.N.</th>
              <th>Receipt</th>
              <th>Order_id</th>              
              <th>Name</th>
              <th>Phone No.</th>
              <th>Email</th>
              <th>Total Amount</th>
              <th>Time</th>
              {{-- <th>Status</th> --}}
              <th>Actions</th>
              </tr>
          </tfoot>
          <tbody>
            @foreach($mpesa_orders as $MpesaPayment)  
            {{-- @php
                $shipping_charge=DB::table('shippings')->where('id',$order->shipping_id)->pluck('price');
            @endphp  --}}
                <tr>
                    <td>{{$MpesaPayment->id}}</td>
                    <td>{{$MpesaPayment->receipt}}</td>
                    <td>{{$MpesaPayment->order_id}}</td>
                    <td>{{$MpesaPayment->name}}</td>
                    <td>{{$MpesaPayment->phone}}</td>
                    <td>{{$MpesaPayment->email}}</td>
                    <td>{{$MpesaPayment->amount}}</td>
                    <td>{{$MpesaPayment->created_at}}</td>
                    {{-- <td>@foreach($shipping_charge as $data) $ {{number_format($data,2)}} @endforeach</td>
                    <td>${{number_format($MpesaPayment->amount,2)}}</td> --}}
                    {{-- <td>
                        @if($MpesaPayment->status=='payed')
                          <span class="badge badge-primary">{{$MpesaPayment->status}}</span>
                        @elseif($MpesaPayment->status=='process')
                          <span class="badge badge-warning">{{$MpesaPayment->status}}</span>
                        @elseif($MpesaPayment->status=='not payed')
                          <span class="badge badge-success">{{$MpesaPayment->status}}</span>
                        @else
                          <span class="badge badge-danger">{{$MpesaPayment->status}}</span>
                        @endif
                    </td> --}}
                    <td>
                        <a href="{{ route('mpesa_orders.show', $MpesaPayment->id) }}" class="btn btn-warning btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
                        {{-- <a href="{{route('order.edit',$MpesaPayment->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a> --}}
                        {{-- <form method="POST" action="{{route('order.destroy',[$MpesaPayment->id])}}">
                          @csrf 
                          @method('delete')
                              <button class="btn btn-danger btn-sm dltBtn" data-id={{$MpesaPayment->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form> --}}
                    </td>
                </tr>  
            @endforeach
          </tbody>
        </table>
        {{-- <span style="float:right">{{$mpesa_orders->links()}}</span> --}}
        @else
          <h6 class="text-center">No Mpesa Payments found!!! Please check the orders Page</h6>
        @endif
      </div>
    </div>
</div>
@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: none;
      }
  </style>
@endpush

@push('scripts')

  <!-- Page level plugins -->
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <script>
      
      $('#order-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[8]
                }
            ]
        } );

        // Sweet alert

        function deleteData(id){
            
        }
  </script>
  <script>
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
          $('.dltBtn').click(function(e){
            var form=$(this).closest('form');
              var dataID=$(this).data('id');
              // alert(dataID);
              e.preventDefault();
              swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                       form.submit();
                    } else {
                        swal("Your data is safe!");
                    }
                });
          })
      })
  </script>
@endpush