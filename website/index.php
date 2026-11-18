<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>SUPMIT - Student Checking App</title>
    </head>

    <body>
        <h1>Student Checking App</h1>
        <ul>
            <form action="" method="POST">
                <button type="submit" name="submit">List Student</button>
            </form>

            <?php
              if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
                  $username = getenv('API_USERNAME') ?: (getenv('USERNAME') ?: 'admin');
                  $password = getenv('API_PASSWORD') ?: (getenv('PASSWORD') ?: 'changeme');
                  $url = getenv('API_URL') ?: 'http://backend:5000/supmit/api/v1.0/get_student_ages';

                  $context = stream_context_create(array(
                      'http' => array(
                          'header' => 'Authorization: Basic ' . base64_encode("$username:$password"),
                          'timeout' => 5,
                      ),
                  ));

                  $response = @file_get_contents($url, false, $context);
                  if ($response === false) {
                      echo "<p style='color:red;'>Unable to reach Student API at " . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . ".</p>";
                  } else {
                      $list = json_decode($response, true);
                      if (is_array($list) && isset($list['student_ages']) && is_array($list['student_ages'])) {
                          echo "<p style='color:red; font-size: 20px;'>This is the list of the student with age</p>";
                          foreach ($list['student_ages'] as $key => $value) {
                              $safeKey = htmlspecialchars((string)$key, ENT_QUOTES, 'UTF-8');
                              $safeVal = htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
                              echo "- $safeKey is $safeVal years old <br>";
                          }
                      } else {
                          echo "<p style='color:red;'>Unexpected response format from Student API.</p>";
                      }
                  }
              }
            ?>
        </ul>
    </body>
</html>
