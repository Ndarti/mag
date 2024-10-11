<title>Entrance</title>
<style>
    body {
        font-family: sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    .container {
        width: 400px;
        margin: 50px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
        box-sizing: border-box;
    }

    button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        width: 100%;
    }

    button:hover {
        background-color: #45a049;
    }

    .error {
        color: red;
        margin-top: 10px;
    }

    /* Hide the group field initially */
    #group {
        display: none;
    }
</style>
<style>
    /* Basic styles for the dropdown menu */
    #userType {
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
</style>
<?php $__env->startSection('main_content'); ?>
    <h1>Добавление пользователей</h1>

    <div id="userForm">
        <form method="post" action="/admin" enctype="multipart/form-data"><?php echo csrf_field(); ?>  <label for="userType">Тип пользователя:</label>
            <select id="userType" name="userType" required>
                <option value="teacher">Преподаватель</option>
                <option value="student">Студент</option>
            </select>
            <label for="userName">Имя:</label>
            <input type="text" id="userName" name="userName" required>

            <label for="userEmail">Email:</label>
            <input type="email" id="userEmail" name="userEmail" required>

            <label for="group" id="a">Группа (только для студентов):</label>
            <input type="text" id="group" name="group">

            <button type="submit" class="add-user-btn">Добавить пользователя</button>
        </form>
    </div>
<div id="userForm">
    <form method="post" action="/user"><?php echo csrf_field(); ?>
    <button type="submit" >Показать всех пользователей</button></form>
</div>
    <div id="userForm">
        <button type="button" id="addGroupBtn">Добавить группу</button> </div>
    <div id="miniForm" style="display: none;">
        <form method="post" action="/group" ><?php echo csrf_field(); ?>
            <label for="email">Enter teacher's email address:</label>
            <input type="email" id="email" name="email" required placeholder="teacher@example.com">
            <label for="group">Group:</label>
            <input type="grou" id="grou" name="grou" required>
            <label for="group">Specialization:</label>
            <input type="sp" id="sp" name="sp" required>
            <label for="group">Course:</label>
            <input type="co" id="co" name="co" required>

            <button type="submit">Добавить</button>
        </form>
    </div>
<br>







    <div id="userForm">
        <button type="button" id="addSubjectBtn">Добавить предмет к группе</button>
    </div>

    <div id="subjectForm" style="display: none;">

        <form method="post" action="/addSubject"><?php echo csrf_field(); ?>
            <label for="groupInput">Группа:</label>
            <input type="text" id="groupInput" name="group" required>
            <label for="subjectInput">Предмет:</label>
            <input type="text" id="subjectInput" name="subject" required>
            <label for="teacherEmailInput">Email преподователя:</label>
            <input type="email" id="teacherEmailInput" name="teacherEmail" required>
            <button type="submit">Добавить</button>
        </form>
    </div>


<script>const addSubjectBtn = document.getElementById('addSubjectBtn');
    const subjectForm = document.getElementById('subjectForm');
    let isSubjectFormOpen = false; // Track the form state (open or closed)

    addSubjectBtn.addEventListener('click', () => {
        isSubjectFormOpen = !isSubjectFormOpen;
        subjectForm.style.display = isSubjectFormOpen ? 'block' : 'none';
    });
</script>



<script> const addGroupBtn = document.getElementById('addGroupBtn');
    const miniForm = document.getElementById('miniForm');
    let isMiniFormOpen = false; // Track the mini form state (open or closed)

    addGroupBtn.addEventListener('click', () => {
        isMiniFormOpen = !isMiniFormOpen; // Toggle the state on each click
        miniForm.style.display = isMiniFormOpen ? 'block' : 'none';
    });

    // Add functionality to handle form submission (e.g., AJAX request to send data)
    miniFormContent.addEventListener('submit', (event) => {
        event.preventDefault(); // Prevent default form submission

        // Get email, group, specialization, and course values from the mini form
        const email = document.getElementById('email').value;
        const group = document.getElementById('group').value;
        const specialization = document.getElementById('specialization').value;
        const course = document.getElementById('course').value;

        // Send data to server (e.g., using AJAX)
        // ...

        // Hide the mini form after successful submission
        miniForm.style.display = 'none';
        isMiniFormOpen = false; // Reset state after submission
    });
</script>
    <script>
        // Add JavaScript logic here
        const userTypeSelect = document.getElementById('userType');
        const groupInput = document.getElementById('group');
        const a = document.getElementById('a');
        userTypeSelect.addEventListener('change', function() {
            const selectedValue = this.value;
            if (selectedValue === 'student') {
                groupInput.style.display = 'block'; // Show group field
                a.style.display = 'block';
            } else {
                groupInput.style.display = 'none'; // Hide group field
                groupInput.value = ''; // Clear group input value
                a.style.display = 'none'; // Hide group field
                a.value = '';
            }
        });
    </script>
    <style>
        /* Add styling for the button */
        .add-user-btn {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }

        .add-user-btn:hover {
            background-color: #45a049; /* Green hover effect */
        }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('welcom', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/liza/Рабочий стол/Дипломное проектирование/Program/ElectronicMagazine/resources/views/admin.blade.php ENDPATH**/ ?>