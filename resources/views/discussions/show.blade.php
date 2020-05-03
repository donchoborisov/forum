@extends('layouts.app')

@section('content')
 

   <div class="card dard-default">
              @include('partials.discussion-header')

                <div class="card-body">
                  <div class="text-center">

                 <strong> {{$discussion->title}}</strong>
                  </div>
                  <hr>
                  {!!$discussion->content!!}

                  @if($discussion->BestReply)
                    <div class="card bg-success my-5" style="color:#fff;">
                        <div class="card-header"> 
                            <div class="d-flex justify-content-between"  >
                          <div>      
                         <img width="40px" class="mr-2" height="40px" style="border-radius: 50%;"src="{{Gravatar::src($discussion->bestReply->owner->email)}}">

                    <strong>{{$discussion->bestReply->owner->name}}</strong>
                </div>
                <div>
                    <strong>BEST REPLY</strong>
                </div>
                     </div>
                         </div>
                         <div class="card-body">   
                      {!!$discussion->bestReply->content!!}
                         </div>
                  </div>
                  @endif
                </div>
            </div>


             @foreach($discussion->replies()->paginate(3) as $reply)
              <div class="card my-5">
                <div class="card-header">
                <div class="d-flex justify-content-between">
                   <div>
         <img width="40px" height="40px" style="border-radius:50%;" src="{{Gravatar::src($reply->owner->email)}}">
         <span>{{$reply->owner->name}}</span>
                   </div>
                   <div>
     @auth               
     @if(auth()->user()->id == $discussion->user_id)  
     <form action="{{route('discussions.best-reply',['discussion' => $discussion->slug,'reply'=>$reply->id])}}" method="POST">@csrf                
<button type="submit" class="btn btn-sm btn-primary">mark as best reply</button>
     </form>
    @endif
    @endauth
             </div>
                 </div>   
                </div>
                <div class="card-body">
                     {!!$reply->content!!}
                 </div>   


             </div>
            
             @endforeach
 {{$discussion->replies()->paginate(3)->links()}}

            <div class="card card-default my-5">
             <div class="card-header">
                Add a reply 
             </div>
             <div class="card-body">
                @auth
                <form action="{{route('replies.store',$discussion->slug)}}" method="post">
                    @csrf
                    <input type="hidden" name="content" id="content">
                    <trix-editor input="content"></trix-editor>
                    <button type="submit" class="btn sm my-2 btn-success">Add Reply</button>
                </form>
                @else

                 <a href="{{route('login')}}" class="btn btn-info">Sign in to add a reply</a>

                @endauth

             </div>
            </div>   

@endsection
@section('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.css">

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.js"></script>

@endsection