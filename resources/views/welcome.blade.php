<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Calculator</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .calculator {
            width: auto;
            max-width: 500px;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 15px 0px rgba(0,0,0,0.2);
            display: flex;
            flex-direction: column;
        }

        .form-control {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ced4da;
            width: 100%;
            box-sizing: border-box;
        }

        select.form-control {
            cursor: pointer;
        }

        .btn {
            padding: 5px 15px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            margin-right: 5px;
        }

        .btn-calculate {
            background-color: #007bff;
            color: white;
            width: 100%;
            margin-top: 10px;
        }

        .btn-calculate:hover {
            background-color: #0056b3;
        }

        .btn-use {
            background-color: #007bff;
            color: white;
        }

        .btn-use:hover {
            background-color: #0056b3;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #dee2e6;
        }

        th {
            background-color: #f2f2f2;
            color: #212529;
            padding: 10px;
            text-align: left;
        }

        td {
            padding: 10px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .action-buttons {
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .action-buttons form,
        .action-buttons button {
            margin: 0;
        }

    </style>
</head>
<body>
    <div class="calculator">
        <h2 style="text-align: center; color: #007bff;">Simple Calculator</h2>
        <form action="/calculate" method="POST">
            @csrf
            <input type="number" name="bil_1" class="form-control" placeholder="Masukkan angka pertama" required>
            <input type="number" name="bil_2" class="form-control" placeholder="Masukkan angka kedua" required>
            <select name="operasi" class="form-control">
                <option value="tambah">Tambah (+)</option>
                <option value="kurang">Kurang (-)</option>
                <option value="bagi">Bagi (/)</option>
                <option value="kali">Kali (*)</option>
                <option value="mod">Modulo (%)</option>
            </select>
            <button type="submit" class="btn btn-calculate">Calculate</button>
        </form>

        @if(isset($calculations) && $calculations->count())
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Operand 1</th>
                        <th>Operasi</th>
                        <th>Operand 2</th>
                        <th>Hasil</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($calculations as $index => $calculation)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $calculation->operand1 }}</td>
                            <td>{{ $calculation->operation }}</td>
                            <td>{{ $calculation->operand2 }}</td>
                            <td>{{ $calculation->result }}</td>
                            <td>
                                <div class="action-buttons">
                                    <button onclick="useCalculation({{ $index }})" class="btn btn-use">Gunakan</button>
                                    <form action="{{ route('calculations.destroy', $calculation->id) }}" method="POST" onsubmit="return confirmDelete()" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Tidak ada operasi yang ditemukan.</p>
        @endif
    </div>

    <script>
    function useCalculation(index) {
        const row = document.querySelectorAll("table tbody tr")[index];
        const operand1 = row.cells[1].textContent;
        const operand2 = row.cells[3].textContent;
        const operation = row.cells[2].textContent;

        document.querySelector('input[name="bil_1"]').value = operand1;
        document.querySelector('input[name="bil_2"]').value = operand2;

        const operationDropdown = document.querySelector('select[name="operasi"]');
        for (let option of operationDropdown.options) {
            if (option.value === operation) {
                option.selected = true;
                break;
            }
        }
    }
    </script>
    <script>
        function confirmDelete() {
            return confirm('Apakah Anda yakin ingin menghapus kalkulasi ini?');
        }
    </script>    
</body>
</html>
