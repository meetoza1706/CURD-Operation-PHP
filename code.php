<?php
    $conn = new mysqli('localhost', 'root', '', 'student');

    if($conn->connect_error){
        die("Failed to connect to db:" . $conn->connect_error);
    }

    if($_SERVER['REQUEST_METHOD']=='POST'){
       $phone = $_POST['phone'];
       $name = $_POST['name'];
       $email = $_POST['email'];
       $course = $_POST['course'];
    

    $sql = "INSERT INTO student (name, email, course, phone) VALUES ('$name', '$email', '$course', $phone)";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }

      header("Location: " . $_SERVER["PHP_SELF"]);
      
    }

    $fetch = "select * from student";
    $result = $conn->query($fetch);

?>


<!DOCTYPE html>
<html>
    <head>
        <title>CRUD operations</title>
        <link rel="stylesheet" href="style1.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    </head>
    <body>
    
       
        <div class="container">
            <div class="row">
                <div class="column-1">
                    <p class="heading">Student Data</p>
                </div>
                <div class="column-2">
                <button class="addstudent" id="myBtn">Add Student</button>
                </div>
            </div>
            <?php if ($result->num_rows > 0): ?>
            <div style="flex-grow: 1; display: flex; flex-direction: column; justify-content: flex-end;">
                <table>
                    <thead>
                        <tr>
                            <th>name</th>
                            <th>email</th>
                            <th>phone</th>
                            <th>course</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                <td><?php echo htmlspecialchars($row['course']); ?></td>
                                <td>
                                    <form method="post" action="edit.php" style="display:inline;">
                                        <input type="hidden" name="id">
                                        <input type="submit" value="Edit">
                                    </form>
                                    <form method="post" action="view.php" style="display:inline;">
                                        <input type="hidden" name="view">
                                        <input type="submit" value="view">
                                    </form>
                                    <form method="post" action="delete.php" style="display:inline;">
                                        <input type="hidden" name="id">
                                        <input type="submit" value="Delete">
                                    </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        </div>
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <label for="name" class="lname">Name:</label>
                        <input type="text" id="name" class="name" name="name" required>
                    <br>
                    <label for="email" class="lemail">Email:</label>
                        <input type="email" id="email" class="email" name="email" required>.
                    <br>
                    <label for="phone" class="lphone">Phone:</label>
                        <input type="text" id="phone" name="phone" class="phone" required>
                    <br>
                    <div class="radio">
                    <p>Choose Course:</p>
                        <input type="radio" id="IT" name="course" value="IT">
                        <label for="IT">IT</label><br>
                        <input type="radio" id="CE" name="course" value="CE">
                        <label for="CE">CE</label><br>
                        <input type="radio" id="AIML" name="course" value="AIML">
                        <label for="AIML">AIML</label><br><br>
                        <input type="submit" value="Submit">
                    </div>
                </form>
            </div>
        </div>
        <script>
            var modal = document.getElementById("myModal");

            // Get the button that opens the modal
            var btn = document.getElementById("myBtn");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks the button, open the modal
            btn.onclick = function() {
            modal.style.display = "block";
            }

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
            modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
            }
        </script>
    </body>
</html>

<?php 
     $conn->close();
?>