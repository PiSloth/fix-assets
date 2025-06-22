{{-- <div>

    {{ $data['assembly']['name'] }}
    {{ $data['assembly']['code'] }}
    {{ $data['assembly']['remark'] }}
    {{ $data['assembly']['location'] }}
    {{-- <img src="{{ asset('storage/' . $data['assembly']['image']) }}" /> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Item Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #f5f5f5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 12px 16px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        caption {
            caption-side: top;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }


        .info-wrapper {
            display: grid;
            /* grid-template-columns: 1fr 1fr; */
            /* Two equal columns */
            gap: 20px;
            max-width: 100%;
            /* You can set max-width: 190mm for A4 print */
            margin-bottom: 20px;
        }

        .info-block {
            /* background-color: #f9f9f9;
            padding: 16px;
            border-radius: 8px;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.1);
            font-family: Arial, sans-serif;
            line-height: 1.6; */
        }

        .info-block div {
            margin-bottom: 8px;
        }

        .info-title {
            font-weight: bold;
        }

        .wrapper {
            display: grid;
            grid-template-columns: 100px 100px 100px;
            grid-gap: 10px;
            background-color: #fff;
            color: #444;
        }

        .box {
            background-color: #444;
            color: #fff;
            border-radius: 5px;
            padding: 20px;
            font-size: 150%;
        }
    </style>
</head>

<body>
    <caption>{{ $data['title']['text'] }}</caption>
    <span>{{ \Rabbit::uni2zg('ရက်စွဲ') }}: {{ \Carbon\Carbon::now()->format('j M y') }}</span>

    <table width="100%" cellpadding="10" cellspacing="0" border="0" style="margin-bottom: 20px;">
        <tr>
            <!-- Left Info -->
            <td width="50%" valign="top" style="border: 1px solid #ccc; background-color: #f9f9f9;">
                <strong>Name:</strong> {{ $data['assembly']['name'] }}<br>
                <strong>Code :</strong> {{ $data['assembly']['code'] }}<br>
                <strong>Remark:</strong> {{ $data['assembly']['remark'] }}<br>
                <strong>Location:</strong> {{ $data['assembly']['location'] }}
            </td>

            <!-- Right Info -->
            <td width="50%" valign="top" style="border: 1px solid #ccc; background-color: #f9f9f9;">
                <strong>Responsible:</strong> {{ $data['responsible']['name'] }}<br>
                <strong>ID:</strong> {{ $data['responsible']['stt_id'] }}<br>
                <strong>Department:</strong> {{ $data['responsible']['department'] }}<br>
                <strong>Position:</strong> {{ $data['responsible']['position'] }}<br>
                <strong>Phone:</strong> {{ $data['responsible']['phone'] }}
            </td>
        </tr>
    </table>
    {{-- New Owner --}}
    <table width="100%" cellpadding="10" cellspacing="0" border="0" style="margin-bottom: 20px;">
        <tr>
            <!-- Left Info -->
            <td width="50%" valign="top" style="border: 1px solid #ccc; background-color: #f9f9f9;">
                <strong>New Owner:</strong> {{ $data['newOwner']['name'] }}<br>
                <strong>ID:</strong> {{ $data['newOwner']['stt_id'] }}<br>
                <strong>Department:</strong> {{ $data['newOwner']['department'] }}<br>
                <strong>Position:</strong> {{ $data['newOwner']['position'] }}<br>
                <strong>Phone:</strong> {{ $data['newOwner']['phone'] }}
            </td>
            <!-- Approver Info -->
            <td width="50%" valign="top" style="border: 1px solid #ccc; background-color: #f9f9f9;">
                <strong>Approver:</strong> {{ $data['approver']['name'] }}<br>
                <strong>Email:</strong> {{ $data['approver']['email'] }}
                {{-- <strong>ID:</strong> {{ $data['newOwner']['stt_id'] }}<br> --}}
                {{-- <strong>Department:</strong> {{ $data['newOwner']['department'] }}<br> --}}
                {{-- <strong>Position:</strong> {{ $data['newOwner']['position'] }}<br> --}}
            </td>
        </tr>
    </table>

    <p>
        <strong>{{ $data['newOwner']['termto'] }} : </strong> {{ $data['newOwner']['reason'] }}
    </p>

    <table>
        <thead>
            <tr>
                <th>{{ \Rabbit::uni2zg('ပစ္စည်း အမျိုးအစား') }}</th>
                <th>Serial Number</th>
                <th>{{ \Rabbit::uni2zg('အသေးစိတ်ဖော်ပြချက်') }}</th>
                <th>{{ \Rabbit::uni2zg('မှတ်ချက်') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['serial'] }}</td>
                    <td>{{ $item['desc'] }}</td>
                    <td>{{ $item['remark'] }}</td>
                </tr>
            @empty
                <span>Empty</span>
            @endforelse
        </tbody>
    </table>

    <br><br>
    <table width="100%" cellpadding="10" cellspacing="0" border="0">
        <tr>
            <td align="center" width="33%">
                <strong>{{ \Rabbit::uni2zg('လွှဲပြောင်းသူ') }}</strong><br><br><br><br>
                ________________________<br>


            </td>
            <td align="center" width="33%">
                <strong>{{ \Rabbit::uni2zg('Admin ဌာန ကိုယ်စားလှယ်') }}</strong><br><br><br><br>
                ________________________<br>

            </td>
            <td align="center" width="33%">
                <strong>{{ \Rabbit::uni2zg('လက်ခံသူ တာဝန်ခံ') }}</strong><br><br><br><br>
                ________________________<br>

            </td>
        </tr>
    </table>


</body>

</html>
