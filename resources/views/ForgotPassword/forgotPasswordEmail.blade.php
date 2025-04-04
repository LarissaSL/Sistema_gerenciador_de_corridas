@extends('template.emailTemplate')

@section('content')
    <tr>
        <td align="center" style="padding: 10px 0; font-size: 16px">
            Olá, <strong>{!! $data['nameUser'] !!}!</strong>
        </td>
    </tr>

    <tr>
        <td align="center" style="font-size: 16px; font-weight: bold; padding-top: 25px">
            <strong>Seu link para redefinição de senha é:</strong>
        </td>
    </tr>

    <tr>
        <td align="center" style="padding: 15px 0">
            <table cellpadding="20" cellspacing="0" border="0"
                style="background: #F1A001;color: #ffffff;font-size: 24px;font-weight: bold;border-radius: 5px;">
                <tbody>
                    <tr>
                        <a href="{!! $data['link'] !!}">Redefinir minha senha</a>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>

    <tr>
        <td align="center" style="padding-bottom: 25px; font-size: 14px; font-weight: bold;">
            ⚠️ Caso você não tenha solicitado a redefinição de senha, ignore este e-mail. ⚠️
            <br>
            ⚠️ Este link expira em 10 minutos. ⚠️
        </td>
    </tr>

    <tr>
        <td align="center" style="font-size: 14px; padding-top: 25px">
            Estamos aqui para ajudar no que precisar!
        </td>
    </tr>

    <tr>
        <td align="center" style="font-weight: bold; font-size:16px;">
            Atenciosamente, {!! $data['client'] !!}
        </td>
    </tr>
@endsection
