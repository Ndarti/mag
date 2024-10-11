<?php

namespace App\Http\Controllers;


use App\Models\Groop_Teacher;
use App\Models\Group;
use App\Models\Mag;
use App\Models\Subject;
use App\Models\User;
use Exception;
use http\Message;
use Illuminate\Http\Request;
use App\Models\EntranceModl;
use Illuminate\Support\Facades\Auth;

use function React\Promise\all;

class EntranceController extends Controller
{
    public function entrance()
    {
        return view('entrance');
    }
    public function mag_check_entrance(Request $request)
{
    $markCount=0;$aa=0;
    $magsSortDate=null;$uniqueStudentIDs=null;$col=null;$result=null;
    $studentId=0;
  //dd($request->all());
$Group=$request->input('groupSelect');
$Subject=$request->input('subject');
    $month = $request->input('monthSelect');
echo "Группа: ".$Group."  Предмет: ".$Subject;
    $groupModel = Group::where('group_name', $Group)->first();
    $subjectsModel = Subject::where('subject_name', $Subject)->first();
    if ($groupModel&&$subjectsModel)  {
        $groupId = $groupModel->id;
        $subId = $subjectsModel->id;
        $mags = Mag::where('id_group', $groupId)
            ->where('id_subj', $subId)
            ->get();
        $uniqueStudentIDs = [];
        foreach ($mags as $mag) {
            // Extract the student ID
            $studentId = $mag->id_students;
            // Check if the student ID is already in the unique array
            if (!in_array($studentId, $uniqueStudentIDs)) {
                // Add the student ID to the unique array
                $uniqueStudentIDs[] = $studentId;
            }
        }
        $magsSortDate = Mag::where('id_group', $groupId)
            ->where('id_subj', $subId)
            ->selectRaw('MAX(id) AS id, date')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        foreach ($magsSortDate as $magSort) {
            $aa= $magSort->id_teacher;
            // Format date without year
            $dateWithoutYear = date('d.m', strtotime($magSort->date));
        }
        $collection = collect();
        $col  = collect();
        $studentAverages = [];
        foreach ($uniqueStudentIDs as $studentId) {
            $student = EntranceModl::find($studentId);

            if ($student) {
                // Display marks for each date and calculate average
                $average = 0; // Initialize average variable outside the loop
                $markCount = 0; // Initialize mark count variable outside the loop
                $sum = 0;
                $lec=0;
                $a=0;
                $current_estimate=0;
                foreach ($magsSortDate as $magSort) {
                    $results = Mag::where('id_students', $student->id)
                        ->where('date', $magSort->date)
                        ->get();
                    if ($results->isEmpty());
                        else {
                      // Initialize sum variable for average calculation
                        foreach ($results as $result) {
                            if( $result->tip_mark!=null && $result->tip_mark!="зачёт"){
                                 $sum += $result->mark; // Add mark to sum
                                    $markCount++; // Increment mark count for all marks


                            }

                        }
                        $average =  $markCount; // Calculate average only if marks exist
                    }
                }
                if($average!=0)    {


     $average =$sum/($average) ;
       $collection->push($average);

            }
        }
        foreach ($collection as $item) {

            $col->push($collection->Pop());
        }
    }}
    return view('mag', [
        "magsSortDate" => $magsSortDate,
"uniqueStudentIDs" => $uniqueStudentIDs,
        "Group"=>$Group,
        "Subject"=>$Subject,
        "collection"=>$col ,
        "markCount"=>$markCount,
        "studentId"=>$studentId,
"result"=>$result,
        "teacher"=>$aa,
        "magsSortDate1" => null,
        "uniqueStudentIDs1" => null,
        "Group1"=>null,
        "Subject1"=>null,
        "collection1"=>null ,
        "markCount1"=>null,
        "studentId1"=>null,
        "result1"=>null,
        "teacher1"=>null,"month"=>$month,

    ]);
}
    public function check_entrance(Request $request)
    {$month = $request->input('monthSelect');
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();
        if (!$user) {
            // User not found
            return back()->withErrors(['email' => 'User not found.']);
        }
if($user->statys=="teacher")
{

        if ($user->password === $password) {
            // User login successful (be cautious of security risks)
            $fio = $user->fio; // Assuming 'fio' is the column name
            $statys = $user->statys;
            $id = $user->id;
            $id1 = $user->id;
            echo "Welcome, " . " "." ". $fio . "!\n";
            ///////////////////////////////////////////////////////////////////////////////
            //1)сделать выборку по группам для конкр преподователя id  связь много ко многим использована вт табл

            $teacherIds = Groop_Teacher::where('teacher_id', $id)->get();
$groups=null;
            $groupNames = []; // Массив для хранения названий групп
            foreach ($teacherIds as $teacher) {
                $secondValue = $teacher['group_id'];
                $groups = Group::find($secondValue);

                if ($groups) {
                    // Предположим, имя второго столбца - "group_name"
                    if (isset($groups['group_name'])) {
                    //    echo $groups['group_name'] . "\n"; // Вывод второго столбца
                        $groupNames[] = $groups['group_name'];
                    } else {
                        echo "Второй столбец не существует\n";
                    }
                }
            }
//предметы выб

            $subject= Subject::where('teacher_id', $id)->get();
            $subjectNames = []; // Массив для хранения названий групп
            foreach ($subject as $subject1) {
                // Access and display subject attributes
                $subjectNames[] = $subject1->subject_name;

            }
            $id = $user->id;
            return view('magazin', [
                "groupNames" => $groupNames,
                "subjectNames" => $subjectNames,
                "teacher" =>$id1,
                "id"=>$id,
                "magsSortDate1" => null,
                "uniqueStudentIDs1" => null,
                "Group1"=>null,
                "Subject1"=>null,
                "collection1"=>null ,
                "markCount1"=>null,
                "studentId1"=>null,
                "result1"=>null,
                "teacher1"=>null,"month"=>$month,
            ]);


        } else {
            // User login failed
            return back()->withErrors(['password' => 'Invalid password.']);
        }
}
else{
    if (!$user) {
        // User not found
        return back()->withErrors(['email' => 'User not found.']);
    }
    if ($user->password === $password &&$user->statys=="student") {
        // User login successful (be cautious of security risks)
        $fio = $user->fio; // Assuming 'fio' is the column name
        $statys = $user->statys;
        $id = $user->id;
        $id1 = $user->id;
        echo   "Welcome, " . " ".$statys." ". $fio . "!\n";
        $rec = Mag::where('id_students', $user->id)
            ->get();
        /////////////////////////////////логика для студентов///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        /// ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        /// ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        /// ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $magsSortDate1 = Mag::where('id_students', $user->id)
            ->selectRaw('MAX(id) AS id, date')
            ->groupBy('date')
            ->orderBy('date')
            ->groupBy('id_subj')
            ->selectRaw('id_subj, MAX(id) AS max_id') // Выбрать max(id)
            ->get();

        $mags = Mag::where('id_students', $user->id)
            ->groupBy('id_subj')
            ->selectRaw('id_subj, MAX(id) AS max_id') // Выбрать max(id)
            ->get();
        $uniqueStudentIDs = [];
        foreach ($mags as $mag) {
            // Extract the student ID
            $studentId = $mag->id_subj;

            // Check if the student ID is already in the unique array
            if (!in_array($studentId, $uniqueStudentIDs)) {
                // Add the student ID to the unique array

                $uniqueStudentIDs[] = $studentId;
            }

        }

            $collection = collect();
            $col  = collect();
            $studentAverages = [];
        foreach ($uniqueStudentIDs as $studentId) {
            $student = Subject::find($studentId);
            if ($student) {
                $average = 0;
                $markCount = 0;
                $isFirstMark = true;
                $isFirstMark0 = false;
                $sum = 0;
                $lec = 0;
                $a = 0;
                $current_estimate = 0;
                    foreach ($magsSortDate1 as $magSort) {
                        $results = Mag::where('id_subj',$studentId)
                            -> where('id_students', $user->id)
                            ->where('date', $magSort->date)
                            ->get();
                        if ($results->isEmpty());
                        else {
                            // Initialize sum variable for average calculation
                            foreach ($results as $result) {
                                if($result->tip_mark && $result->tip_mark!="зачёт") {
                                    $sum += $result->mark; // Add mark to sum
                                    $markCount++; // Increment mark count for all marks
                                    $isFirstMark = false;
                                }
                            }
                            $average =  $markCount; // Calculate average only if marks exist
                        }
                    }
                    // Calculate and display average in "ср-зн" cell
                    if($average != 0) {
                       $average =$sum/($average) ;
                        $collection->push($average);

                          }
                }
            }
            foreach ($collection as $item) {

                $col->push($collection->Pop());
            }

        return view('student', [
            "s" => $user->id,
            "user1" =>$user,
            "rec"=>$rec,
            "magsSortDate" => $magsSortDate1,
            "uniqueStudentIDs" => $uniqueStudentIDs,
            "Group"=>null,
            "Subject"=>null,
            "collection"=>$col,
            "markCount"=>null,
            "studentId"=>$studentId,
            "result"=>$rec,
            "teacher"=>null,
            "magsSortDate1" => $magsSortDate1,
            "uniqueStudentIDs1" => $uniqueStudentIDs,
            "Group1"=>null,
            "Subject1"=>null,
            "collection1"=>null ,
            "markCount1"=>null,
            "studentId1"=>null,
            "result1"=>null,
            "teacher1"=>null,"month"=>$month,
        ]);
    }
    elseif ( $user->statys=="admin")
    {

        return view('admin', [
            "s" => $user->id,]);

    }
    else {
        // User login failed
        return back()->withErrors(['password' => 'Invalid password.']);
    }

    dd($request->all());}

    }
    public function new_mark(Request $request,$group,$subject)
    {$month = $request->input('monthSelect');
      //  dd($request->all());
        $Group=$request->input('groupSelect');
        $Subject=$request->input('subject');
        $uniqueStudentIDs=$request->input('uniqueStudentIDs');
        $data3 = request('data3');
        $newMarkInput = request('newMarkInput');

// Найти запись по data3
        $record = Mag::where('id', $data3)->first();

// Проверить, существует ли запись
        if ($record) {
            // Обновить поле mark
            $record->mark = $newMarkInput;

            // Сохранить изменения
            if($newMarkInput!=null)
            {    $record->save();}
            ////mag_check_entrance кусок функции
            echo "Группа: ".$Group."  Предмет: ".$Subject;
            $groupModel = Group::where('group_name', $Group)->first();
            $subjectsModel = Subject::where('subject_name', $Subject)->first();
            if ($groupModel&&$subjectsModel)  {
                $groupId = $groupModel->id;
                $subId = $subjectsModel->id;
                $mags = Mag::where('id_group', $groupId)
                    ->where('id_subj', $subId)
                    ->get();
                $uniqueStudentIDs = [];
                foreach ($mags as $mag) {
                    // Extract the student ID
                    $studentId = $mag->id_students;
                    // Check if the student ID is already in the unique array
                    if (!in_array($studentId, $uniqueStudentIDs)) {
                        // Add the student ID to the unique array
                        $uniqueStudentIDs[] = $studentId;
                    }
                }
                $magsSortDate = Mag::where('id_group', $groupId)
                    ->where('id_subj', $subId)
                    ->selectRaw('MAX(id) AS id, date')
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();

                foreach ($magsSortDate as $magSort) {
                    $aa= $magSort->id_teacher;
                    // Format date without year
                    $dateWithoutYear = date('d.m', strtotime($magSort->date));
                }
                $collection = collect();
                $col  = collect();
                $studentAverages = [];
                foreach ($uniqueStudentIDs as $studentId) {
                    $student = EntranceModl::find($studentId);

                    if ($student) {
                        // Display marks for each date and calculate average
                        $average = 0; // Initialize average variable outside the loop
                        $markCount = 0; // Initialize mark count variable outside the loop
                        $isFirstMark = true;
                        $isFirstMark0 = false;
                        $sum = 0;
                        $lec=0;
                        $a=0;
                        $current_estimate=0;
                        foreach ($magsSortDate as $magSort) {
                            $results = Mag::where('id_students', $student->id)
                                ->where('date', $magSort->date)
                                ->get();
                            if ($results->isEmpty());
                            else {
                                // Initialize sum variable for average calculation
                                foreach ($results as $result) {
                                    if($result->tip_mark && $result->tip_mark!="зачёт") {
                                        $sum += $result->mark; // Add mark to sum
                                        $markCount++; // Increment mark count for all marks
                                        $isFirstMark = false;

                                    }
                                }
                                $average =  $markCount; // Calculate average only if marks exist
                            }
                        }
                        if($average!=0){
                        // Calculate and display average in "ср-зн" cell
                        if($isFirstMark0 == true) {
                            $average =($sum+($current_estimate/$lec))/($average+1) ; // Format average, "-" for no marks
                            $collection->push($average);
                        }
                        else{$average =$sum/($average) ;
                            $collection->push($average);   }
                    }
                }}
                foreach ($collection as $item) {

                    $col->push($collection->Pop());
                }
            }//кусок функции mag_check_entrance
            return view('mag', [
                "magsSortDate" => $magsSortDate,
                "uniqueStudentIDs" => $uniqueStudentIDs,
                "Group"=>$Group,
                "Subject"=>$Subject,
                "collection"=>$col ,
                "markCount"=>$markCount,
                "studentId"=>$studentId,
                "result"=>$result,
                "teacher"=>$aa,
                "magsSortDate1" => null,
                "uniqueStudentIDs1" => null,
                "Group1"=>null,
                "Subject1"=>null,
                "collection1"=>null ,
                "markCount1"=>null,
                "studentId1"=>null,
                "result1"=>null,
                "teacher1"=>null,"month"=>$month,

            ]);
        } else {
            // Сообщение об ошибке, если запись не найдена
            return response()->json(['message' => 'Запись не найдена'], 404);
        }
    }
    public function new_m(Request $request)
    {
        //   "data1" => "Английский"
        // "data2" => "2"//инд студента
        //  "data3" => "0"//группа
        // "data4" => "0"//ид учитель
        //  "data5" => "0"//пропуск
        //   "studentDate" => "2024-05-15"
        //   "studentMark" => "1"
        //    "lessonType" => "lecture"//тип зан
        $month = $request->input('month');
        $a = $request->input('data1');  // Subject name
        $b = $request->input('data3');  // Group name
        $studentId = $request->input('data2');  // Student ID
        $studentDate = $request->input('studentDate');  // Date of mark
        $studentMark = $request->input('studentMark');  // Mark
        $lessonType = $request->input('lessonType');  // Tip mark (optional)
        $teacherId = $request->input('data4');  // Teacher ID (optional)
        $propysk = $request->input('data5');  // Propysk (optional)

// Retrieve subject and group objects (handle potential errors)
        $englishSubject = Subject::where('subject_name', $a)->first();
        if (!$englishSubject) {
            return 'Error: Subject "' . $a . '" not found.';
        }

        $eng = Group::where('group_name', $b)->first();
        if (!$eng) {
            return 'Error: Group "' . $b . '" not found.';
        }

// Check for existing mark for the same student, subject, and date
        $existingMark = Mag::where('id_subj', $englishSubject->id)
            ->where('id_students', $studentId)
            ->where('date', $studentDate)
            ->first();

        if ($existingMark) {
            return 'Record already exists: A mark for this student (' . $studentId . ') in subject "' . $a . '" on ' . $studentDate . ' is already present.';
        }

// Create a new Mag object and save it (handle potential errors)
        $a = $request->input('data1');  $b = $request->input('data3');
        $englishSubject =  Subject::where('subject_name', $a)->first();
        $eng =Group::where('group_name', $b)->first();
        $studentMark = new Mag();
        $studentMark->id_subj = $englishSubject->id;
            $studentMark->id_students = $request->input('data2');
            $studentMark->id_group = $eng->id;
            $studentMark->id_teacher = $request->input('data4');
            $studentMark->propysk = $request->input('data5');
            $studentMark->date = $request->input('studentDate');
            $studentMark->mark = $request->input('studentMark');
            $studentMark->tip_mark = $request->input('lessonType');

        try {
            $studentMark->save();
            //кусок функции
            $markCount=0;$aa=0;
            $magsSortDate=null;$uniqueStudentIDs=null;$col=null;$result=null;
            $studentId=0;
            //dd($request->all());
            $Group=$request->input('groupSelect');
            $Subject=$request->input('subject');
            echo "Группа: ".$Group."  Предмет: ".$Subject;
            $groupModel = Group::where('group_name', $Group)->first();
            $subjectsModel = Subject::where('subject_name', $Subject)->first();
            if ($groupModel&&$subjectsModel)  {
                $groupId = $groupModel->id;
                $subId = $subjectsModel->id;
                $mags = Mag::where('id_group', $groupId)
                    ->where('id_subj', $subId)
                    ->get();
                $uniqueStudentIDs = [];
                foreach ($mags as $mag) {
                    // Extract the student ID
                    $studentId = $mag->id_students;
                    // Check if the student ID is already in the unique array
                    if (!in_array($studentId, $uniqueStudentIDs)) {
                        // Add the student ID to the unique array
                        $uniqueStudentIDs[] = $studentId;
                    }
                }
                $magsSortDate = Mag::where('id_group', $groupId)
                    ->where('id_subj', $subId)
                    ->selectRaw('MAX(id) AS id, date')
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();

                foreach ($magsSortDate as $magSort) {
                    $aa= $magSort->id_teacher;
                    // Format date without year
                    $dateWithoutYear = date('d.m', strtotime($magSort->date));
                }
                $collection = collect();
                $col  = collect();
                $studentAverages = [];
                foreach ($uniqueStudentIDs as $studentId) {
                    $student = EntranceModl::find($studentId);

                    if ($student) {
                        // Display marks for each date and calculate average
                        $average = 0; // Initialize average variable outside the loop
                        $markCount = 0; // Initialize mark count variable outside the loop
                        $isFirstMark = true;
                        $isFirstMark0 = false;
                        $sum = 0;
                        $lec=0;
                        $a=0;
                        $current_estimate=0;
                        foreach ($magsSortDate as $magSort) {
                            $results = Mag::where('id_students', $student->id)
                                ->where('date', $magSort->date)
                                ->get();
                            if ($results->isEmpty());
                            else {
                                // Initialize sum variable for average calculation
                                foreach ($results as $result) {
                                    if($result->tip_mark && $result->tip_mark!="зачёт") {
                                        $sum += $result->mark; // Add mark to sum
                                        $markCount++; // Increment mark count for all marks
                                        $isFirstMark = false;

                                    }
                                }
                                $average =  $markCount; // Calculate average only if marks exist
                            }
                        }
                        if($average!=0){
                        // Calculate and display average in "ср-зн" cell
                        if($isFirstMark0 == true) {
                            $average =($sum+($current_estimate/$lec))/($average+1) ; // Format average, "-" for no marks
                            $collection->push($average);
                        }
                        else{$average =$sum/($average) ;
                            $collection->push($average);   }
                    }
                }}

            } foreach ($collection as $item) {

                $col->push($collection->Pop());
            }
            return view('mag', [
                "magsSortDate" => $magsSortDate,
                "uniqueStudentIDs" => $uniqueStudentIDs,
                "Group"=>$Group,
                "Subject"=>$Subject,
                "collection"=>$col ,
                "markCount"=>$markCount,
                "studentId"=>$studentId,
                "result"=>$result,
                "teacher"=>$aa,
                "magsSortDate1" => null,
                "uniqueStudentIDs1" => null,
                "Group1"=>null,
                "Subject1"=>null,
                "collection1"=>null ,
                "markCount1"=>null,
                "studentId1"=>null,
                "result1"=>null,
                "teacher1"=>null,"month"=>$month,

            ]);
        } catch (Exception $e) {
            return 'Error saving mark: ' . $e->getMessage();
        }}

}
