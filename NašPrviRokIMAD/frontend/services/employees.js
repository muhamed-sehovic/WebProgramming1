var EmployeesService = {
    delete_employee: function(employee_id) {
        if(confirm("Do you want to delete employee with the id " + employee_id + "?") == true) {
           RestClient.delete("/employee/delete/" + employee_id, function(response) {
            alert("Employee deleted successfully.");
            EmployeesService.loadEmployees();
          });
          console.log("TODO Perform deletion logic");
        }
    },

    edit_employee: function(employee_id){
      RestClient.get("/employee/edit/" + employee_id, function(employee) {
        $("#employeeNumber").val(employee.id);
        $("#firstName").val(employee.first_name);
        $("#lastName").val(employee.last_name);
        $("#email").val(employee.email);
        
        $("#edit-employee-modal").modal("show");
      });
        console.log("Get employee with provided id, open modal and populate modal fields with data returned from the database");
        alert("Opened");
    },

    loadEmployees: function(){
      RestClient.get("/employees/performance", function(employees){
        const table = $("#employee-performance tbody");
        table.empty();
        employees.forEach(function(employee){
          table.append(
            ` 
              <tr>
                <td class="text-center">
                  <div class="btn-group" role="group">
                    <button
                      type="button"
                      class="btn btn-warning"
                      onclick="EmployeesService.edit_employee(${employee.id})"
                    >
                      Edit
                    </button>
                    <button
                      type="button"
                      class="btn btn-danger"
                      onclick="EmployeesService.delete_employee(${employee.id})"
                    >
                      Delete
                    </button>
                  </div>
                </td>
                <td>${employee.full_name}</td>
                <td>${employee.email}</td>
                <td>${employee.total}</td>
              </tr>
            `
          );
        });
      });
    },

    init: function(){
    $(document).ready(function (){

    EmployeesService.loadEmployees();
    
    $("#edit-employee-modal form").submit(function(event) {
      event.preventDefault();
      const employeeData = {
        id: $("#employeeNumber").val(),
        first_name: $("#firstName").val(),
        last_name: $("#lastName").val(),
        email: $("#email").val()
    };

      RestClient.put("/employees/" + employeeData.id, employeeData, function (response) {
        alert("Employee updated successfully.");
        $("#edit-employee-modal").modal("hide");
        EmployeesService.loadEmployees();
      });
    });
  });
  }
}
