<?php

require 'models/Employee.php';
$employeeData = new Employee();
$employee_list;
try {
    $employee_list = $employeeData->getAll();
} catch (PDOEXCEPTION $e) {
    $employeeData = array();
    $employee_list = $employeeData['error']['errorMsg'] = 'Action failed! Error Code: ' . $e->getCode();
}

?>

<div class="container">
  <div class="table-wrapper">
    <div class="table-title">
      <div class="row">
        <div class="col-sm-5">
          <h2>User <b>Management</b></h2>
        </div>
        <div class="col-sm-7">
          <a href="#" class="btn btn-primary"><i class="material-icons">&#xE147;</i> <span>Add New User</span></a>
        </div>
      </div>
    </div>
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Serial</th>
          <th>first name</th>
          <th>last name</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
<?php

foreach ($employee_list as $employee) {
    echo '<tr>';
    foreach ($employee as $key => $value) {
        if ($key == 'errorMsg') {
            echo "<td colspan=4>$value</td>";
        } else {
            echo "<td>$value</td>";
        }
    }
    echo "<td>" .
        '<a href="#" class="settings" title="Settings" data-toggle="tooltip"><i class="material-icons">&#xE8B8;</i></a>' .
        '<a href="#" class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE5C9;</i></a>' .
        "</td>";
    echo '</tr>';
}
?>
      </tbody>
    </table>
    <div class="clearfix">
      <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
      <ul class="pagination">
        <li class="page-item disabled"><a href="#">Previous</a></li>
        <li class="page-item"><a href="#" class="page-link">1</a></li>
        <li class="page-item"><a href="#" class="page-link">2</a></li>
        <li class="page-item active"><a href="#" class="page-link">3</a></li>
        <li class="page-item"><a href="#" class="page-link">4</a></li>
        <li class="page-item"><a href="#" class="page-link">5</a></li>
        <li class="page-item"><a href="#" class="page-link">Next</a></li>
      </ul>
    </div>
  </div>
</div>