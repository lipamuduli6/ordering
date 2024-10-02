
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h3 class="card-title">Attendance Records</h3>
        <div class="card-tools align-middle">
            <button class="btn btn-success btn-sm py-1 rounded-0" type="button" id="print"><i class="fa fa-print"></i> Print</button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover" id="att-list">
            <colgroup>
                <col width="5%">
                <col width="45%">
                <col width="25%">
                <col width="25%">
            </colgroup>
            <thead>
                <tr>
                    <th class="p-0 text-center">#</th>
                    <th class="p-0 text-center">Employee</th>
                    <th class="p-0 text-center">Attendance Type</th>
                    <th class="p-0 text-center">Attendance DateTime</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                 $att_qry = $conn->query("SELECT a.*,t.name as tname,(e.lastname || ', ' || e.firstname || ' ' || e.middlename) as `fullname`,e.employee_code FROM `attendance_list` a inner join employee_list e on a.employee_id = e.employee_id inner join att_type_list t on a.att_type_id = t.att_type_id where date(a.date_created) = '".date("Y-m-d")."' ");
                 $i = 1;
                 while($row = $att_qry->fetchArray()):
                    $bg = "primary";
                    if(in_array($row['att_type_id'],array(2,4)))
                    $bg = "danger";
                ?>
                <tr>
                    <td class="align-middle py-0 px-1 text-center"><?php echo $i++; ?></td>
                    <td class="align-middle py-0 px-1">
                        <p class="m-0">
                            <small><b>Employee Code:</b> <?php echo $row['employee_code'] ?></small><br>
                            <small><b>Name:</b> <?php echo $row['fullname'] ?></small>
                        </p>
                    </td>
                    <td class="align-middle py-0 px-1 text-center">
                        <span class="badge bg-<?php echo $bg ?>"><?php echo $row['tname'] ?></span>
                    </td>
                    <td class="align-middle py-0 px-1 text-end"><?php echo date("M d, Y h:i A",strtotime($row['date_created']))  ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(function(){
        $('#print').click(function(){
            var _h = $("head").clone()
            var _table = $('#att-list').clone()
            var _el = $("<div>")
            _el.append(_h)
            _el.append("<h2 class='text-center'>Attendance List</h2>")
            _el.append("<hr/>")
            _el.append(_table)

            var nw = window.open("","_blank","width=1200,height=900")
                     nw.document.write(_el.html())
                     nw.document.close()
                     setTimeout(() => {
                         nw.print()
                         setTimeout(() => {
                         nw.close()
                         }, 200);
                     }, 200);
        })
    })
</script>