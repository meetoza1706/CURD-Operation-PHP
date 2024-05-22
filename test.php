<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal Test</title>
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

<div id="data-container">
    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Course</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Dummy data -->
            <tr>
                <td>John Doe</td>
                <td>john@example.com</td>
                <td>123-456-7890</td>
                <td>IT</td>
                <td>
                    <button type="button" class="viewBtn" data-name="John Doe" data-email="john@example.com" data-phone="123-456-7890" data-course="IT">
                        View
                    </button>
                </td>
            </tr>
            <tr>
                <td>Jane Smith</td>
                <td>jane@example.com</td>
                <td>098-765-4321</td>
                <td>CE</td>
                <td>
                    <button type="button" class="viewBtn" data-name="Jane Smith" data-email="jane@example.com" data-phone="098-765-4321" data-course="CE">
                        View
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div id="myModal2" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form class="form">
            <label for="name" class="lname">Name:</label>
            <input type="text" id="name" class="name" name="name" readonly>
            <br>
            <label for="email" class="lemail">Email:</label>
            <input type="email" id="email" class="email" name="email" readonly>
            <br>
            <label for="phone" class="lphone">Phone:</label>
            <input type="text" id="phone" name="phone" class="phone" readonly>
            <br>
            <div class="radio">
                <p>Choose Course:</p>
                <input type="radio" id="IT" name="course" value="IT" disabled>
                <label for="IT">IT</label><br>
                <input type="radio" id="CE" name="course" value="CE" disabled>
                <label for="CE">CE</label><br>
                <input type="radio" id="AIML" name="course" value="AIML" disabled>
                <label for="AIML">AIML</label><br><br>
            </div>
        </form>
    </div>
</div>

<script>
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
        
        document.getElementById('myModal2').style.display = 'block';
    }
});

// Close the modal when the user clicks on <span> (x)
document.querySelector('.close').onclick = function() {
    document.getElementById('myModal2').style.display = 'none';
}

// Close the modal when the user clicks anywhere outside of the modal
window.onclick = function(event) {
    if (event.target == document.getElementById('myModal2')) {
        document.getElementById('myModal2').style.display = 'none';
    }
}
</script>

</body>
</html>
