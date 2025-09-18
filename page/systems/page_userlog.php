<div class="container">
    <h6 class="fw-bold mt-3 text-start">User Log</h6>
    <hr class="w-50 mb-3">
    <div>
        <table id="mytables" class="table table-sm" style="width:100%;">
            <thead class="bg-dark text-white">
                <tr>
                    <th style="width: 5%;"><input type="checkbox" onclick="checkdischeck(this.checked)"> All</th>
                    <th>User ID</th>
                    <th>Pernr</th>
                    <th>Nama</th>
                    <th>Position</th>
                    <th>Login Time</th>
                    <th>Last Act</th>
                    <th>Pages</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $sql = mysqli_query($conn, "SELECT * FROM user_log WHERE UserID != '$_SESSION[userid]'");
                while ($row = mysqli_fetch_array($sql)) {
                    $pernr = Getdata('PersonnelNumber', 'usr02', 'UserID', $row['UserID']);
                ?>
                    <tr>
                        <td><input type="checkbox" id="userlog_checked<?= $i ?>"></td>
                        <td>
                            <a href="#" class="badge bg-success href_transform" onclick="kickuserlog('<?= $row['UserID'] ?>')"><?= $row['UserID'] ?></a>
                        </td>
                        <td><?= $pernr ?></td>
                        <td><?= Getdata('EmployeeName', 'pa001', 'PersonnelNumber', $pernr) ?></td>
                        <td><?= Getdata('PositionID', 'pa001', 'PersonnelNumber', $pernr) ?></td>
                        <td><?= $row['LoginTime'] ?></td>
                        <td><?= $row['LastAct'] ?></td>
                        <td><?= $row['ActionPage'] ?></td>
                    </tr>
                <?php
                    $i += 1;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>