<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <style type="text/css">

        /* CLIENT-SPECIFIC STYLES */
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

<body style="background-color: #f4f4f4; margin: 0 !important; padding: 60px 0 !important;">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <!-- LOGO -->
    <tr>
        <td align="center" style="padding: 0px 10px 0px 10px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                <tr>
                    <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: 'Lato', Helvetica, Arial, sans-serif;">
                        <img src="{{ asset('assets/img/logo.png') }}" style="display: block; border: 0; margin: auto; width: 200px; height: auto" />
                        <h1 style="font-size: 30px; font-weight: 700;">Xác nhận đăng ký tài khoản</h1>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                <tr>
                    <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'; font-size: 18px; font-weight: 400; line-height: 25px;">
                        <p style="margin: 0;">Cảm ơn bạn đã sử dụng dịch vụ của Paimonshop. Trước tiên, bạn cần phải kích hoạt tài khoản để hoàn tất việc đăng ký. Hãy click vào nút bấm dưới đây.</p>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" align="left">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;">
                                    <table border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td align="center" style="border-radius: 3px;" bgcolor="#d25645">
                                                <a href="{{ $verificationUrl }}"
                                                   target="_blank"
                                                   style="font-size: 20px;
                                                   font-family: Helvetica, Arial, sans-serif;
                                                   color: #ffffff;
                                                   text-decoration: none;
                                                   padding: 15px 25px;
                                                   border-radius: 5px;
                                                   border: 1px solid #d25645; display: inline-block;">Xác thực tài khoản</a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr> <!-- COPY -->
                <tr>
                    <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 0px 30px; color: #666666; font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'; font-size: 18px; font-weight: 400; line-height: 25px;">
                        <p style="margin: 0;">Nếu nút bấm trên không hoạt động, hãy copy đường dẫn sau và dán vào trình duyệt để hoàn tất việc đăng ký</p>
                    </td>
                </tr> <!-- COPY -->
                <tr>
                    <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 20px 30px; color: #666666; font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'; font-size: 18px; font-weight: 400; line-height: 25px;">
                        <p style="background: #f4f4f4; padding: 1rem; font-style: italic; border-radius: 5px; color: #333">{{ $verificationUrl }}</p>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 20px 30px; color: #666666; font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'; font-size: 18px; font-weight: 400; line-height: 25px;">
                        <p style="margin: 0;">Nếu có bất kỳ vấn đề hay thắc mắc cần hỗ trợ, hãy liên hệ với chúng tôi để nhận được sự trợ giúp</p>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'; font-size: 18px; font-weight: 400; line-height: 25px;">
                        <p style="margin: 0;">Trân trọng, <br>Paimonshop</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor="#f4f4f4" align="center" style="padding: 30px 10px 0px 10px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
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
                    <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                            <tr>
                                <td bgcolor="#f4f4f4" align="left" style="color: #666666; font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'; font-size: 14px; font-weight: 400; line-height: 18px;"> <br>
                                    <p style="margin: 0;">Email này được gửi tự động từ hệ thống website <a href="{{ url('/') }}" target="_blank" style="color: #111111; font-weight: 700;">Paimonshop.com</a>. Vui lòng không trả lời email này</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

</html>
