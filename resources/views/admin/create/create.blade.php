<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manage Blogs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1>Manage Blogs</h1>
    <button class="btn btn-primary" id="addBlog">Add Blog</button>
    <button class="btn btn-danger"><a href="{{ route('logout') }}" class="text-light text-decoration-none">Logout</a></button>

    <table class="table table-bordered mt-3">
        <thead>
        <tr>
            <th>Name</th>
            <th>Date</th>
            <th>Author</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="blogTableBody">
        </tbody>
    </table>
</div>

<!-- Blog Modal -->
<div class="modal fade" id="blogModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="blogForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Blog</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="blogId" name="id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" id="date" class="form-control" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="author" class="form-label">Author</label>
                        <input type="text" id="author" class="form-control" name="author" required>
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">Content</label>
                     
                        <textarea id="content" class="form-control" name="content"></textarea>

                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" id="image" class="form-control" name="image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>




tinymce.init({
    selector: '#content',
    plugins: 'lists link image table',
    toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image',
    setup: function (editor) {
        editor.on('change', function () {
            editor.save(); // Ensures the content is synchronized with the hidden textarea
        });
    }
});










$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});



    // Initialize TinyMCE
    tinymce.init({
        selector: '#content',
        plugins: 'lists link image table',
        toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image'
    });

    $(document).ready(function () {
        // Fetch blogs
        fetchBlogs();

        function fetchBlogs() {
            $.get('/blogs/fetch', function (data) {
                let rows = '';
                data.forEach(blog => {
                    rows += `
                        <tr>
                            <td>${blog.name}</td>
                            <td>${blog.date}</td>
                            <td>${blog.author}</td>
                            <td>
                                ${blog.image ? `<img src="/storage/${blog.image}" alt="Image" style="width: 100px;">` : 'No Image'}
                            </td>
                            <td>
                                <button class="btn btn-info edit" data-id="${blog.id}">Edit</button>
                                <button class="btn btn-danger delete" data-id="${blog.id}">Delete</button>
                            </td>
                        </tr>`;
                });
                $('#blogTableBody').html(rows);
            });
        }











        $('#blogForm').submit(function (e) {
    e.preventDefault();
    const id = $('#blogId').val();
    const url = id ? `/blogs/${id}` : '/blogs';
    const method = id ? 'PUT' : 'POST';
    const formData = new FormData(this);
    formData.append('content', tinymce.get('content').getContent()); // Ensure content is included

    $.ajax({
        url: url,
        method: method,
        data: formData,
        processData: false,
        contentType: false,
        success: function () {
            $('#blogModal').modal('hide');
            fetchBlogs();
            alert('Blog saved successfully!');
        },
        error: function (xhr) {
            console.error('Error:', xhr);
            alert('Error saving blog: ' + (xhr.responseJSON?.message || 'Please check your input.'));
        }
    });
});









        // Show modal for adding a new blog
        $('#addBlog').click(function () {
            $('#blogForm')[0].reset();
            $('#blogId').val('');
            tinymce.get('content').setContent('');
            $('#blogModal').modal('show');
        });

        // Save blog
        $('#blogForm').submit(function (e) {
            e.preventDefault();
            const id = $('#blogId').val();
            const url = id ? `/blogs/${id}` : '/blogs';
            const method = id ? 'PUT' : 'POST';
            const formData = new FormData(this);

            $.ajax({
                url: url,
                method: method,
                data: formData,
                processData: false,
                contentType: false,
                success: function () {
                    $('#blogModal').modal('hide');
                    fetchBlogs();
                },
                error: function (xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        });

        // Delete blog
        $(document).on('click', '.delete', function () {
            const id = $(this).data('id');
            if (confirm('Are you sure you want to delete this blog?')) {
                $.ajax({
                    url: `/blogs/${id}`,
                    method: 'DELETE',
                    success: function () {
                        fetchBlogs();
                    }
                });
            }
        });

        // Edit blog
        $(document).on('click', '.edit', function () {
            const id = $(this).data('id');
            $.get(`/blogs/fetch`, function (data) {
                const blog = data.find(b => b.id == id);
                $('#blogId').val(blog.id);
                $('#name').val(blog.name);
                $('#date').val(blog.date);
                $('#author').val(blog.author);
                tinymce.get('content').setContent(blog.content);
                $('#blogModal').modal('show');
            });
        });
    });
</script>
</body>
</html>
