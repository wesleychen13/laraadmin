@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="ibox-content">
        <div class="list-group">

               <div class="list-group-item">

                   <h3 class="list-group-item-heading">用户ID</h3>

                   <p class="list-group-item-text"> {{ $data['id'] or ''}}</p>

               </div>
               <div class="list-group-item">

                   <h3 class="list-group-item-heading">用户名</h3>

                   <p class="list-group-item-text"> {{ $data['username'] or ''}}</p>

               </div>
               <div class="list-group-item">

                   <h3 class="list-group-item-heading">EMAIL</h3>

                   <p class="list-group-item-text"> {{ $data['email'] or ''}}</p>

               </div>
               <div class="list-group-item">

                   <h3 class="list-group-item-heading">手机号</h3>

                   <p class="list-group-item-text"> {{ $data['mobile'] or ''}}</p>

               </div>
               <div class="list-group-item">

                   <h3 class="list-group-item-heading">用户头像</h3>

                   <p class="list-group-item-text"><img src="{{ $data['avatar'] or ''}}" style="height: 80px"></p>

               </div>


               <div class="list-group-item">

                   <h3 class="list-group-item-heading">创建时间</h3>

                   <p class="list-group-item-text"> {{ $data['created_at'] or ''}}</p>

               </div>

               <div class="list-group-item">

                   <h3 class="list-group-item-heading">更新时间</h3>

                   <p class="list-group-item-text"> {{ $data['updated_at'] or ''}}</p>

               </div>

        </div>
    </div>
</div>
@endsection