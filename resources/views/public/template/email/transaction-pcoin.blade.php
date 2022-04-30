<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <style type="text/css">

        /* CLIENT-SPECIFIC STYLES */
        p {
            font-size: 16px;
        }
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        /* RESET STYLES */
        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        table {
            border-collapse: collapse !important;
        }

        body {
            font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        /* iOS BLUE LINKS */
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* MOBILE STYLES */
        @media screen and (max-width:600px) {
            h1 {
                font-size: 32px !important;
                line-height: 32px !important;
            }
        }

        /* ANDROID CENTER FIX */
        div[style*="margin: 16px 0;"] {
            margin: 0 !important;
        }
    </style>
</head>
@php
    const STATUS = [
        0 => 'Đang xử lý',
        1 => 'Hoàn thành',
        3 => 'Lỗi',
    ];

    const TYPE = [
        1 => 'Nạp Pcoin bằng thẻ điện thoại',
        2 => 'Nạp Pcoin qua TK ngân hàng',
        3 => 'Nạp Pcoin bằng QR MOMO',
        4 => 'Nạp Pcoin bằng QR VNPAY'
    ];

@endphp
<body style="background-color: #f4f4f4; padding: 60px 0 !important;">
<div style="max-width: 600px; margin: auto; background-color: #fff; border-radius: 5px">
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <img src="{{ asset('assets/img/logo.png') }}" style="display: block; border: 0; margin: auto; width: 200px; height: auto" />
            </td>
        </tr>
        <tr>
            <td>
                <p style="margin-bottom: 15px; padding: 0 20px">Tài khoản {{ $user['email'] }} vừa {{ TYPE[$transaction_pcoin->type] }} với mã giao dịch là {{ $transaction_pcoin->request_id }}</p>

            </td>
        </tr>
    </table>

    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td style="border-bottom: 1px solid #ccc; padding-bottom: 10px" colspan="2">
                <p style="margin: 0; padding: 0 20px; font-weight: 800; font-size: 22px;">
                    Chi tiết giao dịch #{{ $transaction_pcoin->request_id }} - {{ date('d/m/Y H:i', strtotime($transaction_pcoin->created_at)) }}
                </p>
            </td>
        </tr>

        <tr>
            <td><p style="padding: 10px 0 0 20px; margin: 0"><b>Khách hàng:</b> {{ $user['name'] }}</p></td>
        </tr>


        <tr>
            <td><p style="padding: 10px 0 0 20px; margin: 0"><b>Email đăng nhập:</b> {{ $user['email'] }}</p></td>
        </tr>

        <tr>
            <td><p style="padding: 10px 0 0 20px; margin: 0"><b>Số điện thoại: </b> {{ $user['phone'] }}</p></td>
        </tr>
        <tr>
            <td><p style="padding: 10px 0 0 20px; margin: 0"><b>Địa chỉ:</b> {{ $user['address'] }}</p></td>
        </tr>

        <tr>
            <td><p style="padding: 10px 0 0 20px; margin: 0"><b>Mã giao dịch: </b> {{ $transaction_pcoin->request_id }}</p></td>
        </tr>

        <tr>
            <td><p style="padding: 10px 0 10px 20px; margin: 0"><b>Tình trạng giao dịch:</b> {{ STATUS[$transaction_pcoin->status] }}</p></td>
        </tr>


    </table>
</div>

<div style="max-width: 600px; margin: 20px auto 0 auto; background-color: #fff; border-radius: 5px">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td bgcolor="#d25645" align="center" style="padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #f1f1f1; font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'; font-size: 18px; font-weight: 400; line-height: 25px;">
                <h2 style="font-size: 20px; font-weight: 400; color: #f1f1f1; margin: 0;">Thông tin liên hệ</h2>
                <p style="margin: 0;">Paimonshop - Hệ thống nạp game chiết khấu</p>
                <p style="margin: 0;">Địa chỉ: Lại Xuân, Thủy Nguyên, Hải Phòng</p>
                <p style="margin: 0;">Số ĐT: <a href="tel:0329141615" style="color: #f1f1f1;">0329141615</a></p>
                <p style="margin: 0;">Fanpage FB: <a href="https://www.facebook.com/PaimonTopup" style="color: #f1f1f1;">Click vào đây</a></p>
                <p style="margin: 0;">Discord Group: <a href="https://discord.gg/7KrR7W37" style="color: #f1f1f1;">discord.gg/7KrR7W37</a></p>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f4f4f4" align="left" style="color: #666666; font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'; font-size: 14px; font-weight: 400; line-height: 18px;"> <br>
                <p style="margin: 0;">Email này được gửi tự động từ hệ thống website <a href="{{ url('/') }}" target="_blank" style="color: #111111; font-weight: 700;">Paimonshop.com</a>. Vui lòng không trả lời email này</p>
            </td>
        </tr>
    </table>
</div>
</body>

</html>
