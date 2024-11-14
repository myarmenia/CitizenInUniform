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
        width: 50%;
        margin: 0 auto
      }
      #logo{
        width: 18%;
      }
      .ticket-card{
        margin-top: 30px;
        color: black

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
        width: 60%;
        padding: 20px;
      }

      .card-div-last-child{
        width: 40%;
        -webkit-align-items: center;
        -ms-align-items: center;
        align-items: center !important;
        border-left: dashed 2px #4b4747;
      }




      @media (max-width: 1024px) {
        .cont {
          width: 100%;
        }
        .card-div{
          display: ruby-text !important;
          background-color: white !important;
          -webkit-align-items: center;
          -ms-align-items: center;
          flex-direction: column-reverse !important;
          justify-content: center !important;
        }
        .card-div-first-child{
          width: 90%;
        }
        .card-div-last-child {
          width: 100%;
          border-top: dashed 1px #aaa;
          border-left: unset;
          align-items: center;
        }


      }



    </style>
</head>

<body >

    <div class="cont" >
        <section style="background: #e3e2e059; padding: 30px 40px">
            {{-- <img src="{{$message->embed('assets/img/logos/museum-logo.png')}}" alt="museum-log" id="logo"> --}}

            <div style="text-align: center; align-item: center">
                <p style="margin: 12px auto; font-weight: 600; text-align: center; width: 60%">{{$data['message_title']}}</p>
            </div>

            <div class="card-div" >
                <div class="card-div-first-child">
                    <div style="display: flex; align-items: center;">
                        <p>{{$data['content']}}<p>
                        <p style="text-transform: uppercase; font-size: 12px; font-weight: 600; line-height: 13.6px; border-bottom: 1px solid black; padding-bottom: 5px;">{{$data['content']}}</p>
                    </div>
                </div>
            </div>
        </section>
      </div>
</body>

</html>
