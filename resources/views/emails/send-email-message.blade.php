<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

      body{
        color: black
      }
      .cont{
        width: 70%;
        margin: 0 auto
      }

      .card-div{
        display: flex;
        background-color: white;
        align-items: center ;
        flex-wrap: wrap;
        justify-content: center;
        gap: 40px;
      }

      .card-div-first-child{
        width: 90%;
        padding: 20px;
      }

    </style>
</head>

<body >

    <div class="cont" >
        <section style="background: #e3e2e059; padding: 30px 40px; text-align: center">
            <img src="{{$message->embed('assets/img/logo.png')}}" alt="log" id="logo" style="width: 64px">
                <h6 style="color:black; margin-top: 0">Համազգեստով քաղաքացի</h6>
            <div style="text-align: center; align-item: center">
                <p style="margin: 12px auto; font-weight: 600; width: 60%; color:black">{{$data['message_title']}}</p>
            </div>
            <div style="text-align: start">
                <div class="card-div" >
                    <div class="card-div-first-child">
                        <h5 style="text: 60px">Ձեր նամակը․</h5>
                        <div style="display: flex; align-items: center;">
                            <p>{{$data['mobile_user_content']}}<p>
                        </div>
                    </div>
                </div>

                <div class="card-div" >
                    <div class="card-div-first-child">
                        <h5>Նամակի պատասխանը․</h5>
                        <div style="display: flex; align-items: center;">
                            <p>{{$data['content']}}<p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
      </div>
</body>

</html>
