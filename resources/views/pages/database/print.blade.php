<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap" rel="stylesheet">
    <title>Cetak Dokumen</title>
    <style>
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #FAFAFA;
            font-family: 'Roboto Mono', monospace;
            font-size: 13px;
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 15mm;
            margin: 10mm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .subpage {
            padding: 1cm;
            border: 5px red solid;
            height: 257mm;
            outline: 2cm #FFEAEA solid;
        }

        td {
            padding-top: 5px;
        }

        #footer {
            display: none;
        }

        @page {
            size: A4;
            margin: 0;
        }

        @media print {

            html,
            body {
                width: 210mm;
                height: 297mm;
            }

            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }

            #print {
                display: none
            }

            #footer {
                display: block;
                position: fixed;
                bottom: 0;
                left: -20px;
                width: 100%;
                height: 50px;
                background-color: #f2f2f2;
                text-align: center;
                padding-top: 15px;
                font-size: 12px;
            }
        }
    </style>
</head>

<body>
    <div class="book">
        <div class="page">
            <header style="display: flex; justify-content: start; align-items: start">
                <div>
                    <img src="{{ asset('img/lp3i.png') }}" alt="" width="30%" style="text-align: center">
                    <h2>DAFTAR RIWAYAT HIDUP {{ $applicant->name }}</h2>
                    <p>Mahasiswa Politeknik LP3I Kampus Tasikmalaya</p>
                    <p>Program Studi {{ $applicant->program == null ? '___' : $applicant->program }}</p>
                </div>
                {{-- @if ($user->avatar)
                    <img src="https://api.politekniklp3i-tasikmalaya.ac.id/pmbonline/download/{{ $applicant->identity }}/{{ $user->identity }}-{{ $user->avatar }}"
                        alt="Avatar" width="170px">
                @else --}}
                    <div
                        style="border: 1px dotted black; height: 180px; width: 420px;display: flex;justify-content: center;align-items:center">
                        <p>Pas foto 4x3</p>
                    </div>
                {{-- @endif --}}
            </header>
            <hr style="margin-top: 10px;">
            <h3>Biodata Mahasiswa</h3>
            <table style="margin-top: 10px">
                <tr>
                    <td style="width: 200px;">Nama lengkap</td>
                    <td>:</td>
                    <td>{{ $applicant->name == null ? '___' : $applicant->name }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Tempat, Tanggal Lahir</td>
                    <td>:</td>
                    <td>{{ $applicant->place_of_birth == null ? '___' : $applicant->place_of_birth }}
                        /
                        {{ $applicant->date_of_birth == null ? '___' : $applicant->date_of_birth }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Agama</td>
                    <td>:</td>
                    <td>{{ $applicant->religion == null ? '___' : $applicant->religion }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Asal SMA / SMK. Sederajat</td>
                    <td>:</td>
                    <td>{{ $applicant->school == null ? '___' : $applicant->school }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">No. telepon / HP</td>
                    <td>:</td>
                    <td>{{ $applicant->phone == null ? '___' : $applicant->phone }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Alamat</td>
                    <td>:</td>
                    <td>{{ $applicant->address == null ? '___' : $applicant->address }}</td>
                </tr>
            </table>
            <hr style="margin-top: 10px;">
            <h3>Biodata Ayah</h3>
            <table style="margin-top: 10px">
                <tr>
                    <td style="width: 200px;">Nama lengkap</td>
                    <td>:</td>
                    <td>{{ $father->name == null ? '___' : $father->name }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Tempat, Tanggal Lahir</td>
                    <td>:</td>
                    <td>{{ $father->place_of_birth == null ? '___' : $father->place_of_birth }}
                        /
                        {{ $father->date_of_birth == null ? '___' : $father->date_of_birth }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Pendidikan terakhir</td>
                    <td>:</td>
                    <td>{{ $father->education == null ? '___' : $father->education }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">No. telepon / HP</td>
                    <td>:</td>
                    <td>{{ $father->phone == null ? '___' : $father->phone }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Alamat</td>
                    <td>:</td>
                    <td>{{ $father->address == null ? '___' : $father->address }}</td>
                </tr>
            </table>
            <hr style="margin-top: 10px;">
            <h3>Biodata Ibu</h3>
            <table style="margin-top: 10px">
                <tr>
                    <td style="width: 200px;">Nama lengkap</td>
                    <td>:</td>
                    <td>{{ $mother->name == null ? '___' : $mother->name }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Tempat, Tanggal Lahir</td>
                    <td>:</td>
                    <td>{{ $mother->place_of_birth == null ? '___' : $mother->place_of_birth }}
                        /
                        {{ $mother->date_of_birth == null ? '___' : $mother->date_of_birth }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Pendidikan terakhir</td>
                    <td>:</td>
                    <td>{{ $mother->education == null ? '___' : $mother->education }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">No. telepon / HP</td>
                    <td>:</td>
                    <td>{{ $mother->phone == null ? '___' : $mother->phone }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Alamat</td>
                    <td>:</td>
                    <td>{{ $mother->address == null ? '___' : $mother->address }}</td>
                </tr>
            </table>
            <div id="print" style="position: absolute;bottom: 50px;right:50px">
                <button onclick="printCV()">Cetak Daftar Riwayat Hidup</button>
            </div>
            <footer id="footer" style="margin-top: 25px;font-size:10px;text-align:right"></footer>
        </div>
    </div>

    <script>
        const isiTimestamp = () => {
            let footer = document.getElementById('footer');
            let dateTimeString = new Date().toLocaleString();
            footer.innerText = `Dicetak pada tanggal: ${dateTimeString}`;
        }
        isiTimestamp();

        const printCV = () => {
            window.print();
        }
    </script>
</body>

</html>
