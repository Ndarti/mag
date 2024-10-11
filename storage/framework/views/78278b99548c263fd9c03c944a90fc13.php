<title>Magazine</title>
<?php $__env->startSection('main_content'); ?>
    <form style="font-size: 300%;" method="post" action='/entrance/check/mag'>
        <?php echo csrf_field(); ?>
        <p id="selectionMessage"></p>

        <label for="groupSelect">Выберите группу:   </label>
        <select style="font-size: 60%;     margin-left: 25px;
" id="groupSelect" name="groupSelect" value="group">
            <option value="">Выберите группу</option>
            <?php $__currentLoopData = $groupNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($groupName); ?>"><?php echo e($groupName); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
<br>
        <label for="subject">Выберите предмет:</label>
        <select style="font-size: 60%;"  id="subject" name="subject" value="{subject}">
            <option value="">Выберите предмет</option>
            <?php $__currentLoopData = $subjectNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($subName); ?>"><?php echo e($subName); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
<br>
        <button style="font-size: 60%;"  type="submit" onclick="transferDataToForm3()">подтвердить</button>
    </form>

    <script >
        window.id=<?php echo e($id); ?>;
        const groupSelect = document.getElementById('groupSelect');
        const subjectSelect = document.getElementById('subject');
        const selectionMessage = document.getElementById('selectionMessage');
        groupSelect.addEventListener('change', function() {
            updateSelectionMessage();
        });
        subjectSelect.addEventListener('change', function() {
            updateSelectionMessage();
        });
        function updateSelectionMessage() {
            const selectedGroup = groupSelect.value;
            const selectedSubject = subjectSelect.value;

            if (selectedGroup && selectedSubject) {
                // Improved message formatting and error handling
                selectionMessage.textContent = `Выбрана группа: ${selectedGroup}, предмет: ${selectedSubject}`;

            }
        else if (selectedGroup) {

            } else if (selectedGroup) {
                selectionMessage.textContent = `Выбрана группа: ${selectedGroup}`;
            } else if (selectedSubject) {
                selectionMessage.textContent = `Выбран предмет: ${selectedSubject}`;
            } else {
                selectionMessage.textContent = 'Ничего не выбрано.';
            }
        }
    </script>
    <script>
        window.localStorage.setItem('id',<?php echo e($id); ?> );
        function transferDataToForm3() {
            // Capture values from Form 1
            const selectedGroup = document.getElementById('groupSelect').value;
            const selectedSubject = document.getElementById('subject').value;
            window.localStorage.setItem('selectedGroup', selectedGroup);
            window.localStorage.setItem('selectedSubject', selectedSubject);


        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('welcom', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/liza/Рабочий стол/Дипломное проектирование/Program/ElectronicMagazine/resources/views/magazin.blade.php ENDPATH**/ ?>