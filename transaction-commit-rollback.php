$conn= new mysqli("localhost", "abc", "root", "");
$all_query_ok=true; // our control variable

//we make 4 inserts, the last one generates an error
//if at least one query returns an error we change our control variable
 mysqli_autocommit($conn, FALSE); 
$conn->query("INSERT INTO fact_test2 (n,f) VALUES ('ss1','xx1')") ? null : $all_query_ok=false;
$conn->query("INSERT INTO fact_test2 (n,f) VALUES ('ss2','xx2')") ? null : $all_query_ok=false;
$conn->query("INSERT INTO fact_test21 (n,f) VALUES ('ss3','xx3')") ? null : $all_query_ok=false;
$conn->query("INSERT INTO fact_test2 (n,f) VALUES ('ss4','xx4')") ? null : $all_query_ok=false; //duplicated PRIMARY KEY VALUE

//now let's test our control variable
$all_query_ok ? $conn->commit() : $conn->rollback();
