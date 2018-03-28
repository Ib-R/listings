@if(count($errors) > 0)
    @foreach($errors->all() as $error)
        <div class="alert alert-danger fade in">
            <span class="pull-right" style="cursor:pointer" data-dismiss="alert">&#x2718;</span>
            {{$error}}
        </div>
    @endforeach
@endif

@if(session('success'))
    <div class="alert alert-success">
        <span class="pull-right" style="cursor:pointer" data-dismiss="alert">&#x2718;</span>
        {{session('success')}}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        <span class="pull-right" style="cursor:pointer" data-dismiss="alert">&#x2718;</span>
        {{session('error')}}
    </div>
@endif