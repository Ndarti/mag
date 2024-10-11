@php use App\Models\EntranceModl;use App\Models\Mag; @endphp
@extends('welcom')
<title>Student Marks</title>
<link href="style.css">
<style>
    /* Стили для модального окна */
    .modal {
        display: none; /* Скрывать окно по умолчанию */
        position: fixed; /* Позиционирование относительно окна */
        z-index: 1; /* Отображать поверх других элементов */
        left: 0;
        top: 0;
        width: 100%; /* Ширина на всю страницу */
        height: 100%; /* Высота на всю страницу */
        overflow: auto; /* Добавить прокрутку при необходимости */
        background-color: rgba(0, 0, 0, 0.4); /* Полупрозрачный фон */
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto; /* Отступы вокруг окна */
        padding: 20px;
        border: 1px solid #888;
        width: 20%; /* Ширина окна */
    }

    .modal-header {
        padding: 20px;
        border-bottom: 1px solid #ccc;
    }

    .modal-title {
        margin: 0;
    }

    .modal-close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .modal-close:hover,
    .modal-close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        padding: 20px;
        text-align: center;
    }
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
    @if($uniqueStudentIDs)
    @if (count($uniqueStudentIDs) > 0)
        <table id="q">
            <thead>
            <tr style="border: 1px solid black; padding: 5px; text-align: center;">
                <th style="text-align: left;">ФИО|дата</th>
                @foreach ($magsSortDate as $magSort)
                    <th style="border: 1px solid black; padding: 5px; text-align: center;">{{ date('d.m', strtotime($magSort->date)) }}</th>
                @endforeach
                <th style="text-align: center;">ср-зн</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($uniqueStudentIDs as $studentId)
                @php
                    $student = EntranceModl::find($studentId);
                    $average = 0; // Initialize average variable outside the loop
                    $markCount = 0; // Initialize mark count variable outside the loop
                @endphp
                @if ($student)
                    <tr style="border: 1px solid black; padding: 5px; text-align: center;">
                        <td style="text-align: left;">
                            <button class="add-student-button" data-student-id="{{ $student->id }}">+</button>
                            {{ $student->fio }}
                        </td>
                        @foreach ($magsSortDate as $magSort)
                            <td style="border: 1px solid black; padding: 5px; text-align: center;">
                                @php
                                    $results = Mag::where('id_students', $student->id)
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

                        <td style="text-align: center;">@php $A= number_format($collection->Pop(), 2);  @endphp
    <span style="color: {{ $A < 3 ? 'red' : '' }}">
        {{ $A }}
    </span></td> </tr>
                @else
                    <tr>
                        <td colspan="{{ count($magsSortDate) + 2 }}" style="text-align: center;">Студент с ID: {{ $studentId }} не найден</td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    @endif
    @else
        <p>No students found for the selected group and subject.</p>
    @endif
    <form method="post" action="/controller/action/{data1}/{data2}">
        @csrf
        <input type="hidden" id="hiddenInput1" name="data1">
        <input type="hidden" id="hiddenInput2" name="data2">
        <input type="hidden" id="hiddenInput3" name="data3">
        <div id="editMarkPopup" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1000;">
            <div class="popup-content">
                <span class="close">&times;</span>
                <h4>Enter a new mark</h4>
                <input type="number"  name="newMarkInput"  id="newMarkInput">
                <input type="hidden" name="magsSortDate" value="{{ $magsSortDate }}">
                <input type="hidden" name="groupSelect" value="{{ $Group }}">
                <input type="hidden" name="subject" value="{{ $Subject }}">
                <input type="hidden" name="markCount" value="{{ $markCount }}">
                <input type="hidden" name="studentId" value="{{ $studentId }}">
                <input type="hidden" name="result" value="{{ $result }}">
                <button type="submit" id="saveMarkButton">Save</button>
            </div>
        </div>
        <div id="student-modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2 id="modal-title">Добавить оценку</h2>
                <p id="student-id-text"></p>
                <p id="student-group-text"></p>
            </div>
        </div>
    </form>
    <form method="post" action='/controller/action/new_mark/{data1}/{data2}/{data3}/{data4}/{data5}' class="student-info-modal" style="display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0, 0, 0, 0.4);">
@csrf
        <div class="student-info-modal-content" style="background-color: #fefefe; margin: 15% auto; padding: 20px; width: 300px; border: 1px solid #888; animation-name: FadeIn; animation-duration: 0.4s;">
            <span class="close">×</span>
            <input type="hidden" id="hidden1" name="data1">
            <input type="hidden" id="hidden2" name="data2">
            <input type="hidden" id="hidden3" name="data3">
            <input type="hidden" id="hidden4" name="data4">
            <input type="hidden" id="hidden5" name="data5">
            <h2>ID студента: <span id="student-id"></span></h2>
            <label for="studentDate">Дата:</label>
            <input type="date" id="studentDate" name="studentDate" required value="00:00:00">
            <label for="studentMark">Оценка:</label>
            <select id="studentMark" name="studentMark" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
            </select>
            <input type="hidden" name="magsSortDate" value="{{ $magsSortDate }}">
            <input type="hidden" name="groupSelect" value="{{ $Group }}">
            <input type="hidden" name="subject" value="{{ $Subject }}">
            <input type="hidden" name="markCount" value="{{ $markCount }}">
            <input type="hidden" name="studentId" value="{{ $studentId }}">
            <input type="hidden" name="result" value="{{ $result }}">
            <label for="lessonType">Тип занятия:</label>
            <select id="lessonType" name="lessonType" required>
                <option value="лекция">Лекция</option>
                <option value="практика">Практика</option>
                <option value="зачёт">Зачет</option>
                <option value="лабораторная">Лабораторная</option>
                <option value="окр">Окр.</option>
            </select>
            <button type="submit">Отправить данные</button>
        </div>
    </form>
    @if($uniqueStudentIDs1)
        @if (count($uniqueStudentIDs1) > 0)
            <table id="myTable">
                <thead>
                <tr style="border: 1px solid black; padding: 5px; text-align: center;">
                    <th style="text-align: left;">ФИО|дата</th>
                    @foreach ($magsSortDate1 as $magSort)
                        <th style="border: 1px solid black; padding: 5px; text-align: center;">{{ date('d.m', strtotime($magSort->date)) }}</th>
                    @endforeach
                    <th style="text-align: center;">общ.кол.проп.</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($uniqueStudentIDs1 as $studentId)
                    @php
                        $student = EntranceModl::find($studentId);
                        $average = 0; // Initialize average variable outside the loop
                        $markCount = 0; // Initialize mark count variable outside the loop
                    @endphp
                    @if ($student)
                        <tr style="border: 1px solid black; padding: 5px; text-align: center;">
                            <td style="text-align: left;">
                                <button style="border: none" id="addi {{ $student->id }}" class="op" data-student-id="{{ $student->id }}"  >+</button>
                                {{ $student->fio }}
                            </td>
                            @foreach ($magsSortDate1 as $magSort)
                                <td style="border: 1px solid black; padding: 5px; text-align: center;">
                                    @php
                                        $results = \App\Models\Prop::where('id_students', $student->id)
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
                                                @if ($result->propysc == "да" && $result->hours > 0)
                                                    <button style="color: #eb3aff; background: white; border: none;"
                                                            data-student-id="{{ $student->id }}"
                                                            id="popupButton_{{ $student->id }}_{{ $magSort->date }}"
                                                            data-hours="{{ $result->hours }}"
                                                            onclick="openPopup(this, {{ $student->id }}, '{{$result->date}}')">Н
                                                    </button>
                                                @else
                                                    Н
                                            @endif
                                            @php
                                                $isFirstMark = true;
                                            @endphp
                                        @endforeach
                                    @endif
                                </td>
                            @endforeach
                            <td style="text-align: center;">{{ $collection1->Pop() }}</td> </tr>
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
                <div class="container">
                    <button id="print-button" onclick="printTable()">Печать таблицы</button>
                    <button id="generateReportButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#generateReportModal">Сгенерировать ведомость за месяц</button>






                    <script>
                        // Получить элементы
                        const openModalBtn = document.getElementById('openModalBtn');
                        const modal = document.getElementById('myModal');
                        const closeModalBtn = document.getElementById('closeModalBtn');
                        const modalBody = document.querySelector('.modal-body'); // Получить элемент .modal-body

                        // Открыть модальное окно
                        openModalBtn.addEventListener('click', () => {
                            modal.style.display = 'block';

                            // Динамически добавить форму в modal-body
                            const form = document.createElement('form');
                            const label = document.createElement('label');
                            const yearSelect = document.createElement('select');
                            const generateReportBtn = document.createElement('button');
                            const closeModalBtn = document.createElement('button'); // Создать кнопку "Закрыть"



                        });

                        // Закрыть модальное окно
                        closeModalBtn.addEventListener('click', () => {
                            modal.style.display = 'none';
                        });

                        // Закрыть модальное окно по клику на фон
                        window.onclick = function(event) {
                            if (event.target == modal) {
                                modal.style.display = 'none';
                            }
                        }
                    </script>
























                    <div class="modal fade" id="generateReportModal" tabindex="-1" aria-labelledby="generateReportModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="generateReportModalLabel">Ведомость пропусков</h5>
                                    <button type="button" class="close-button1" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action='/academic_performance' id="generateReportForm" >
                                        @csrf
                                        <div class="month-dropdown">
                                            <input type="hidden" name="groupSelect" value="{{ $Group }}">
                                            <input type="hidden" name="subject" value="{{ $Subject }}">
                                            <label for="monthSelect">Выберите месяц:</label>
                                            <select id="monthSelect" name="month" class="form-select">
                                                <option value="01">Январь</option>
                                                <option value="02">Февраль</option>
                                                <option value="03">Март</option>
                                                <option value="04">Апрель</option>
                                                <option value="05">Май</option>
                                                <option value="06">Июнь</option>
                                                <option value="07">Июль</option>
                                                <option value="08">Август</option>
                                                <option value="09">Сентябрь</option>
                                                <option value="10">Октябрь</option>
                                                <option value="11">Ноябрь</option>
                                                <option value="12">Декабрь</option>
                                            </select>
                                        </div>
                                        <button id="submitButton" type="submit" class="submit-button">Отправить</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </table>
            <div id="miniForm" style="text-align: center;">
                <div class="win">
                    <span class="close-icon">&times;</span>
                    <form id="form" method="post" action="/new_prop">@csrf
                        <input type="hidden" id="studentIdInput1" name="studentId">
                        <input type="hidden" id="dateInputHidden1" name="date">  <div class="date-selector">
                            <label for="dateInput1">Дата:</label>
                            <input type="date" id="dateInput1" required>
                        </div>
                        <input type="hidden" id="hoursInput" name="hours">
                        <input type="hidden" name="groupSelect" value="{{ $Group }}">
                        <input type="hidden" name="subject" value="{{ $Subject }}">
                        <input type="hidden" name="monthSelect" value={{$month}}>
                        <label for="oursInput">Кол. часов:</label>
                        <div class="number-selector">
                            <input type="number" style="margin-left: -50px; margin-top: 16px;" id="numberInput" min="0" value="0">
                        </div>
                        <button style="margin-left: 10px;" type="submit">Добавить</button>
                    </form>
                </div>
            </div>
            <script>
                const numberInput11 = document.getElementById('numberInput');
                const hoursInput11 = document.getElementById('hoursInput');

                const form11 = document.getElementById('form');
                form11.addEventListener('submit', () => {
                    hoursInput11.value = numberInput11.value;
                });
                // Get the elements
                const dateInput11 = document.getElementById('dateInput1');
                const dateInputHidden11 = document.getElementById('dateInputHidden1');
                dateInput11.addEventListener('change', () => {
                    dateInputHidden11.value = dateInput11.value;
                });
                const miniForm1 = document.getElementById('miniForm');
                const closeButton0 = document.querySelector('.close-icon');
                const modalButton1 = document.querySelector('.modal-button');
                const addStudentButtons1 = document.querySelectorAll('.op');
                miniForm1.style.display = 'none';
                // Add event listener to the button
                addStudentButtons1.forEach((button, index) => {
                    button.addEventListener('click', () => {
                        const studentId = button.dataset.studentId; // Get student ID
                        document.getElementById('studentIdInput1').value = studentId;
                        miniForm1.style.display='block';

                        // Pre-populate form fields or perform other actions based on studentId
                        console.log("Clicked button for student:", studentId);
                    });
                });
                // Add event listener to close button (if needed)
                closeButton0.addEventListener('click', () => {
                    miniForm1.style.display='none'
                });
                // Add event listener to submit button (if needed)
                modalButton1.addEventListener('click', (event) => {
                    // Prevent default form submission if needed
                    event.preventDefault();

                    // Submit form data or perform other actions
                    console.log("Form submitted for student:", studentId);
                });

            </script>
            <div id="popup">
                <form id="popupForm" method="post" action="/mes_prop">
                    @csrf
                    <span id="popupButton" class="close">&times;</span>
                    <p id="studentIdText">Студент ID: --</p>
                    <p id="hoursText">Часов отсутствия: --</p>
                    <p id="date">Дата: --</p>
                    <input type="hidden" id="studentIdInput" name="studentId">
                    <input type="hidden" id="hoursInput" name="hours">
                    <input type="hidden" id="dateIN" name="date">
                    <button type="submit">Отработано</button>
                    <input type="hidden" name="groupSelect" value="{{ $Group }}">
                    <input type="hidden" name="subject" value="{{ $Subject }}">
                    <input type="hidden" name="monthSelect" value={{$month}}>
                </form>
            </div>
            <script>
                function printTable() {
                    document.getElementById('print-button').style.display = 'none';
                    document.getElementById('q').style.display = 'none';
                    document.getElementById('generateReportButton').style.display = 'none';
                    document.getElementById('generateReportButton1').style.display = 'none';
                    window.print();
                }
            </script>
            <script>
                function openPopup(buttonElement, studentId, date, hours) {
                    const popup = document.getElementById('popup');
                    const hours1 = buttonElement.dataset.hours;
                    // Set student ID, hours, and date in popup content
                    document.getElementById('studentIdText').textContent = "Студент ID: " + studentId;
                    document.getElementById('hoursText').textContent = "Часов отсутствия: " + hours1;
                    document.getElementById('date').textContent = "Дата: " + date;
                    document.getElementById('studentIdInput').value = studentId;
                    document.getElementById('hoursInput').value = hours;
                    document.getElementById('dateIN').value = date;

                    popup.style.display = 'block';
                }

                const closeButtonPopup = document.getElementById('popupButton');
                // Add event listener to the close button for absence popup
                closeButtonPopup.addEventListener('click', () => {
                    const popup = document.getElementById('popup');
                    popup.style.display = 'none';
                });

                const addStudentButtons = document.querySelectorAll('.add-student-button');
                const studentInfoModal = document.querySelector('.student-info-modal');
                const studentIdSpan = studentInfoModal.querySelector('#student-id');
                const closeButtonInfo = studentInfoModal.querySelector('.close');

                const sSubject = window.localStorage.getItem('selectedSubject');

                addStudentButtons.forEach(button => {
                    button.addEventListener('click', (event) => {
                        const studentId = button.dataset.studentId;

                        window.Group = @json($Group);
                        const group=@json($Group);
                        // Display student info modal
                        studentInfoModal.style.display = 'block';
                        studentIdSpan.textContent = studentId;
                        document.getElementById('hidden1').value = sSubject;
                        document.getElementById('hidden2').value = studentId;
                        document.getElementById('hidden3').value = group;
                        document.getElementById('hidden4').value = window.localStorage.getItem('id');
                        document.getElementById('hidden5').value = "нет"; // Absence status (modify based on your logic)

                        // Close student info modal on click
                        closeButtonInfo.addEventListener('click', () => {
                            studentInfoModal.style.display = 'none';
                        });
                    });
                });
            </script>
            <script>
                let result; // Declare result outside the function for access in saveMarkButton handler
                let mark; // Declare mark outside the function for access in saveMarkButton handler
                const redMarkButtons = document.querySelectorAll('.red-mark');
                const editMarkPopup = document.getElementById('editMarkPopup');
                const newMarkInputForEdit = document.getElementById('newMarkInput');
                const saveMarkButton = document.getElementById('saveMarkButton');
                const editMarkCloseButton = document.querySelector('.close'); // Unique name

                redMarkButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const markValue = button.textContent;
                        newMarkInputForEdit.value = markValue;
                        result = this.dataset.resultId; // Use "this" for current button data
                        mark = markValue;
                        editMarkPopup.style.display = 'block';
                    });
                });

                editMarkCloseButton.addEventListener('click', () => {
                    editMarkPopup.style.display = 'none';
                });

                saveMarkButton.addEventListener('click', () => {
                    const storedGroup = window.localStorage.getItem('selectedGroup');
                    const storedSubject = window.localStorage.getItem('selectedSubject');
                    if (storedGroup && storedSubject) {
                        document.getElementById('hiddenInput1').value = `отметка: ${newMarkInputForEdit.value}`; // Use newMarkInputForEdit
                        document.getElementById('hiddenInput3').value = result;
                    }
                });
            </script>
            <script>
                let result; // Declare result outside the function for access in saveMarkButton handler
                let mark; // Declare mark outside the function for access in saveMarkButton handler
                const redMarkButtons = document.querySelectorAll('.red-mark0');
                const editMarkPopup = document.getElementById('editMarkPopup');
                const newMarkInputForEdit = document.getElementById('newMarkInput');
                const saveMarkButton = document.getElementById('saveMarkButton');
                const editMarkCloseButton = document.querySelector('.close'); // Unique name

                redMarkButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const markValue = button.textContent;
                        newMarkInputForEdit.value = markValue;
                        result = this.dataset.resultId; // Use "this" for current button data
                        mark = markValue;
                        editMarkPopup.style.display = 'block';
                    });
                });

                editMarkCloseButton.addEventListener('click', () => {
                    editMarkPopup.style.display = 'none';
                });

                saveMarkButton.addEventListener('click', () => {
                    const storedGroup = window.localStorage.getItem('selectedGroup');
                    const storedSubject = window.localStorage.getItem('selectedSubject');
                    if (storedGroup && storedSubject) {
                        document.getElementById('hiddenInput1').value = `отметка: ${newMarkInputForEdit.value}`; // Use newMarkInputForEdit
                        document.getElementById('hiddenInput3').value = result;
                    }
                });
            </script>
            <script>
                document.getElementById('studentDate').valueAsDate = new Date();
                document.getElementById('studentDate').valueAsDate.setHours(0, 0, 0, 0);
            </script>
            <script  src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js">
                // Add event listener to the Generate Report button
                const generateReportButton = document.getElementById('generateReportButton');
                generateReportButton.addEventListener('click', (event) => {
                    event.preventDefault(); // Prevent default form submission

                    // Open the modal
                    const generateReportModal = document.getElementById('generateReportModal');
                    generateReportModal.show();
                });
                // Add event listener to the Submit button within the modal
                const submitButton = document.getElementById('submitButton');
                submitButton.addEventListener('click', (event) => {
                    event.preventDefault(); // Prevent default form submission
                    // Get the selected month
                    const selectedMonth = document.getElementById('monthSelect').value;
                });
                // Function to display the report data in the modal
                function displayReport(reportData) {
                    // Clear any existing report content
                    const reportContainer = document.querySelector('.report-container');
                    reportContainer.innerHTML = '';

                    // Create and display the report table
                    const reportTable = document.createElement('table');
                    reportTable.classList.add('report-table');
                    // Create table header row
                    const tableHeaderRow = reportTable.insertRow();
                    const tableHeaders = ['Student Name', ...reportData[0].subjects]; // Assuming subjects are the first row
                    tableHeaders.forEach(header => {
                        const tableHeaderCell = tableHeaderRow.insertCell();
                        tableHeaderCell.textContent = header;
                    });
                    // Create and display table body rows
                    reportData.forEach(student => {
                        const tableBodyRow = reportTable.insertRow();
                        const studentNameCell = tableBodyRow.insertCell();
                        studentNameCell.textContent = student.name;

                        student.subjects.forEach((subjectMark, index) => {
                            const subjectMarkCell = tableBodyRow.insertCell();
                            subjectMarkCell.textContent = subjectMark;
                        });
                    });
                    // Append the report table to the container
                    reportContainer.appendChild(reportTable);

                    // Show the report container
                    reportContainer.style.display = 'block';
                }
            </script>
            <script> var id = window.localStorage.getItem('id');
                const addStudentButtons = document.querySelectorAll('.add-student-button1');
                const studentInfoModal = document.querySelector('.student-info-modal');
                const studentIdSpan = studentInfoModal.querySelector('#student-id');
                const closeButton = studentInfoModal.querySelector('.close');

                const sSubject = window.localStorage.getItem('selectedSubject');
                addStudentButtons.forEach(button => {
                    button.addEventListener('click', (event) => {
                        const studentId = button.dataset.studentId;
                        const group = document.getElementById('Group');
                        // Отображение мини-окна
                        studentInfoModal.style.display = 'block';
                        studentIdSpan.textContent = studentId;
                        window.Group = @json($Group);
                        const a=@json($Group);
                        document.getElementById('hidden1').value =sSubject;
                        document.getElementById('hidden2').value=studentId;
                        document.getElementById('hidden3').value=a;//группа
                        document.getElementById('hidden4').value=id;//ид учитель
                        document.getElementById('hidden5').value="нет";//пропуск
                        // Закрытие мини-окна по нажатию на крестик
                        closeButton.addEventListener('click', () => {
                            studentInfoModal.style.display = 'none';
                        });
                    });
                });</script>
            @endsection
