<nav aria-label = "breadcrumb">
    <ol class = "breadcrumb">
        @foreach($breadcrumbs as $name =>$url)
            @if($loop->last)
                <li class = "breadcrum-item active" aria-current="page" style="margin-right: 10px;">
                    {{$name}}
                </li>
            @else
                <li class = "breadcrum-item" style="margin-right: 10px;">
                    <a href="{{$url}}">{{$name}}</a> /
                </li>
            @endif
        @endforeach
    </ol>
</nav>

