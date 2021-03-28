<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>サインイン フォーム</title>
    <!-- bootstrap js、css読み込み -->
    <!-- script -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- style -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/signin.css') }}" rel="stylesheet">
</head>
<body>
<!-- bootstrap sample > signin を使って編集する -->
    <form class="form-signin" method="post" action="{{ route('login') }}">
        @csrf
        <!-- sumbit で、action先にアクセスする -->
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
        <!-- バリデーションエラーの表示 -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- サインインのエラー -->
        @if (session('login_error'))
            <div class="alert alert-danger">
                {{ session('login_error') }}
            </div>
        @endif
        <!-- サインアウトの表示 -->
        @if (session('logout'))
            <div class="alert alert-danger">
                {{ session('logout') }}
            </div>
        @endif
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password">
        <!-- <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div> -->
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

    </form>
</body>
</html>
