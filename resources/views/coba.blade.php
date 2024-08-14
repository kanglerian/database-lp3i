<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
  <div class="py-4">
    <div class="max-w-7xl mx-auto px-5 md:p-0 space-y-5">
      <table>
        <thead>
          <tr>
            <th>No.</th>
            <th>Nama</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($applicants as $applicant)
          <tr>
            <td>1</td>
            <td>nama</td>
          </tr>
          @empty
          <tr>
            <td colspan="2">Tidak ada</td>
          </tr>
          @endforelse
        </tbody>
      </table>
      {{ $applicants->links() }}
    </div>
</div>
</body>
</html>