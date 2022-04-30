<?php
    include_once('DB.php');
    $studentId = 120221;

?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="tableStyle.css" />
    </head>
    <body>
        <h2>Quizzes</h2>
        <table>
            <tr>
                <th>course name</th>
                <th>your grade</th>
            </tr>
            <?php 
                function getQuizGrade($connection,int $quizId,int $studentId){
                    $query_gradeQuiz = mysqli_query($connection,
                    "SELECT grade from quizzesgrades where quizId=$quizId and studentId=$studentId"
                    );
                    if($g = mysqli_fetch_assoc($query_gradeQuiz))
                        return 'your grade %'.$g['grade']*100;
                    else
                        return 'you haven\'t solve this quiz yet.';
                }

                $query_studentQuiz = mysqli_query($connection, 
                            "SELECT courses.name as courseNameForQuiz, quizzes.id as quizId
                            from quizzes JOIN courses join student_course
                            on quizzes.courseId = courses.id 
                            and quizzes.instructorId = student_course.instructorID 
                            and quizzes.courseId = student_course.courseId
                            WHERE student_course.studentId = $studentId");
                
                
                while($row = mysqli_fetch_assoc($query_studentQuiz)){
                    echo "<tr>";
                    echo "<td>".$row['courseNameForQuiz']."</td>";
                    echo "<td>".getQuizGrade($connection,$row['quizId'],$studentId)."</td>";
                    echo "</tr>";
                }
            ?>


        </table>

    </body>
</html>