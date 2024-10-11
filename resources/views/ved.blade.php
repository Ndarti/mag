@php use App\Models\EntranceModl;use App\Models\Mag; @endphp
@extends('welcom')
<title>Student Marks</title>
<style>
    .myChart {
        margin-left: -1280px;  height:50%;  width:50%;

    }
    @media print {
        /* Your print-specific styles here */
        table, th, td {
            border: 1px solid black !important; /* Force border styles */
        }
        .add-student-button {
            display: none; /* Hide unnecessary buttons */
        }
    }

    /* Modal Styles */
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

@endsection
