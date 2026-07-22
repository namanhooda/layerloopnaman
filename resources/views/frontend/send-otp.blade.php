<!DOCTYPE html>
<html>
<body>

<h2>HTML Forms</h2>

<form action="{{ route('send-otp') }}" method="POST">
    @csrf
  <label for="fname">First name:</label><br>
  <input type="text" id="fname" name="phone" value="8059000064"><br>
  <input type="submit" value="Submit">
</form> 

<p>If you click the "Submit" button, the form-data will be sent to a page called "/action_page.php".</p>

</body>
</html>
