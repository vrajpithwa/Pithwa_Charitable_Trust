<!DOCTYPE html>
<html>

<head>
  <title>PHP - Upload image to database - Example</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
  <link href="form.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <div class="phppot-container">
    <h1>Upload image to database:</h1>
    <form action="imgupload.php" method="post" enctype="multipart/form-data">
      <div class="row">
        <input type="file" name="image" accept="image/*">
        <input type="submit" value="Upload">
      </div>
    </form>

    <h2>Uploaded Image (Displayed from the database)</h2>
  </div>
</body>

</html>
