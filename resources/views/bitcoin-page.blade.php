@extends('layout.base-template', [
    'title'       => 'Bitcoin Private Key Page'.($isShortNumberString ? $pageNumber : ''),
    'description' => 'SEO description',
])

@section('content')

    {{ json_encode([
        'pageNumber' => $pageNumber,
        'isShortNumberString' => $isShortNumberString,
        'isSmallNumber' => $isSmallNumber,
    ]) }}


    <script>
    // let bigInt = bigi.fromHex('01');
    //
    // var add = new bitcoin.ECPair(bigInt, null, {
    // compressed: true,
    // });
    // console.log(add);
    // console.log(add.getAddress());
    </script>



@endsection
