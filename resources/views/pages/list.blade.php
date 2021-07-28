@extends('main')
@section('content')

    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <h3 class="page-title">List of Payments</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col">
                    <div class="card card-small mb-4">
                        <div class="card-header border-bottom">
                            <h6 class="m-0">Account {{$acc_id->account_no}} payments</h6>
                        </div>
                        <div class="card-body p-0 pb-3 text-center">
                            <h4 class="mb-0">{{ auth()->user()->name }} {{ auth()->user()->surname }}</h4>
                            <table class="table mb-0">
                                <thead class="bg-light">
                                <tr>
                                    <th scope="col" class="border-0">No.</th>
                                    <th scope="col" class="border-0">Date</th>
                                    <th scope="col" class="border-0">Sender Account</th>
                                    <th scope="col" class="border-0">Beneficiary Account</th>
                                    <th scope="col" class="border-0">Purpose of Payment</th>
                                    <th scope="col" class="border-0">Amount, Eur</th>
                                    <th scope="col" class="border-0">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $no=1 ?>
                                @forelse($transfers as $acc)
                                    @if($acc['account_id_from']==$acc_id->id && ($acc['status']==1) or ($acc['status']==2))
                                        <tr>
                                            <td>{{$no}}</td>
                                            <td>{{$acc->date}}</td>
                                            <td>{{$acc['account_no_from']}} <br>{{$acc['name1']}}&nbsp;{{$acc['surname1']}}</td>
                                            <td>{{$acc['account_no_to']}} <br>{{$acc['name2']}}&nbsp;{{$acc['surname2']}}</td>
                                            <td>{{$acc['purpose']}}</td>
                                            @if($acc['account_id_to']==$acc_id->id)
                                                <td> {{$acc['amount']}}</td>
                                            @else
                                                <td> {{'-'.$acc['amount']}}</td>
                                                <td> {{$acc['amount']}}</td>
                                            @endif
                                            <td>
                                                @if($acc['status']==1)
                                                    <a href="/cancel/{{$acc['id']}}" class="btn btn-xs btn-danger pull-right">Payment in progress. Cancel</a>
                                                @else
                                                    <a class="btn btn-xs btn-success pull-right disabled text-white">Payment made</a>
                                                @endif
                                            </td>
                                            <?php $no=$no+1 ?>
                                            @else
                                            @endif
                                            @empty
                                            @endforelse
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
