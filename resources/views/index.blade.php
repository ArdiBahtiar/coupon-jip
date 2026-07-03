<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<body>
    
    <button id="generate" style="
    display:inline-block;
    padding:8px 16px;
    background:#2563eb;
    color:#fff;
    text-decoration:none;
    border-radius:6px;
    ">
        Generate Coupon
    </button>

    <a href="{{ route('coupons.report') }}" style="
    display:inline-block;
    padding:8px 16px;
    background:#2563eb;
    color:#fff;
    text-decoration:none;
    border-radius:6px;
    ">
        Lihat Laporan Kupon
    </a>

</body>

<script>
$('#generate').click(function () {
    $.post({
        url: "{{ route('generate.coupon') }}",
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function(res) {
            console.log(res);
        }
    });
});
</script>
</html>