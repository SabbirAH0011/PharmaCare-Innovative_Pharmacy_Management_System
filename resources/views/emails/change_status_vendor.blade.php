<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Anek+Bangla&display=swap');
    body {
        font-family: 'Anek Bangla', sans-serif;
    }

    .card {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
        width: 100%;
    }

    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

    .container {
        padding: 2px 16px;
    }

    .table-section {
        padding: 2rem;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    .header {
        background-color: #33AAFF;
        color: white;
        width: 100%;
        text-align: center;
    }

    .logo {
        padding-top: 1rem;
        padding-bottom: 1rem;
        font-family: 'Anek Bangla', sans-serif;
    }

    td {
        padding-top: 12px;
        padding-left: 12px;
        padding-bottom: 12px;
        text-align: left;
    }

    th {
        padding-top: 12px;
        padding-left: 12px;
        padding-bottom: 12px;
        text-align: left;
    }
</style>

<body>
    <div class="card">
        <div class="container">
            <div class="header">
                <h2 class="logo">Pharma Check</h4>
            </div>
            <p>{{ $text }}:</p>
            <div class="table-section">
                <table>
                    <tr>
                        <th>স্টোর : </th>
                        <td>{{ $store_name }}</td>
                    </tr>
                    <tr>
                        <th>লোকেশন: </th>
                        <td>{{ $location }}</td>
                    </tr>
                    <tr>
                        <th>স্টেটাস: </th>
                        <td>{{ $status }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
