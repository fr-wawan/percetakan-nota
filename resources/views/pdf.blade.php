<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nota</title>

  <style>
    body {
      border: 5px double black;
      padding: 2rem;
    }

    table {
      border-spacing: 0;
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    table td,
    table th {
      border: 1px solid #ddd;
      padding: 1rem;
      text-align: center;
    }

    table tr:hover {
      background-color: #ddd;
    }


    header {
      display: flex;
      justify-content: space-between;
    }
  </style>
</head>

<body>
  <div style="text-align: center">
    <p>
      WARNET & FOTOCOPY
    </p>
    <h2>SATYA DARMA PRAMUKA
    </h2>
    <p>Jl.Pramuka No.39 RT.05 Wa 081352555925
    </p>
  </div>
  <header>
    <h4 style="float: left; width: 25%; height: 80%;">No : {{ $nota->invoice }}</h4>
    <h4 style="margin-left: 72%; width: 65%">Tgl : {{ $nota->created_at }}</h4>
  </header>
  <table class="border-b">
    <tr>
      <th>Banyaknya</th>
      <th>Nama Barang</th>
      <th>Harga</th>
      <th>Jumlah</th>
    </tr>
    @foreach ($nota->NotaProduct as $value)
    <tr>
      <td>{{ $value->product_quantity }}</td>
      <td>{{ $value->products->nama }}</td>
      <td>{{ moneyFormat($value->products->harga) }}</td>
      <td>{{ moneyFormat($value->products->harga * $value->product_quantity) }}</td>

    </tr>
    @endforeach
    @if(count($nota->NotaProduct) < 12) @for ($i=count($nota->NotaProduct); $i < 12; $i++) <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
        @endfor

        @endif
        <td></td>
        <td></td>
        <th>Total :</th>
        <td>{{moneyFormat($sum)}}</td>

  </table>


  <script type="text/javascript">
    try {
        this.print();
    }
    catch(e) {
        window.onload = window.print;

    }
  </script>

</body>

</html>