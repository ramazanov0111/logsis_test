<!DOCTYPE html>
<html lang="ru">
<head>
    <link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700&subset=latin,cyrillic' rel='stylesheet'
          type='text/css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="...">
    <meta name="keywords" content="...">
    <title>Тест</title>
</head>

<body>
<h2 class="text-center m-15" font="">Схема БД</h2>
<div class="container mt-3 mb-3">
    <div class="row">
        <div class="col-sm">
            <table class="table table-bordered">
                <thead class="table-dark">
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">title</th>
                    <th scope="col">price</th>
                </tr>
                </thead>
                <tbody>
                @foreach($books as $book)
                    <tr>
                        <td>{{ $book->id }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->price }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-sm">
            <table class="table table-bordered">
                <thead class="table-dark">
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">FIO</th>
                </tr>
                </thead>
                <tbody>
                @foreach($authors as $author)
                    <tr>
                        <td>{{ $author->id }}</td>
                        <td>{{ $author->fio }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-sm">
            <table class="table table-bordered">
                <thead class="table-dark">
                <tr>
                    <th scope="col">book_id</th>
                    <th scope="col">author_id</th>
                </tr>
                </thead>
                <tbody>
                @foreach($book_authors as $book_author)
                    <tr>
                        <td>{{ $book_author->book_id }}</td>
                        <td>{{ $book_author->author_id }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<hr>
<div class="container">
    <h3>1. выбрать книгу из выпадающего списка и увидеть список ее авторов</h3>
    <form id="ajax-form1" method="POST">
        @csrf
        <select name="book_id" id="book_id" class="form-select form-select-sm">
            <option selected>Выберите книгу</option>
            @foreach($books as $book)
                <option value="{{ $book->id }}">{{ $book->title }}</option>
            @endforeach
        </select>
        <input class="btn btn-dark mt-2" type="submit" value="Получить список">
    </form>

    <br>
    <pre><span id="result"></span></pre>
</div>

<hr>
<div class="container">
    <h3>2. выбрать автора из выпадающего списка и увидеть суммарную стоимость всех книг этого автора</h3>
    <form id="ajax-form2" method="POST">
        @csrf
        <select name="author_id" id="author_id" class="form-select form-select-sm">
            <option selected>Выберите автора</option>
            @foreach($authors as $author)
                <option value="{{ $author->id }}">{{ $author->fio }}</option>
            @endforeach
        </select>
        <input class="btn btn-dark mt-2" type="submit" value="Получить сумму">
    </form>

    <span id="sum"></span>
</div>

<hr>
<div class="container">
    <h3>3. увидеть список всех книг, для которых не указаны авторы</h3>
    <ul>
        @foreach($without_authors as $without_author)
            <li>{{ $without_author->title }}</li>
        @endforeach
    </ul>
</div>

</body>

<script type="text/javascript">
    $('#ajax-form1').submit(function (e) {
        e.preventDefault();
        $.ajax({
            data: $(this).serialize(),
            type: 'POST',
            url: '{{ route('authors') }}',
            success: function (data) {
                $('#result').html(data);
            }
        });
    });
    $('#ajax-form2').submit(function (e) {
        e.preventDefault();
        $.ajax({
            data: $(this).serialize(),
            type: 'POST',
            url: '{{ route('books') }}',
            success: function (data) {
                $('#sum').html(data);
            }
        });
    });
</script>

</html>
