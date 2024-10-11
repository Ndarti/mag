<?php

namespace App\Http\Controllers;

use App\Models\_sub_group;
use App\Models\EntranceModl;
use App\Models\Groop_Teacher;
use App\Models\Group;
use App\Models\Mag;
use App\Models\Prop;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PeopleController extends Controller
{
    public function pass(Request $request){
        $subject = $request->input('subject');
        $sub=Subject::where('subject_name', $subject)->first();
        $group = $request->input('groupSelect');
        $Group=Group::where('group_name', $group)->first();
        $month = $request->input('month');
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
            $magsSortDate1 = Prop::where('id_group', $groupId)
                ->where('id_subj', $subId)
                ->whereMonth('date', $month)
                ->selectRaw('MAX(id) AS id, date')
                ->groupBy('date')
                ->orderBy('date')
                ->get();
            $magsSortDate = Mag::where('id_group', $groupId)
                ->where('id_subj', $subId)
                ->selectRaw('MAX(id) AS id, date')
                ->groupBy('date')
                ->orderBy('date')
                ->get();
            foreach ($magsSortDate1 as $magSort) {
                $aa= $magSort->id_teacher;
                // Format date without year
                $dateWithoutYear = date('d.m', strtotime($magSort->date));
            }
            foreach ($magsSortDate as $magSort) {
                $aa= $magSort->id_teacher;
                // Format date without year
                $dateWithoutYear = date('d.m', strtotime($magSort->date));
            }
            $collection1= collect();
            $col1  = collect();
            $collection= collect();
            $col = collect();
            $studentAverages = [];
            foreach ($uniqueStudentIDs as $studentId) {
                $student = EntranceModl::find($studentId);
                if ($student) {
                    // Display marks for each date and calculate average
                    $average1 = 0; // Initialize average variable outside the loop
                    $markCount1 = 0; // Initialize mark count variable outside the loop
                    $isFirstMark1= true;
                    $isFirstMark0 = false;
                    $sum1 = 0;
                    $lec=0;
                    $a=0;
                    $current_estimate=0;
                    foreach ($magsSortDate1 as $magSort) {
                        $results = Prop::where('id_students', $student->id)
                            ->where('date', $magSort->date)
                            ->get();
                        if ($results->isEmpty());
                        else {
                            // Initialize sum variable for average calculation
                            foreach ($results as $result) {
                                if($result->propysc=="да") {
                                    $average1++;
                                    $isFirstMark0 = true;
                                }
                            }
                        }
                    }
                    // Calculate and display average in "ср-зн" cell
                    if($isFirstMark0 == true) {
                        $collection1->push($average1);
                    }
                }
            }
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
                    // Calculate and display average in "ср-зн" cell
                    if($average!=0){
                    if($isFirstMark0 == true) {
                        $average =($sum+($current_estimate/$lec))/($average+1) ; // Format average, "-" for no marks
                        $collection->push($average);
                    }
                    else{$average =$sum/($average) ;
                        $collection->push($average);   }}
                }
            }
            foreach ($collection1 as $item) {

                $col1->push($collection1->Pop());
            }
            foreach ($collection as $item) {

                $col->push($collection->Pop());
            }
        }
        return view('mag', [
            "magsSortDate1" => $magsSortDate1,
            "uniqueStudentIDs1" => $uniqueStudentIDs,
            "Group1"=>$Group,
            "Subject1"=>$Subject,
            "collection1"=>$col1 ,
            "markCount1"=>$markCount,
            "studentId1"=>$studentId,
            "result1"=>$result,
            "teacher1"=>$aa,
            "magsSortDate" =>$magsSortDate ,
            "uniqueStudentIDs" => $uniqueStudentIDs,
            "Group"=>$Group,
            "Subject"=>$Subject,
            "collection"=>$col ,
            "markCount"=>$markCount,
            "studentId"=>$studentId,
            "result"=>$result,
            "teacher"=>$aa,
            "month"=>$month,

        ]);
    }
    public function mes_prop(Request $request)
    {
        $subject = $request->input('subject');
        $sub=Subject::where('subject_name', $subject)->first();
        $group = $request->input('groupSelect');
        $Group=Group::where('group_name', $group)->first();
        $month = $request->input('monthSelect');
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
            $magsSortDate1 = Prop::where('id_group', $groupId)
                ->where('id_subj', $subId)
                ->whereMonth('date', $month)
                ->selectRaw('MAX(id) AS id, date')
                ->groupBy('date')
                ->orderBy('date')
                ->get();
            $magsSortDate = Mag::where('id_group', $groupId)
                ->where('id_subj', $subId)
                ->selectRaw('MAX(id) AS id, date')
                ->groupBy('date')
                ->orderBy('date')
                ->get();
            foreach ($magsSortDate1 as $magSort) {
                $aa= $magSort->id_teacher;
                // Format date without year
                $dateWithoutYear = date('d.m', strtotime($magSort->date));
            }
            foreach ($magsSortDate as $magSort) {
                $aa= $magSort->id_teacher;
                // Format date without year
                $dateWithoutYear = date('d.m', strtotime($magSort->date));
            }
            $collection1= collect();
            $col1  = collect();
            $collection= collect();
            $col = collect();
            $studentAverages = [];
            foreach ($uniqueStudentIDs as $studentId) {
                $student = EntranceModl::find($studentId);
                if ($student) {
                    // Display marks for each date and calculate average
                    $average1 = 0; // Initialize average variable outside the loop
                    $markCount1 = 0; // Initialize mark count variable outside the loop
                    $isFirstMark1= true;
                    $isFirstMark0 = false;
                    $sum1 = 0;
                    $lec=0;
                    $a=0;
                    $current_estimate=0;
                    foreach ($magsSortDate1 as $magSort) {
                        $results = Prop::where('id_students', $student->id)
                            ->where('date', $magSort->date)
                            ->get();
                        if ($results->isEmpty());
                        else {
                            // Initialize sum variable for average calculation
                            foreach ($results as $result) {
                                if($result->propysc=="да") {
                                    $average1++;
                                    $isFirstMark0 = true;
                                }
                            }
                        }
                    }
                    // Calculate and display average in "ср-зн" cell
                    if($isFirstMark0 == true) {
                        $collection1->push($average1);
                    }
                }
            }
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

                                    $sum += $result->mark; // Add mark to sum
                                    $markCount++; // Increment mark count for all marks

                            }
                            $average =  $markCount; // Calculate average only if marks exist
                        }
                    }         if($average!=0){
                    // Calculate and display average in "ср-зн" cell
                    if($isFirstMark0 == true) {
                        $average =($sum+($current_estimate/$lec))/($average+1) ; // Format average, "-" for no marks
                        $collection->push($average);
                    }
                    else{$average =$sum/($average) ;
                        $collection->push($average);   }}
                }
            }
            foreach ($collection1 as $item) {

                $col1->push($collection1->Pop());
            }
            foreach ($collection as $item) {

                $col->push($collection->Pop());
            }
        }
        $studentId1 = $request->input('studentId');
        $date = $request->input('date');
        $newHours=$request->input('hours');
        // Найти запись по student_id, date
        $student = Prop::where('id_students', $studentId1)
            ->where('date', $date)
            ->first();

        // Если запись найдена
        if ($student) {
            // Обновить значение "часы"
            $student->hours = 0;

            // Сохранить изменения
            $student->save();
echo $month."iii";
            // Вернуть сообщение об успехе
            return view('mag', [
                "magsSortDate1" => $magsSortDate1,
                "uniqueStudentIDs1" => $uniqueStudentIDs,
                "Group1"=>$Group,
                "Subject1"=>$Subject,
                "collection1"=>$col1 ,
                "markCount1"=>$markCount,
                "studentId1"=>$studentId,
                "result1"=>$result,
                "teacher1"=>$aa,
                "magsSortDate" =>$magsSortDate ,
                "uniqueStudentIDs" => $uniqueStudentIDs,
                "Group"=>$Group,
                "Subject"=>$Subject,
                "collection"=>$col ,
                "markCount"=>$markCount,
                "studentId"=>$studentId,
                "result"=>$result,
                "teacher"=>$aa,
                "month"=>$month,

            ]);
        } else {
            // Вернуть сообщение об ошибке
            return response()->json(['error' => 'Запись не найдена'], 404);
        }
        dd($request->all());
    }
    public function new_prop(Request $request)
    {
        $subject = $request->input('subject');
        $sub=Subject::where('subject_name', $subject)->first();
        $group = $request->input('groupSelect');
        $Group=Group::where('group_name', $group)->first();
        $month = $request->input('monthSelect');
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
            $magsSortDate1 = Prop::where('id_group', $groupId)
                ->where('id_subj', $subId)
                ->whereMonth('date', $month)
                ->selectRaw('MAX(id) AS id, date')
                ->groupBy('date')
                ->orderBy('date')
                ->get();
            $magsSortDate = Mag::where('id_group', $groupId)
                ->where('id_subj', $subId)
                ->selectRaw('MAX(id) AS id, date')
                ->groupBy('date')
                ->orderBy('date')
                ->get();
            foreach ($magsSortDate1 as $magSort) {
                $aa= $magSort->id_teacher;
                // Format date without year
                $dateWithoutYear = date('d.m', strtotime($magSort->date));
            }
            foreach ($magsSortDate as $magSort) {
                $aa= $magSort->id_teacher;
                // Format date without year
                $dateWithoutYear = date('d.m', strtotime($magSort->date));
            }
            $collection1= collect();
            $col1  = collect();
            $collection= collect();
            $col = collect();
            $studentAverages = [];
            foreach ($uniqueStudentIDs as $studentId) {
                $student = EntranceModl::find($studentId);
                if ($student) {
                    // Display marks for each date and calculate average
                    $average1 = 0; // Initialize average variable outside the loop
                    $markCount1 = 0; // Initialize mark count variable outside the loop
                    $isFirstMark1= true;
                    $isFirstMark0 = false;
                    $sum1 = 0;
                    $lec=0;
                    $a=0;
                    $current_estimate=0;
                    foreach ($magsSortDate1 as $magSort) {
                        $results = Prop::where('id_students', $student->id)
                            ->where('date', $magSort->date)
                            ->get();
                        if ($results->isEmpty());
                        else {
                            // Initialize sum variable for average calculation
                            foreach ($results as $result) {
                                if($result->propysc=="да") {
                                    $average1++;
                                    $isFirstMark0 = true;
                                }
                            }
                        }
                    }
                    // Calculate and display average in "ср-зн" cell
                    if($isFirstMark0 == true) {
                        $collection1->push($average1);
                    }
                }
            }
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
                                if($result->tip_mark && $result->tip_mark!="зачёт"){
                                    $sum += $result->mark; // Add mark to sum
                                    $markCount++; // Increment mark count for all marks
                                    $isFirstMark = false;

                                }
                            }
                            $average =  $markCount; // Calculate average only if marks exist
                        }
                    }         if($average!=0){
                    // Calculate and display average in "ср-зн" cell
                    if($isFirstMark0 == true) {
                        $average =($sum+($current_estimate/$lec))/($average+1) ; // Format average, "-" for no marks
                        $collection->push($average);
                    }
                    else{$average =$sum/($average) ;
                        $collection->push($average);   }}
                }
            }
            foreach ($collection1 as $item) {

                $col1->push($collection1->Pop());
            }
            foreach ($collection as $item) {

                $col->push($collection->Pop());
            }
        }
        $subject = $request->input('subject');
        $group = $request->input('groupSelect');
        $studentId=$request->input('studentId');
        $hours=$request->input('hours');
        $date=$request->input('date');
        $groupid = Group::where('group_name', $group)->first();
        $subid = Subject::where('subject_name', $subject)->first();
        $records = Prop::where('id_group', $groupid->id)
            ->where('id_subj', $subid->id)
            ->where('date', $date)
            ->where('id_students', $studentId)
            ->first();
        if ($records) {
            $records->hours = $hours;
            $records->save();
        } else {
            echo "No record found for group: " . $group . " and subject: " . $subject;
            $r = new Prop();
            $r->id_students=$studentId;
                $r->id_group=$groupid->id;
                $r->id_subj=$subid->id;
                $r->propysc="да";
                $r->hours=$hours;
                $r->date=$date;
                $r->created_at=$date;
                $r->updated_at=$date;
                $r->save();
        }
        return view('mag', [
            "magsSortDate1" => $magsSortDate1,
            "uniqueStudentIDs1" => $uniqueStudentIDs,
            "Group1"=>$Group,
            "Subject1"=>$Subject,
            "collection1"=>$col1 ,
            "markCount1"=>$markCount,
            "studentId1"=>$studentId,
            "result1"=>$result,
            "teacher1"=>$aa,
            "magsSortDate" =>$magsSortDate ,
            "uniqueStudentIDs" => $uniqueStudentIDs,
            "Group"=>$Group,
            "Subject"=>$Subject,
            "collection"=>$col ,
            "markCount"=>$markCount,
            "studentId"=>$studentId,
            "result"=>$result,
            "teacher"=>$aa,
            "month"=>$month, ]);}
    public function graf(Request $request)
    {
        dd($request->all());
    }
    public function admin(Request $request)
    {$group=$request->input('group');
       //dd($request->all());
        if($group)
        {
    $Gro=Group::where('group_name', $group)->first();if ($Gro){
    $SU=_sub_group::where('id_group', $Gro->id)->get();

     $password = Str::random(10, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_-+={}[];:<>,.?/\|');

        // Check for existing email before saving the user.blade.php
        $existingUser = EntranceModl::where('email', $request->input('userEmail'))->first();

        if ($existingUser) {
            // Email already exists, display error message
            echo "Error: Email address already in use. Please choose a different email.";
            return 0; // Exit registration process
        }

        // Save the user.blade.php if email is unique
        $user = EntranceModl::insert([
            'fio' => $request->input('userName'),
            'email' => $request->input('userEmail'),
            'password' => $password,
            'statys' => $request->input('userType'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if ($user) {
            // User created successfully
            echo "User created successfully! Password: " . $password . "<br>";

$idS=EntranceModl::where('email',$request->input('userEmail'))->first();
            foreach ($SU as $row){
                $st=new Mag();
                $st->id_students=$idS->id;
                $st->id_group=$row->id_group;
                $st->id_subj=$row->id_subj;
                $st->save();



            }
            // Optionally, send a welcome email with the generated password
            // ... (code for sending welcome email)
        } else {
            // User creation failed (e.g., database error)
            echo "Failed to create user.blade.php. Please try again.";
        }

        return view('admin',["password"=>$password]);}
else{
    echo "Error: group does not exist.";
}

    }else{
            $password = Str::random(10, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_-+={}[];:<>,.?/\|');

            // Check for existing email before saving the user.blade.php
            $existingUser = EntranceModl::where('email', $request->input('userEmail'))->first();

            if ($existingUser) {
                // Email already exists, display error message
                echo "Error: Email address already in use. Please choose a different email.";
                return 0; // Exit registration process
            }

            // Save the user.blade.php if email is unique
            $user = EntranceModl::insert([
                'fio' => $request->input('userName'),
                'email' => $request->input('userEmail'),
                'password' => $password,
                'statys' => $request->input('userType'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            if ($user) {
                // User created successfully
                echo "User created successfully! Password: " . $password . "<br>";

            }
            else {
                // User creation failed (e.g., database error)
                echo "Failed to create user.blade.php. Please try again.";
            }

            return view('admin',["password"=>$password]);




            }



    }
    public function user(Request $request)
    {
        $users = EntranceModl::all();

        // Prepare table header
        $tableHeaders = array('Full Name', 'Email', 'Status');

        echo "<style>";
        echo "table {
        border-collapse: collapse;
        width: 100%; /* Adjust width as needed */
    }
    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #f1f1f1;
    }
    </style>";

        echo "<table>";
        echo "<tr>";
        // Display table headers
        foreach ($tableHeaders as $header) {
            echo "<th>" . $header . "</th>";
        }
        echo "</tr>";

        // Process each user and display their information in a table row
        foreach ($users as $user) {
            $fullName = $user->fio; // Assuming separate name and surname fields
            $email = $user->email;
            $status = $user->statys; // Assuming a 'status' field in the table
            $password = $user->password; // Note: Password should be stored securely, not displayed directly

            echo "<tr>";
            echo "<td>" . $fullName . "</td>";
            echo "<td>" . $email . "</td>";
            echo "<td>" . $status . "</td>";
            // Exclude password from table output for security reasons
             echo "<td>" . $password . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    }
    public function group(Request $request)
    {//dd($request->all());
        $idteacher=EntranceModl::where('email', $request->input('email'))->first();
        $group=new Group();
        $group->group_name = $request->input('grou');
        $group->course = $request->input('co');
        $group->manager_id = 1;
        $group->teacher_id = $idteacher->id;
        $group->speciality = $request->input('sp');

        $group->save(); // Let save() handle timestamps
        $gr_t=new Groop_Teacher();

        $gr_t->group_id=$group->id;
        $gr_t-> teacher_id=$idteacher->id;
        $gr_t->start_date=Carbon::now();
        $gr_t->end_date=Carbon::now();
        $gr_t->is_primary=1;
        $gr_t->role='teacher';
        $gr_t->comments=1;
        $gr_t->created_at=Carbon::now();
        $gr_t->updated_at=Carbon::now();
        $gr_t->save();
        echo "Group created successfully!";

    }
    public function addSubject(Request $request)
    {
       //dd($request->all());
        $teacherEmail = filter_var($request->input('teacherEmail'), FILTER_SANITIZE_EMAIL);
        $teacher = EntranceModl::where('email', $teacherEmail)->first();
$group=Group::where('group_name', $request->input('group'))->first();
        if ($group && $teacher) {
          $subject = new Subject();
          $subject->subject_name=$request->input('subject');
$subject->subject_description=1;
$subject->teacher_id=$teacher->id;
$subject->created_at=Carbon::now();
$subject->updated_at=Carbon::now();
$subject->save();

$dd=Subject::where('subject_name', $request->input('subject'))->first();
$gr_sub=new _sub_group();
            $gr_sub->id_group=$group->id;
          $gr_sub->id_subj=$dd->id;
       $gr_sub->save();


echo "Subject created successfully!";
return view('admin',["subject"=>$subject]);
        }
        else {echo "Error: group or teacher does not exist.";}
    }
}
