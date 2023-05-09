{{-- <h1>hello</h1> --}}
<!DOCTYPE html>
<html>
<head>
<style>
table, td, th {
  border: 1px solid black;
}

table {
  border-collapse: collapse;
  width: 50%;
}
</style>
</head>
<body>

<h2>Noor Game "Games And Player Data" </h2>

{{-- <p>Set the width of the table to 50%:</p> --}}

<table>
  <tr>
    <th>No</th>
    <th>Full Name</th>
    <th>Number</th>
    <th>Email</th>
    <th>Face Book Name</th>
    <th>Balamce Load</th>
    <th>Spiner Key</th>
  </tr>
  @foreach ($details as $data)
  <tr>
    <td> {{ $loop->iteration }}</td>
    <td>{{ $data->full_name }}</td>
    <td>{{ $data->number }}</td>
    <td>{{ $data->email }}</td>
    <td>{{ $data->facebook_name }}</td>
    <td>{{ $data->balance }}</td>
    <td>{{ $data->token }}</td>
  </tr>
  @endforeach
 
  
</table>

</body>
</html>
