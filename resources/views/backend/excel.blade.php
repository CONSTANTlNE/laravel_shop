@extends('frontend.components.layout')

@section('admin-excel')
    <div class="card overflow-visible card-style m-0 mb-3">
        <div class="content mb-0">
            <div class="d-flex justify-content-center gap-2 align-items-center mb-2">
                <h4 class="mb-0 text-center">Excel Import</h4>
            </div>

            <div class="d-flex flex-column justify-content-center align-items-center g-3">
                <div class="col-12 col-lg-6">
                    <div class="card card-style">
                        <div class="content">
                            <h5 class="mb-3">Upload Categories, Subcategories & Products (XLSX)</h5>
                            <form action="{{ route('excel.categories') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-custom mb-3 form-floating">
                                    <input type="file" name="file" accept=".xlsx" class="form-control rounded-xs" id="xlsx_file">
                                </div>
                                <button class="btn btn-full gradient-green shadow-bg shadow-bg-s">Upload</button>
                            </form>
                            <p class="font-12 opacity-70 mt-2">
                                Expected sheets order: Categories, Subcategories, Products.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="card card-style">
                        <div class="content">
                            <h5 class="mb-3">Upload Product Images from Folder</h5>
                            <form action="{{ route('excel.folder') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-custom mb-3 form-floating">
                                    <input type="text" name="folder_name" class="form-control rounded-xs" id="folder_name" placeholder="Product Name (KA)">
                                    <label for="folder_name" class="color-theme">Product Name (KA)</label>
                                </div>
                                <div class="form-custom mb-3 form-floating">
                                    <input type="file" name="files[]"  webkitdirectory directory multiple class="form-control rounded-xs" id="files">
                                </div>
                                <button class="btn btn-full gradient-blue shadow-bg shadow-bg-s">Upload Images</button>
                            </form>
                            <p class="font-12 opacity-70 mt-2">
                                Select multiple images. They will be processed and attached to the product.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.getElementById('files').addEventListener('change', function (event) {
            console.log('file change works')
            if (event.target.files.length > 0) {
                // Example: "iphone/back.webp"
                let relativePath = event.target.files[0].webkitRelativePath;
                let folder = relativePath.split("/")[0]; // "iphone"

                // document.getElementById('folder').value = folder;
                document.getElementById('folder_name').value = folder;
                console.log("Folder:", folder);
            }
        });

    </script>

@endsection
