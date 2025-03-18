<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Email Title</title>
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Exo+2&display=swap" rel="stylesheet">
</head>

<body style="background: rgb(211, 211, 211)">
    
    <!-- Main Body -->
    <table align="center" width="100%" cellpadding="0" cellspacing="0"
        style="max-width: 600px; background: white; padding: 20px 0; border-radius: 8px; box-shadow: 0px 0px 10px #ddd;">
        @php
            $pathToImage = public_path(config('app.logo_path'));
        @endphp
        <tr>
            <td align="center">
                <img src="{{ $message->embed($pathToImage) }}" alt="Logo Sistema Gerenciador de Corridas"
                    style="margin-bottom: 20px; padding: 25px;">
            </td>
        </tr>
        <!-- Resto do E-mail Body -->
        @yield('content')

        {{-- Final do E-mail --}}
        <tr>
            <td align="center" style="font-size: 12px; padding-top: 35px">
                Este e-mail é enviado de forma automática e não recebe respostas.
            </td>
        </tr>
    </table>
</body>
</html>
