<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            /* padding: 15px; */
        }
    </style>
</head>
<body>
    <table style="width:100%">
        <tr>
            <th>Ten cong ty</th>
            <th style="width:20%">Resource</th> 
            <th>So nhan su</th>
            <th>Thi truong</th>
            <th>Dia chi</th>
            <th>Chi tiet dia chi</th>
            <th>Cong viec</th>
            <th style="width:20%">Muc luong</th>
        </tr>
        @foreach($companies as $company)
        <tr>
            <td>{{ $company['company_name'] }}</td>
            <td>{{ $company['resource'] }}</td> 
            <td>{{ $company['num_employees'] }}</td>
            <td>{{ $company['market'] }}</td>
            <td>{{ $company['address'] }}</td>
            <td><?php echo $company['address_details']; ?> </td>
            <td>{{ $company['job_name'] }}</td> 
            <td> <?php echo $company['job_salary']; ?></td> 
        </tr>
        @endforeach
    </table>
</body>
</html>