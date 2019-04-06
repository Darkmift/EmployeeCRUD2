<?php

require_once 'models/Employee.php';
$employeeData = new Employee();
$employeeData->getAll();
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
          <th>Name</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
<?php
foreach ($employeeData as $employee) {
    echo '<tr>';
    foreach ($employee as $key => $value) {
        echo "<td>$value</td>";
    }
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