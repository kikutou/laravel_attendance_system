<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/popper.js/1.12.5/umd/popper.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.staticfile.org/jquery/1.10.2/jquery.min.js"></script>


    <title></title>
    <style>
      div.current {
        background: gray;
      }
      .margin{
        margin-left: 270px;
      }
      body{
        overflow: scroll;
      }
      .cool{
        margin-left:260px;
      }

      #socool{
        margin-top:10px;
      }

      #top{
        margin-top: 20px;
      }

      .top1{
        border: 5px solid gray;
      }
    </style>
    <script type="text/javascript">
      function clear1()
      {
       if(confirm("承認をしますか？"))
       {
       return true;
     }else {
       return false;
     }
      }
    </script>

  </head>

  <body>
    <div id="content" class="container-fluid">
        <div class="col-sm text-center top36 bottom36">
          <p>email請求一覧</p>
        </div>

        <div class="col-sm text-center top36 bottom36">

        <div class="media row top36 bottom36">
          <div class="col-sm-2"></div>
          <div class="col-sm-8">
            @foreach($users as $user)
            <div id="top">
              <div class="event_content row bg-light top1">
                <div class="col-sm-12">

                  <div id="socool" class="row top36">
                    <div class="col-sm-6 text-center">従業員</div>
                    <div class="col-sm-6 text-center">{{ $user->name }}</div>
                  </div>
                  <div id="socool" class="row top6">
                    <div class="col-sm-6 text-center">email</div>
                    <div class="col-sm-6 text-center">
                      {{ $user->email }}
                    </div>
                  </div>
                  <div id="socool" class="row top6">
                    <div class="col-sm-6 text-center">telephone_number</div>
                    <div class="col-sm-6 text-center">
                      {{ 	$user->telephone_number }}
                    </div>
                  </div>
                  <div class="row top36">
                    <div class="col-sm text-center">
                      <form action="{{ route('post_mail_check') }}" method="post">
                        @csrf
                        <input type="hidden" name="	email_verified" value="{{ $user->email_verified_at }}">
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <input onclick="return clear1()" type="submit" value="承認">
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>

          <div class="col-sm-2"></div>
        </div>

    </div>
  </body>
</html>
