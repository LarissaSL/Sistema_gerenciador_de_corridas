@extends('template.emailTemplate')

@section('content')
    <tr>
        <td align="center" style="padding: 10px 0; font-size: 16px">
            Olá, <strong>{!! $data['nameUser'] !!}!</strong><br>
            Digite o código de verificação abaixo para acessar a Plataforma.
        </td>
    </tr>

    <tr>
        <td align="center" style="font-size: 16px; font-weight: bold; padding-top: 25px">
            <strong>Seu código de verificação é:</strong>
        </td>
    </tr>


    <tr>
        <td align="center" style="padding: 15px 0">
            <table cellpadding="20" cellspacing="0" border="0"
                style="background: #F1A001;color: #ffffff;font-size: 24px;font-weight: bold;border-radius: 5px;">
                <tbody>
                    <tr>
                        <td>{!! $data['token'] !!}</td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>

    <tr>
        <td align="center" style="padding-bottom: 25px; font-size: 14px; font-weight: bold;">
            ⚠️ Este token expira em 10 minutos.
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
