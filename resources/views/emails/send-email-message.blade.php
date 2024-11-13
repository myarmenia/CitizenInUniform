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

      #qr_img_cont{
          display: block;
          margin: auto;
          height:100%;
          display: -webkit-flex;
          -webkit-align-items: center;
          -webkit-justify-content: center;
          -webkit-margin: 0 auto;
          -moz-margin: 0 auto;
          -ms-margin: 0 auto;
          -o-margin: 0 auto;
      }

      #qr_img{
        display: block;
        width: 70%;
        margin: auto;
        -webkit-margin: 0 auto;
        -moz-margin: 0 auto;
        -ms-margin: 0 auto;
        -o-margin: 0 auto;
      }

      .qr_responsive{
         width: 66% !important;
      }
      #price_cont{
        margin-top: 20px;
        margin-left: 6px;
        font-size: 12px;
        display: flex;
        -webkit-justify-content: space-between;
        justify-content: space-between !important
      }
      #price_cont span:first-child{
        font-size: 18px;

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
        #qr_img_cont{
          margin: auto;
          height:80%;
          display: flex;
          display: block;
          display: -webkit-flex;
          -webkit-align-items: center;
          -webkit-justify-content: center;
          -webkit-margin: auto;
          -moz-margin: auto;
          -ms-margin: auto;
          -o-margin: auto;
        }

        #price_cont{
          font-size: 8px
        }

        #price_cont span{
          font-size: 10px
        }
        #qr_img{
          width: 46%;
          margin: 20px auto;
        }
      }



    </style>
</head>

<body >

    <div class="cont" >
        <section style="background: #e3e2e059; padding: 30px 40px">
            {{-- <img src="{{$message->embed('assets/img/logos/museum-logo.png')}}" alt="museum-log" id="logo"> --}}

            <div style="text-align: center; align-item: center">
                <p style="margin: 12px auto; font-weight: 600; text-align: center; width: 60%">ՀԱՅԱՍ ՖՖ ՌՌՌ</p>
            </div>

            <div class="card-div" >
                <div class="card-div-first-child">
                    <div style="display: flex; align-items: center;">
                        <p style="text-transform: uppercase; font-size: 12px; font-weight: 600; line-height: 13.6px; border-bottom: 1px solid black; padding-bottom: 5px;">{{ticketTitles()[$type]}}</p>
                    </div>
                </div>
            </div>
        </section>
      </div>
</body>

</html>
