@extends('welcom')
<title>Magazine</title>
@section('main_content')
    <form style="font-size: 300%;" method="post" action='/entrance/check/mag'>
        @csrf
        <p id="selectionMessage"></p>

        <label for="groupSelect">Выберите группу:   </label>
        <select style="font-size: 60%;     margin-left: 25px;
" id="groupSelect" name="groupSelect" value="group">
            <option value="">Выберите группу</option>
            @foreach ($groupNames as $groupName)
                <option value="{{ $groupName }}">{{ $groupName }}</option>
            @endforeach
        </select>
<br>
        <label for="subject">Выберите предмет:</label>
        <select style="font-size: 60%;"  id="subject" name="subject" value="{subject}">
            <option value="">Выберите предмет</option>
            @foreach ($subjectNames as $subName)
                <option value="{{ $subName }}">{{ $subName }}</option>
            @endforeach
        </select>
<br>
        <button style="font-size: 60%;"  type="submit" onclick="transferDataToForm3()">подтвердить</button>
    </form>

    <script >
        window.id={{$id}};
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
        window.localStorage.setItem('id',{{$id}} );
        function transferDataToForm3() {
            // Capture values from Form 1
            const selectedGroup = document.getElementById('groupSelect').value;
            const selectedSubject = document.getElementById('subject').value;
            window.localStorage.setItem('selectedGroup', selectedGroup);
            window.localStorage.setItem('selectedSubject', selectedSubject);


        }
    </script>
@endsection
