<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<form action="{{route('excel.categories')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file">
    <button>categories</button>
</form>

<br>

<form action="{{route('excel.subcategories')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file">
    <button>subcategories</button>
</form>

<br>

<form action="{{route('excel.products')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file">
    <button>products</button>
</form>
<br>

<form action="{{route('excel.folder')}}" method="post"  enctype="multipart/form-data">
    @csrf
    <input type="file" id="files" name="files[]" webkitdirectory directory multiple>
    <input type="hidden" name="folder" id="folder">
    <button>Folder</button> <span id="folder_name"></span>
</form>

<script>
    document.getElementById('files').addEventListener('change', function (event) {
        console.log('file change works')
        if (event.target.files.length > 0) {
            // Example: "iphone/back.webp"
            let relativePath = event.target.files[0].webkitRelativePath;
            let folder = relativePath.split("/")[0]; // "iphone"

            document.getElementById('folder').value = folder;
            document.getElementById('folder_name').innerHTML = folder;
            console.log("Folder:", folder);
        }
    });

</script>
</body>
</html>
