<style type="text/css">
    body{
        width: 380px;
        height: 555px;
        margin: 0 auto;
    }
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* @page {
        size: 7in 9.25in;
        margin: 27mm 16mm 27mm 16mm;
    } */

    body {
        /* width: 21cm;
        height: 29.7cm;
        margin: 30mm 80mm 30mm 45mm; */

        font-family: verdana, arial, helvetica;
        font-weight: 500;
        /* background-image: url({{url('public/print/BITMAINSTICKER.jpg')}});
        background-size: cover; */
        padding: 25px;
    }

    @media print {
        body {
            width: 10cm;
            height: 15cm;
            margin: 0;
        }
    }

    header {
        display: flex;
        justify-content: space-between;
    }

    header .header-info p {
        font-size: 10px;
    }

    header img {
        width: 150px;
    }

    .ship-to h4 {
        font-size: 10px;
        font-family: "Times New Roman", Times, serif;
    }

    .ship-to p {
        text-transform: uppercase;
        font-weight: 700;
        margin-bottom: 10px;
        font-size: 8px;
    }

    .code {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 0 0 40px;
    }

    .code .codebar {
        width: 12cm;
        height: 150px;
    }

    .note p {
        color: red;
        padding: 0 0 0 40px;
        font-size: 12px;
        margin: 10px 0;
    }

    .codebarfooter {
        width: 100%;
        height: 150px;
    }

    .codebar-container h3,
    footer h1 {
        text-align: center;
        text-transform: uppercase;
        font-weight: 400;
    }
    footer > div {
        margin: 0 auto;
    }
</style>
@if($RepairPayment->status == 2)
    <header id="header">
        <div class="header-info">
            <p>Sender:</p>
            <p>{{$RepairPayment->user->name}}</p>
            @if($RepairPayment->address != '' AND $RepairPayment->street == '')
                <p>{{$RepairPayment->address}}</p>
            @else
                <p>{{$RepairPayment->street}}</p>
                <p>{{$RepairPayment->city}}</p>
                <p>{{$RepairPayment->country}}</p>
                <p>{{$RepairPayment->postalcode}}</p>
            @endif
            <p>{{$RepairPayment->user->phone}}</p>
        </div>
        <div class="header-logo">
            <img src="{{url('public/print/BITMAIN Repair logo.png')}}" />
        </div>
    </header>

    <section class="ship-to">
        <h4>Ship to</h4>
        <p>
            Bitmain Repair center <br />carrer poeta guillem colom 4<br />07010
            palma de mallorca<br />EspaÑa (es) illes balears <br />tel.
            +34.871100465
        </p>
    </section>
@endif
@if($RepairPayment->status == 7)
    <header id="header">
        <div class="header-info">
            <p>Sender:</p>
            <p>Bitmain Repair center</p>
            <p>carrer poeta guillem colom 4</p>
            <p>07010 palma de mallorca</p>
            <p>EspaÑa (es) illes balears </p>
            <p>tel. +34.871100465</p>
        </div>
        <div class="header-logo">
            <img src="{{url('public/print/BITMAIN Repair logo.png')}}" />
        </div>
    </header>

    <section class="ship-to">
        <h4>Ship to</h4>
        <p>
            {{$RepairPayment->user->name}}<br>
            @if($RepairPayment->address != '' AND $RepairPayment->address == '')
                {{$RepairPayment->address}}<br>
            @else
                {{$RepairPayment->street}}<br>
                {{$RepairPayment->city}}<br>
                {{$RepairPayment->country}}<br>
                {{$RepairPayment->postalcode}}<br>
            @endif

            {{$RepairPayment->user->phone}}<br>
        </p>
    </section>
@endif

<section class="code">
    <img src="{{ url('/storage/attached/qrcode_'.$RepairPayment->id.'.png')}}" class="codeqr" width="30%" />
    <div class="codebar-container">
        @php
            $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
            @endphp
          
        <img src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode($RepairPayment->number, $generatorPNG::TYPE_CODE_128)) }}" style="    height: 30px;    width: 130px;">
        <h3 style="    font-size: 12px;    text-align: center;">{{$RepairPayment->number}}</h3>
    </div>
</section>
<section class="note">
    <p>
        Nota Aduanas:<br />este envio es una reparacion de maquinaria<br />informatica
        fuera de garantia de compra.
    </p>
    <p>
        Customs:<br />This package contains computer hardware sended
        <br />to our Repaircenter for Repair
    </p>
</section>

<footer style="text-align: center;">
    <img src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode($RepairPayment->serial_num, $generatorPNG::TYPE_CODE_128)) }}" style="    height: 50px;    width: 130px;">
    <h1 style="
    font-size: 20px;
">{{$RepairPayment->serial_num}}</h1>
</footer>