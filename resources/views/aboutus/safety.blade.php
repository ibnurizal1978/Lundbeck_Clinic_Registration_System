@extends('layouts.app')

@section('content')
<div class="container-fluid px-8" style="">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ URL::route('home') }}" class="fc-hyperlink-blue text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{URL::route('learnmore')}}" class="fc-hyperlink-blue text-decoration-none">About Us</a></li>
            <li class="breadcrumb-item active" aria-current="page">Safety</li>
        </ol>
    </nav>
    <h3 class="dark-blue">Safety</h3>
    <hr>
    <h3 class="dark-blue">Header</h3>
    <div class="container-fluid">
        <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Faucibus molestie cras morbi vulputate id. Non augue egestas gravida ut proin. Eu mauris quisque blandit et libero. Cursus mauris tortor auctor sed nunc.
        </p>
        <p>
        Tellus senectus morbi vestibulum nulla urna aliquet dictum id. Semper varius nam lacus lacus, sed nam nunc pulvinar quis. Ut scelerisque vulputate turpis lacinia non erat et. Tristique nibh et fames etiam aliquam. Auctor placerat enim quam at auctor. Dolor eget ipsum odio leo sagittis lacus. Lorem id tincidunt velit cursus dui adipiscing ut. Posuere lorem faucibus blandit amet blandit nulla iaculis elit mattis. Facilisis vestibulum feugiat placerat volutpat volutpat. Rhoncus vulputate malesuada tempus arcu morbi. Quis ut in nullam sed et fringilla. Ultricies vel euismod id scelerisque aliquet eu. Ante a ornare donec id.
        </p>
        <p>
        Phasellus vulputate imperdiet odio duis laoreet maecenas adipiscing non convallis. Molestie pellentesque fermentum, eu lorem cursus amet porta dolor volutpat. Purus leo, amet lobortis purus, et. Tincidunt quisque facilisis porttitor dignissim arcu urna sociis et odio. Elementum amet a vitae cum dolor in. Ac blandit pellentesque enim mi, elementum ut. Vestibulum non adipiscing suscipit elit. Rhoncus, donec a pellentesque odio suscipit pretium laoreet dapibus. Eget scelerisque lectus est non laoreet sit sed. Quam porta tortor aliquam lectus. Odio vulputate accumsan senectus id viverra. Quis purus semper molestie at. Bibendum diam vel pulvinar imperdiet est ante nunc cursus. Sed tellus at est at. Semper in velit dui tellus nulla eget amet.

        </p>
        <div class="position-relative">
            <div class="position-absolute top-0 start-0">
            <h3>
                    <a class="dark-blue" href="{{URL::route('fusion')}}" style="text-decoration: none !important;">
                        <span class="material-icons md-48 dark-blue" style="font-size: 35px !important" >
                            arrow_circle_left
                        </span>
                        <br>
                        Fusion
                    </a>
                </h3>
            </div>
            <div class="position-absolute top-0 end-0">
                <!-- <h3>
                    <a class="dark-blue" href="{{URL::route('safety')}}" style="text-decoration: none !important;">
                        <span class="material-icons md-48 dark-blue" style="font-size: 35px !important" >
                            arrow_circle_right
                        </span>
                        <br>
                        Safety
                    </a>
                </h3>     -->
            </div>
        </div>
    </div>
</div>
@endsection
