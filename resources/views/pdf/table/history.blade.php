<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <style type="text/css" media="all">
        h1 {
            font-size: 1.875rem
                /* 30px */
            ;
            line-height: 2.25rem
                /* 36px */
            ;
            font-weight: 700;
            line-height: 1.25;
            text-align: center;
        }

        div {
            display: flex;
            justify-content: space-between;
        }

        h2 {
            font-weight: 500;
            font-size: 0.875rem
                /* 14px */
            ;
            line-height: 1.25rem
                /* 20px */
            ;
        }

        h2:first-of-type {
            float: left;
            width: 25%;
        }

        h2:last-of-type {
            margin-left: 35%;
            width: 65%;
            text-align: right;
        }

        table {
            min-width: 100%;
            table-layout: fixed;
            text-indent: 0;
            border-color: inherit;
            border-collapse: collapse;
            border: 1px solid rgb(229 231 235 / 1);
        }

        thead {
            background-color: rgb(243 244 246 / 1);
        }

        th {
            padding-top: 0.75rem
                /* 12px */
            ;
            padding-bottom: 0.75rem
                /* 12px */
            ;
            padding-left: 1.5rem
                /* 24px */
            ;
            padding-right: 1.5rem
                /* 24px */
            ;
            font-size: 0.75rem
                /* 12px */
            ;
            line-height: 1rem
                /* 16px */
            ;
            font-weight: 500;
            letter-spacing: 0.05em;
            text-align: left;
            color: rgb(55 65 81 / 1);
            text-transform: uppercase;
        }

        tbody {
            background-color: rgb(255 255 255 / 1);
            border: 1px solid rgb(229 231 235 / 1);
        }

        tbody tr:nth-of-type(even) {
            background-color: rgb(249 250 251 / 1);
        }

        td {
            padding-top: 1rem
                /* 16px */
            ;
            padding-bottom: 1rem
                /* 16px */
            ;
            padding-left: 1.5rem
                /* 24px */
            ;
            padding-right: 1.5rem
                /* 24px */
            ;
            font-size: 0.875rem
                /* 14px */
            ;
            line-height: 1.25rem
                /* 20px */
            ;
            font-weight: 500;
            color: rgb(17 24 39 / 1);
            white-space: nowrap;
        }

    </style>
</head>

<body>
    <header>
        <h1>Table History</h1>
        <h2>
            Date: {{ Carbon\Carbon::now()->toDateString() }}
        </h2>
        <h2>
            Generate by: {{ Auth::user()->name }}
        </h2>
    </header>

    <table>
        <thead>
            <tr>
                <th scope="col">
                    id
                </th>
                <th scope="col">
                    Employee Name
                </th>
                <th scope="col">
                    total
                </th>
                <th scope="col">
                    status
                </th>
                <th scope="col">
                    Created At
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaction as $data)
                <tr>
                    <td>
                        {{ explode('-', $data->id)[0] }}
                    </td>
                    <td>
                        {{ $data->user->name }}
                    </td>
                    <td>
                        {{ 'Rp ' . number_format($data->total, 2, ',', '.') }}
                    </td>
                    <td>
                        {{ $data->status }}
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($data->created_at)->format('Y-m-d') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @env('local')
    <script src="http://localhost:3000/browser-sync/browser-sync-client.js"></script>
    @endenv
</body>

</html>
