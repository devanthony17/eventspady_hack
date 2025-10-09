@extends('frontend.master', ['activePage' => 'ticket'])

@section('content')
 
@include('frontend.layout.breadcrumbs', [
    'title' => __('My Tickets'),            
    'page' => __('Tickets'),            
]) 

  
<section class="contact">
    <div class="container">
        <div class="row">   
            @if(count($ticket['upcoming'])==0 && count($ticket['past'])==0)  
                <div class="col-lg-12 text-center">
                    <div class="empty-state">
                    <img src="{{url('frontend/images/empty.png')}}">
                    <h6 class="mt-4"> {{__('No Tickets found')}}!</h6>
                    </div>
                </div>
            @else 
                <div class="col-lg-4 order-left">
                    @if(count($ticket['upcoming'])>0)
                    <div>
                        <h5 class="mb-3">{{__('Upcoming Events')}} <button >{{count($ticket['upcoming'])}}</button></h5>               
                        @foreach ($ticket['upcoming'] as $item)
                            @if($loop->iteration==1)
                                <?php $first_item = $item; ?>
                            @endif

                            <?php   if($item->order_status=="Pending"){
                                        $s=  'badge-warning';
                                    }    
                                    else if($item->order_status=="Complete"){
                                        $s= 'badge-success';
                                    }
                                    else if($item->order_status=="Cancel"){
                                        $s= 'badge-danger';
                                    } ?>
                            <div class="row event-data mb-3 pb-2 {{$loop->iteration==1?'active': ''}}" id="order-{{$item->id}}">
                                <div class="col-3">                            
                                    <img  src="{{url('images/upload/'.$item->event->image)}}">
                                </div>
                                <div class="col-9">
                                    <span class="badge text-white mr-2 {{$s}}">{{$item->order_id}}</span><span class="event-date">{{$item->event->start_time->format('D').', '.$item->event->start_time->format('d M Y')}}</span>
                                    <h6 class="mb-1">{{$item->event->name}}</h6>
                                    <p class="mb-0">{{$item->quantity.__(' tickets of ').$item->ticket->ticket_number}}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endif
                    @if(count($ticket['past'])>0)                    
                        <h5 class="mt-4 mb-3">{{__('Past Events')}} <button>{{count($ticket['past'])}}</button></h5>
                        @foreach ($ticket['past'] as $item)
                        <?php   if($item->order_status=="Pending"){
                                    $s=  'badge-warning';
                                }    
                                else if($item->order_status=="Complete"){
                                    $s= 'badge-success';
                                }
                                else if($item->order_status=="Cancel"){
                                    $s= 'badge-danger';
                                } ?>
                            @if($loop->iteration==1 && count($ticket['upcoming'])==0)
                                <?php $first_item = $item; ?>
                            @endif
                            <div class="row event-data mb-3 pb-2" id="order-{{$item->id}}">
                                <div class="col-3">
                                    <img  src="{{url('images/upload/'.$item->event->image)}}">
                                </div>
                                <div class="col-9">
                                    <span  class="badge text-white mr-2 {{$s}}">{{$item->order_id}}</span><span class="event-date">{{$item->event->start_time->format('D').', '.$item->event->start_time->format('d M Y')}}</span>
                                    <h6 class="mb-1">{{$item->event->name}}</h6>
                                    <p class="mb-0">{{$item->quantity.' tickets of '.$item->ticket->ticket_number}}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="col-lg-8">
                    <?php 
                        if($first_item->order_status=="Pending"){
                            $status = 'badge-warning';
                        }    
                        else if($first_item->order_status=="Complete"){
                            $status = 'badge-success';
                        }
                        else if($first_item->order_status=="Cancel"){
                            $status = 'badge-danger';
                        }
                        $review = App\Models\Review::where('order_id',$first_item->id)->first();
                    ?>
                
                    <div class="single-order">
                        <div class="single-order-top">    
                            <p class="text-light mb-0">{{$first_item->order_id}}</p>                    
                            <h2>{{$first_item->event->start_time->format('D').', '.$first_item->event->start_time->format('d M Y').' at '. $first_item->event->start_time->format('h:i a')}}</h2>    
                            <span class="badge {{$status}}">{{$first_item->order_status}}</span>
                            @if($review!=null)
                                <div class="rating order-rate">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa fa-star {{$review->rate >= $i ? 'active':''}}"></i>
                                    @endfor
                                </div>
                            @endif
                            <div class="row mt-2">
                                <div class="col-lg-2">
                                    <img class="w-100" src="{{url('images/upload/'.$item->event->image)}}">
                                </div>
                            
                                <div class="col-5">
                                    <h6 class="mb-0">{{$first_item->event->name}}</h6>
                                    <p class="mb-0">{{__('By')}}: {{$first_item->organization->first_name.' '.$first_item->organization->last_name}}</p>
                                    <p class="mb-0">{{$first_item->event->start_time->format('d M Y').', '. $first_item->event->start_time->format('h:i a'). ' to '}}</p>
                                    <p class="mb-0">{{$first_item->event->end_time->format('d M Y').', '. $first_item->event->end_time->format('h:i a')}}</p>
                                    @if($first_item->event->type=="online")
                                        <p class="mb-0">{{__('Online Event')}}</p>
                                    @else
                                        <p class="mb-0">{{$first_item->event->address}}</p>
                                    @endif
                                </div>
                                <div class="col-5 ">                                                                         
                                    <div class="right-data text-center">
                                        <div>
                                            <button class="btn" onclick="viewPayment()"><i class="fa fa-credit-card"></i></button><p>{{__('Payment')}}</p>
                                        </div>   
                                        @if($review == null && $first_item->order_status=="Complete" || $first_item->order_status=="Cancel")                                     
                                        <div>
                                            <button class="btn open-addReview"  data-toggle="modal" data-id="{{$first_item->id}}" data-order="{{$first_item->order_id}}"  data-target="#reviewModel"><i class="fa fa-star"></i></button><p>{{__('Review')}}</p>
                                        </div>
                                        @endif
                                        <div>
                                            <a href="{{ url('order-invoice-print/' . $first_item->id) }}" target="_blank" class="btn" id="print-btn"><i class="fa fa-print"></i><p>{{__('Print')}}</p></a>
                                        </div>
                                    </div>
                                    <div class="payment-data hide" >
                                        <p class="mb-0"><span>{{__('Payment Method')}} : </span>{{$first_item->payment_type}}</p>
                                        <p class="mb-1"><span>{{__('Payment Token')}} : </span>{{$first_item->payment_token==null?'-':$first_item->payment_token}}</p>
                                        <span class="badge {{$first_item->payment_status==1?'badge-success':'badge-warning'}}">{{$first_item->payment_status==1?'Paid':'Waiting'}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="order-bottom"> 
                            <div class="order-ticket-detail mb-4">
                                <div>
                                    <p>{{$first_item->ticket->name}}</p>                            
                                </div>
                                <div> 
                                    @if($first_item->ticket->type=="free")
                                    {{$first_item->quantity .' tickets'}}
                                    @else
                                        {{$first_item->quantity.' * '.$currency.$first_item->ticket->price}}
                                    @endif
                                </div>
                            </div>
                            <div class="order-total"> 
                                <p>{{__('Ticket Price')}}</p>
                                <p>{{$first_item->ticket->type=="free"?'FREE':$currency.($first_item->ticket->price* $item->quantity)}}</p>
                            </div>
                            <div class="order-total"> 
                                <p>{{__('Coupon discount')}}</p>
                                <p>{{$first_item->ticket->type=="free"?'0.00':'(-) '.$currency.$first_item->coupon_discount}}</p>
                            </div>
                            <div class="order-total">    
                                <p>{{__('Tax')}}</p>
                                <p>{{ $first_item->ticket->type=="free"?'0.00':'(+) '.$currency.$first_item->tax}}</p>
                            </div>
                            <div class="order-total"> 
                                <h6>{{__('Total')}}</h6>
                                <h6>{{ $first_item->ticket->type=="free"?'FREE':$currency.$first_item->payment}}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<div class="modal fade" id="reviewModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{__('Add Review')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" action="{{url('add-review')}}">
        @csrf 
            <div class="modal-body">           
                <div class="form-group">
                    <label>{{__('Rate')}}</label>                    
                    <input type="hidden" name="order_id" id="order_id">                   
                    <input type="hidden" name="rate" required>                   
                        <div class="rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fa fa-star" onclick="addRate('{{$i}}');" id="rate-{{$i}}"></i>
                            @endfor
                        </div>
                        @error('rate')
                        <p class="error">{{ $message }}</p>    
                    @enderror                
                </div>

                <div class="form-group">
                    <label>{{__('Message')}}</label>
                    <textarea name="message" required class="form-control" placeholder="{{ __('Message') }}"></textarea>         
                </div>            
            </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
          <button type="submit" class="btn btn-primary">{{__('Add')}}</button>
        </div>
    </form>
      </div>
    </div>
</div>

@endsection
