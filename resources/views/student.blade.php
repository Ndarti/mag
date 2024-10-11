@php use App\Models\EntranceModl;use App\Models\Mag; @endphp
@extends('welcom')
<style>

    #miniForm {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 20px;
        border: 1px solid #ccc;
        z-index: 100; /* Убедитесь, что всплывающее окно находится поверх других элементов */
    }

    /* Modal window */
    .win {
        background-color: #fff;  /* White background */
    }

    /* Close icon */
    .close-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
        color: rgba(0, 0, 0, 0.5);  /* Transparent black */
    }

    .close-icon:hover {
        color: #999;  /* Light gray on hover */
    }

    /* Number selector */
    .number-selector {
        display: flex;
        align-items: center;
        margin: 10px 0;  /* Add some spacing */
    }

    #numberInput {
        width: 50px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 5px;
        font-size: 16px;
    }

    /* Arrow buttons (Choose a preferred option) */

    /* Option 1: Minimalist Arrows */
    .arrow-up,
    .arrow-down {
        display: inline-block;
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-bottom: 8px solid #333;  /* Adjust color */
        margin: 0 5px;
        cursor: pointer;
    }

    .arrow-down {
        transform: rotate(180deg);
    }


    .arrow-up {
        transform: translateY(-2px);
    }

    .arrow-down {
        transform: translateY(2px);
    }

    /* Submit button */
    .modal-button {
        background-color: #3399ff;  /* Blue background */
        color: #fff;  /* White text */
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .modal-button:hover {
        background-color: #2277cc;  /* Darker blue on hover */
    }
    /* Style the form */
    #form {
        display: flex;
        justify-content: center;
    }

    /* Style the submit button */
    .modal-button {
        background-color: #333;  /* Darker color */
        color: #fff;  /* White text */
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;  /* Changes cursor to hand on hover */
    }

    .modal-button:hover {
        background-color: #444;  /* Darker on hover */
    }

    /* Стили для кнопки */
    #N {
        background-color: #ffffff;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
    }

    /* Стили для всплывающего окна */
    #popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 20px;
        border: 1px solid #ccc;
        z-index: 100; /* Убедитесь, что всплывающее окно находится поверх других элементов */
    }

    /* Стили для кнопки внутри всплывающего окна */
    #popupButton1 {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
    }
    /* Button styles */
    #open-modal-button {
        border: none;
        background-color: #ffffff;
    }

    /* Modal form styles */
    #modal-form {
        display: none; /* Initially hidden */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto; /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 80%; /* Could be more or less, depending on design */
    }

    .close-button {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close-button:hover,
    .close-button:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .modal-dialog {
        max-width: 300px; /* Adjust as needed for your content */
        margin: 30px auto;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .modal-content {
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        padding: 20px;
        text-align: center;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #ddd;
        margin-bottom: 15px;
    }

    .modal-title {
        font-weight: bold;
        font-size: 1.75rem;
    }

    .close-button {
        cursor: pointer;
        font-size: 24px; /* Adjust as needed */
        font-weight: bold;
        color: #999;
        transition: color 0.3s ease;
        position: absolute; /* Position the close button absolutely */
        top: 15px; /* Adjust the top position as needed */
        right: 15px; /* Adjust the right position as needed */
        padding: 5px; /* Add padding if desired */
        border-radius: 5px; /* Add rounded corners if desired */
        border: none; /* Remove default button border */
        background-color: transparent; /* Make the button transparent by default */
    }

    .close-button:hover {
        color: #000;
    }

    .modal-body {
        flex-grow: 1; /* Allow modal content to grow vertically */
    }

    /* Report Container Styles */
    .report-container {
        margin-top: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 15px;
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
    }

    .report-table th, .report-table td {
        padding: 5px;
        border: 1px solid #ddd;
    }

    .report-table th {
        text-align: left;
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .report-download-button {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .report-download-button:hover {
        background-color: #0056b3;
    }



    .modal-content {
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        padding: 20px;
        text-align: center;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #ddd;
        margin-bottom: 15px;
    }

    .modal-title {
        font-weight: bold;
        font-size: 1.75rem;
    }

    .close-button {
        cursor: pointer;
        font-size: 20px;
        font-weight: bold;
        color: #999;
        transition: color 0.3s ease;
    }

    .close-button:hover {
        color: #000;
    }

    .modal-body {
        flex-grow: 1; /* Allow modal content to grow vertically */
    }

    /* Report Container Styles */
    .report-container {
        margin-top: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 15px;
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
    }

    .report-table th, .report-table td {
        padding: 5px;
        border: 1px solid #ddd;
    }

    .report-table th {
        text-align: left;
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .report-download-button {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .report-download-button:hover {
        background-color: #0056b3;
    }

    /* Модальное окно */
    .student-info-modal {
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;

        background-color: rgba(0, 0, 0, 0.4);
        display: none; /* Скрыть по умолчанию */
    }

    /* Содержимое модального окна */
    .student-info-modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        width: 350px; /* Увеличенная ширина */
        padding: 20px;
        border: 1px solid #888;
        border-radius: 5px; /* Скругленные углы */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Тень */
        animation: modalFadeIn 0.4s ease-in-out; /* Анимация появления */
    }

    @keyframes modalFadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Кнопка закрытия */
    .close {
        position: absolute;
        top: 10px;
        right: 15px;
        cursor: pointer;
        font-size: 20px;
        font-weight: bold;
    }

    .close:hover {
        color: #f00;
    }

    /* Заголовок */
    h2 {
        margin-top: 0;
        text-align: center;
    }

    /* Поля формы */
    label {
        display: block;
        margin-bottom: 5px;
    }

    input[type="date"],
    select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    /* Кнопка отправки */
    button[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background-color: #45a049;
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

    /* Стили формы */

    /* Стили кнопки закрытия */
    #close-student-modal {
        float: right; /* Размещение кнопки справа */
        background-color: #ccc;
        color: black;
        padding: 8px 12px;
        border: none;
        border-radius: 5px; /* Закругленные углы */
        cursor: pointer;
    }

    #close-student-modal:hover {
        background-color: #ddd;
    }
    #group-id-data {
        font-size: 0.8em; /* Уменьшить размер шрифта на 20% */
        color: #818181; /* Светло-серый цвет */
    }

    .modal {
        display: none; /* Скрыть мини-окно по умолчанию */
        position: fixed; /* Позиционировать мини-окно относительно окна */
        z-index: 1; /* Определить приоритет отображения мини-окна */
        left: 0;
        top: 0;
        width: 100%; /* Занять всю ширину окна */
        height: 100%; /* Занять всю высоту окна */
        overflow: auto; /* Добавить прокрутку, если содержимое мини-окна больше, чем его высота */
        background-color: rgba(0, 0, 0, 0.4); /* Полупрозрачный фон */
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto; /* Центрировать содержимое мини-окна */
        padding: 20px;
        border: 1px solid #888;
        width: 80%; /* Определить ширину содержимого мини-окна */
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

    #student-modal {
        /* Добавьте стили для мини-окна с информацией о студенте */
    }

    #student-id-text {
        /* Добавьте стили для параграфа с ID студента */
    }

    #student-form {
        /* Добавьте стили для формы */
    }


    .add-student-button {
        display: inline-block; /* Установка кнопка как блочный элемент */
        width: 20px; /* Уменьшить ширину до 20px */
        height: 20px; /* Уменьшить высоту до 20px */
        border-radius: 50%; /* Скругление углов до 50% для создания круглой формы */
        background-color: #514087; /* Цвет фона кнопки */
        color: white; /* Цвет текста кнопки */
        border: none; /* Убрать обводку кнопки */
        cursor: auto;
        transition: background-color 0.3s; /* Добавить эффект плавного изменения цвета при наведении */
    }

    .add-student-button:hover {
        background-color: #45a049; /* Цвет фона кнопки при наведении */
    }

    td.empty {
        background-color: #f5f5f5; /* Светло-серый фон */
        font-style: italic; /* Наклонный шрифт */
    }
    thead th {
        position: sticky; /* Фиксировать заголовки */
        top: 0; /* Привязать к верху таблицы */
        background-color: #f2f2f2; /* Цвет фона заголовков */
    }

    th, td {
        text-align: left; /* Выравнивание по левому краю по умолчанию */
    }

    .numeric {
        text-align: right; /* Выравнивание числовых значений по правому краю */
    }

    .center {
        text-align: center; /* Выравнивание по центру */
    }

    @media (max-width: 600px) {
        table {
            width: 100%; /* 100% ширины на маленьких экранах */
        }

        th, td {
            font-size: 14px; /* Уменьшение размера шрифта на маленьких экранах */
        }
    }

    h2 {
        text-align: center; /* Выравнивание заголовка таблицы по центру */
        margin-bottom: 20px; /* Отступ снизу заголовка */
    }

    td:first-child,
    th:first-child {
        text-align: center; /* Выравнивание первого столбца по центру */
    }

    .numeric {
        text-align: right; /* Выравнивание числовых столбцов по правому краю */
    }

    tr:nth-child(odd) {
        background-color: #fff; /* Светлый фон для нечетных строк */
    }

    tr:nth-child(even) {
        background-color: #f5f5f5; /* Слегка более темный фон для четных строк */
    }

    table {
        border-collapse: collapse; /* Объединение границ ячеек */
        margin: 20px 0; /* Отступы вокруг таблицы */
    }

    th, td {
        padding: 8px; /* Отступы внутри ячеек */
        border: 1px solid #ddd; /* Границы ячеек */
        text-align: left; /* Выравнивание текста по левому краю */
    }

    th {
        background-color: #f2f2f2; /* Цвет фона заголовков */
        font-weight: bold; /* Жирный шрифт для заголовков */
    }

    #editMarkPopup {
        background-color: #f5f5f5; /* Light gray background */
        border: 1px solid #ddd; /* Light border */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        padding: 20px;
        border-radius: 5px; /* Rounded corners */
        width: 300px; /* Set a fixed width for the popup */
        font-family: Arial, sans-serif; /* Specify a clean font */
    }

    .popup-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center; /* Center text within the popup */
    }

    .close {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        font-size: 20px;
        color: #ccc; /* Light gray close button color */
    }

    .close:hover {
        color: #333; /* Dark gray on hover */
    }

    h2 {
        margin: 0 0 10px; /* Spacing between heading and content */
        font-size: 18px; /* Adjust heading size */
        color: #333; /* Darker text color for emphasis */
    }

    p {
        margin: 0 0 10px; /* Spacing between label and input */
        font-size: 14px; /* Adjust label size */
        color: #666; /* Lighter text color for description */
    }

    #newMarkInput {
        padding: 10px;
        border: 1px solid #ccc; /* Light border for input field */
        border-radius: 3px; /* Rounded corners for input field */
        width: 100%; /* Make input field fill available space */
    }

    #saveMarkButton {
        background-color: #4CAF50; /* Green color for button */
        border: none;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 10px 0; /* Spacing below button */
        cursor: pointer;
        border-radius: 5px; /* Rounded corners for button */
        transition: background-color 0.2s ease-in-out; /* Smooth transition on hover */
    }

    #saveMarkButton:hover {
        background-color: #3e8e41; /* Darker green on hover */
    }
    #saveMarkButton {
        background-color: #4CAF50; /* Зеленый цвет */
        border: none;
        color: white;
        padding: 10px 20px 10px 32px; /* Дополнительное пространство для иконки */
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 5px; /* Скругленные углы */
    }

    #saveMarkButton i {
        margin-right: 5px; /* Отступ от иконки до текста */
    }

    #saveMarkButton {
        background-color: #4CAF50; /* Зеленый цвет */
        border: none;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 5px; /* Скругленные углы */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3); /* Тень */
    }

    #saveMarkButton:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); /* Тень при наведении */
    }
    #saveMarkButton {
        background-color: #4CAF50; /* Зеленый цвет */
        background: -webkit-linear-gradient(to right, #4CAF50 0%, #3e8e41 100%); /* Градиент */
        border: none;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 5px; /* Скругленные углы */
    }

    #saveMarkButton:hover {
        background: -webkit-linear-gradient(to right, #3e8e41 0%, #4CAF50 100%); /* Градиент при наведении */
    }
    #saveMarkButton {
        background-color: #4CAF50; /* Зеленый цвет */
        border: none;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 5px; /* Скругленные углы */
    }

    #saveMarkButton:hover {
        background-color: #3e8e41; /* Темно-зеленый цвет при наведении */
    }

    table {
        border: 1px solid black;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid black;
        padding: 5px;
    }

    .red-mark {
        color: red;
        border: none;
        background: none;
        padding: 0;
        cursor: pointer;
    }
    .red-mark0 {
        border: none;
        background: none;
        padding: 0;
        cursor: pointer;
    }
    #editMarkPopup {
        background-color: #fff;
        padding: 20px;
        border: 1px solid #ccc;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .popup-content {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .close {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        font-size: 20px;
    }

    .close:hover {
        color: red;
    }
</style>
@section('main_content')
@if($uniqueStudentIDs1)
    @if (count($uniqueStudentIDs1) > 0)
        <table id="myTable">
            <thead>
            <tr style="border: 1px solid black; padding: 5px; text-align: center;">
                <th style="text-align: left;">ФИО|дата</th>
                @foreach ($magsSortDate1 as $magSort)
                    <th style="border: 1px solid black; padding: 5px; text-align: center;">{{ date('d.m', strtotime($magSort->date)) }}</th>
                @endforeach
                <th style="text-align: center;">ср.оц</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($uniqueStudentIDs1 as $studentId)
                @php
                    $student = \App\Models\Subject::find($studentId);
                    $average = 0; // Initialize average variable outside the loop
                    $markCount = 0; // Initialize mark count variable outside the loop
                @endphp
                @if ($student)
                    <tr style="border: 1px solid black; padding: 5px; text-align: center;">
                        <td style="text-align: left;">
                           <d style="border: none" id="addi {{ $student->id }}" class="op" data-student-id="{{ $student->id }}">
                            {{ $student->subject_name }}</d>
                        </td>
                        @foreach ($magsSortDate1 as $magSort)
                            <td style="border: 1px solid black; padding: 5px; text-align: center;">

                                @php
                                    $studentId1 =  $user1->id ;
                                       $results = Mag::where('id_subj', $studentId)
                                         ->where('id_students',$studentId1)
                                         ->where('date', $magSort->date)
                                         ->get();
                                @endphp
                                @if ($results->isEmpty())
                                @else
                                    @php
                                        $isFirstMark = false;
                                    @endphp
                                    @foreach ($results as $result)
                                        @if (!$isFirstMark)
                                            &nbsp;  @endif
                                        @if ($result->mark < 4 && $result->tip_mark!="лекция" && $result->tip_mark!="зачёт")
                                            <button class='red-mark' style='cursor: pointer;' data-result-id='{{ $result->id }}'>{{ $result->mark }}</button>
                                        @elseif($result->tip_mark=="зачёт")
                                            зч
                                        @else
                                            <button class='red-mark' style='color:black; cursor: pointer;' data-result-id='{{ $result->id }}'>{{ $result->mark }}</button>

                                        @endif
                                        @php
                                            $isFirstMark = true;
                                        @endphp
                                    @endforeach
                                @endif
                            </td>
                        @endforeach

                        <td style="text-align: center;">  @php $A= number_format($collection->Pop(), 2);  @endphp
    <span style="color: {{ $A < 3 ? 'red' : '' }}">
        {{ $A }}
    </span> </td> </tr>
                @else
                    <tr>
                        <td colspan="{{ count($magsSortDate) + 2 }}" style="text-align: center;">Студент с ID: {{ $studentId }} не найден</td>
                    </tr>
                @endif
            @endforeach
            </tbody>
            @endif
            @else
                <p>Select month.</p>
            @endif

        </table>



        @endsection
