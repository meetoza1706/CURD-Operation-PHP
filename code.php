<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_id'])) {
        $user_id = $_POST['delete_id'];
        $deleteSql = "DELETE FROM student WHERE user_id = $user_id";
        if ($conn->query($deleteSql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        $phone = $_POST['phone'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $course = $_POST['course'];

        $sql = "INSERT INTO student (name, email, course, phone) VALUES ('$name', '$email', '$course', '$phone')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit;
}

$fetch = "SELECT * FROM student";
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
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Course</th>
                        <th>Action</th>
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
                                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['user_id']); ?>">
                                <input type="submit" value="Edit">
                            </form>
                            <button type="button" class="viewBtn" data-name="<?php echo htmlspecialchars($row['name']); ?>" data-email="<?php echo htmlspecialchars($row['email']); ?>" data-phone="<?php echo htmlspecialchars($row['phone']); ?>" data-course="<?php echo htmlspecialchars($row['course']); ?>">
                                View
                            </button>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($row['user_id']); ?>">
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

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form class="form" id="studentForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="name" class="lname">Name:</label>
                <input type="text" id="name" class="name" name="name" required>
                <br>
                <label for="email" class="lemail">Email:</label>
                <input type="email" id="email" class="email" name="email" required>
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
                </div>
                <input type="submit" id="submitBtn" value="Submit" class="submit">
            </form>
        </div>
    </div>

    <script>
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("myBtn");
        var span = document.getElementsByClassName("close")[0];
        var submitBtn = document.getElementById("submitBtn");

        btn.onclick = function() {
            document.getElementById('studentForm').reset();
            setFormEditable(true);
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        document.querySelectorAll('.viewBtn').forEach(button => {
            button.onclick = function() {
                const name = this.getAttribute('data-name');
                const email = this.getAttribute('data-email');
                const phone = this.getAttribute('data-phone');
                const course = this.getAttribute('data-course');
                
                document.getElementById('name').value = name;
                document.getElementById('email').value = email;
                document.getElementById('phone').value = phone;

                document.getElementById(course).checked = true;

                setFormEditable(false);
                modal.style.display = 'block';
            }
        });

        function setFormEditable(editable) {
            document.getElementById('name').readOnly = !editable;
            document.getElementById('email').readOnly = !editable;
            document.getElementById('phone').readOnly = !editable;

            document.getElementById('IT').disabled = !editable;
            document.getElementById('CE').disabled = !editable;
            document.getElementById('AIML').disabled = !editable;

            submitBtn.disabled = !editable;
        }
    </script>
</body>
</html>

<?php 
$conn->close();
?>
