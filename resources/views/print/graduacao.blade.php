<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receituário - Clínica Focal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 550px;
            background: #fff;
            margin: 30px auto;
            padding: 30px 30px 10px 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px #bbb;
            position: relative;
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .logo {
            width: 80px;
            height: 80px;
            background: #cce2f7;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            font-size: 38px;
            color: #1d3d6b;
            font-weight: bold;
        }

        .clinic-info {
            flex: 1;
        }

        .clinic-info h2 {
            margin: 0 0 2px 0;
            color: #1d3d6b;
            font-size: 23px;
            letter-spacing: 1px;
        }

        .clinic-info small {
            color: #3498db;
            font-size: 14px;
        }

        .section-title {
            font-weight: bold;
            margin-top: 18px;
            margin-bottom: 6px;
            font-size: 15px;
            color: #1d3d6b;
        }

        .table-receita {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .table-receita th,
        .table-receita td {
            border: 1px solid #b7cbe5;
            text-align: center;
            padding: 4px 6px;
            font-size: 15px;
        }

        .table-receita th {
            background: #e5f0fa;
            font-weight: normal;
        }

        .obs-section {
            margin-top: 20px;
            font-size: 14px;
            margin-bottom: 22px;
        }

        .obs-section strong {
            display: block;
            margin-bottom: 5px;
            color: #1d3d6b;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-bottom: 18px;
            margin-top: 18px;
        }

        .info-row span {
            border-bottom: 1px solid #888;
            display: inline-block;
            min-width: 70px;
            padding: 1px 10px 0px 10px;
            text-align: center;
            margin: 0 4px;
        }

        .assinatura {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
        }

        .assinatura-line {
            border-bottom: 1px solid #888;
            width: 65%;
            margin: 20px auto 5px auto;
            height: 18px;
        }

        .footer {
            margin-top: 24px;
            background: #e5f0fa;
            border-radius: 6px;
            padding: 6px 10px;
            font-size: 13px;
            color: #1d3d6b;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer .social {
            display: flex;
            gap: 7px;
            color: #3498db;
            font-weight: bold;
        }

        @media (max-width: 600px) {
            .container {
                padding: 10px 2vw;
            }

            .logo {
                width: 55px;
                height: 55px;
                font-size: 22px;
            }

            .footer {
                flex-direction: column;
                gap: 4px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo"><img src="{{ get_option('logo_site') }}"></div>
            <div class="clinic-info">
                <h2>{{ get_option('title_site') }}</h2>
                <small>Sua visão é o nosso foco</small>
            </div>
        </div>
        <div>
            <span>Para Sr(a): ____________________________________</span>
        </div>
        <div class="section-title">Longe:</div>
        <table class="table-receita">
            <tr>
                <th></th>
                <th>Esférico</th>
                <th>Cilíndrico</th>
                <th>Eixo</th>
                <th>Dnp</th>
            </tr>
            <tr>
                <td>OD:</td>
                <td>{{ $graduacoe->longe_od_esferico }}</td>
                <td>{{ $graduacoe->longe_od_cilindrico }}</td>
                <td>{{ $graduacoe->longe_od_eixo }}</td>
                <td>{{ $graduacoe->longe_od_dnp }}</td>
            </tr>
            <tr>
                <td>OE:</td>
                <td>{{ $graduacoe->longe_oe_esferico }}</td>
                <td>{{ $graduacoe->longe_oe_cilindrico }}</td>
                <td>{{ $graduacoe->longe_oe_eixo }}</td>
                <td>{{ $graduacoe->longe_oe_dnp }}</td>
            </tr>
        </table>
        <div class="section-title">Perto:</div>
        <table class="table-receita">
            <tr>
                <th></th>
                <th>Esférico</th>
                <th>Cilíndrico</th>
                <th>Eixo</th>
                <th>Dnp</th>
            </tr>
            <tr>
                <td>OD:</td>
                <td>{{ $graduacoe->perto_od_esferico }}</td>
                <td>{{ $graduacoe->perto_od_cilindrico }}</td>
                <td>{{ $graduacoe->perto_od_eixo }}</td>
                <td>{{ $graduacoe->perto_od_dnp }}</td>
            </tr>
            <tr>
                <td>OE:</td>
                <td>{{ $graduacoe->perto_oe_esferico }}</td>
                <td>{{ $graduacoe->perto_oe_cilindrico }}</td>
                <td>{{ $graduacoe->perto_oe_eixo }}</td>
                <td>{{ $graduacoe->perto_oe_dnp }}</td>
            </tr>
        </table>
        <div class="section-title">Adição:</div>
        <table class="table-receita" style="width: 60%; margin-bottom:12px;">
            <tr>
                <th>OD</th>
                <th>OE</th>
            </tr>
            <tr>
                <td>{{ $graduacoe->adicao_od ? $graduacoe->adicao_od : '--' }}</td>
                <td>{{ $graduacoe->adicao_oe ? $graduacoe->adicao_oe : '--' }}</td>
            </tr>
        </table>
        <div class="obs-section">
            <strong>Observações:</strong>
            <ul style="margin:0 0 0 16px;padding:0;list-style: disc;">
                <li>Faça os óculos em Óticas Especializadas.</li>
                <li>Favor trazer os óculos para ser conferido.</li>
                <li>Favor medir <b>DNP</b> com pupilômetro.</li>
                <li>Com Certificado de garantia de adaptação.</li>
                <li>MULTIFOCAL/AR/FILTRO AZUL. SUGIRO ZEISS VARILUX ESSILOR</li>
            </ul>
            <p>
                {{ $graduacoe->observacoes ? $graduacoe->observacoes : '' }}
            </p>
        </div>
        <div class="info-row">
            <div>
                FEIRA DE SANTANA {{ get_option('contact_section_city') }} {{ dataFormatada() }}
            </div>
        </div>
        <div class="assinatura">
            <div class="assinatura-line"></div>
            Assinatura
        </div>
        <div class="footer">
            <span>{{ get_option('contact_section_address') }}</span>
            <span class="social">
                @clinicafocal &nbsp;|&nbsp; Tel. {{ get_option('contact_section_phone') }}
            </span>
        </div>
    </div>
</body>

</html>
