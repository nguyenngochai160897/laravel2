<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <base href="{{ asset('') }}">
    
    <style>
        header{
            width: 100%;
            height: 225px;
            padding: 70px 70px;
            background: #f5f5f5
        }
        footer{
            width: 100%;
            background: #0e1015;
            padding: 72px 100px;
            color: #f5f5f5;
        }
        ul{
            padding: 0;
            margin: 0;
        }
        ul li{
            list-style-type: none;
            background: : #fff;
        }
        ul li a {
            color: #8c979e;
        }
        ul li a:hover {
           text-decoration: none;
        }
        main img{
            width: 100%;
            margin: 20px 0;
        }
        time{
            color:aquamarine
        }
        .content p::first-letter {
            text-transform: uppercase;
            font-size: 3em;
            font-weight: bold;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            letter-spacing: 5px;
            color:black;
        }
        .read-more:hover{
            text-decoration: none;
        }
        hr{
            border: 0.1 solid #8c979e;
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-light bg-light">
            <span class="navbar-brand mb-0 h1">Navbar</span>
        </nav>
        <header>
            @yield('header_title')
        </header>
        <div class="row">
            <main class="col-8">
                @yield("content")
            </main>
            <div class="col-4 sidebar">
                <div class="post">
                    <h1>Recent Posts</h1>
                    <ul>
                    @foreach ($postRecent as $post)
                    <li><a href="{{ route('blog-detail', ['id' => $post->id]) }}"> {{ $post->title }} </a></li> 
                    <hr>
                    @endforeach
                    </ul>
                </div>
                <div class="category">
                    <h1>Categories</h1>
                    <ul>
                    @foreach ($categories as $category)
                    <li><a href="{{ route('category-detail', ['id' => $category->id]) }}">{{ $category->name }}</a></li>
                    <hr>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p>Theme by hainguyen</p>
    </footer>
</body>
</html>