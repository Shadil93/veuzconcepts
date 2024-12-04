<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row">
     <button><a href="" class="btn btn-success ">Admin</a></button>
      <div class="col-4">
      </div>
   
<div class="col-4 mt-5">
<div class="card" style="width: 20rem;">
<div class="card-body">
   <form action="{{route('do_login')}}" method="post">
    @csrf
    <label>email</label>
    <input type="text" name="email" class="form-control">
    <label>Password</label>
    <input type="text" name="password" class="form-control">
    <button type="submit" class="btn btn-success ">submit</button>
   </form>
</div>
</div>
</div>



    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>