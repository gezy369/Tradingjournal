<table>
    <!-- ------------------------------------------------------------------------------------------------------------
    Header 
    ---------------------------------------------------------------------------------------------------------------->
    <thead>
        <tr>
          <th rowspan="2" class="dates_cell"> Dates </th>
          <th rowspan="2" class="nbr_trade_cell"> # T </th>
          <th rowspan="2" class="nbr_trade_cell"> # W </th>
          <th rowspan="2" class="nbr_trade_cell"> # L </th>
          <th colspan="2" class="trade"> Trade - 1 </th>
          <th colspan="2" class="trade"> Trade - 2 </th>
          <th colspan="2" class="trade"> Trade - 3 </th>
          <th colspan="2" class="trade"> Trade - 4 </th>
          <th colspan="2" class="trade"> Trade - 5 </th>
          <th colspan="2" class="trade"> Trade - 6 </th>
          <th colspan="2" class="trade"> Trade - 7 </th>
          <th class="trade" style="display:<?php echo $display_tabl_pl; ?>;"> Daily </th>
          <th rowspan="2"> Edit </th>
        </tr>
        <tr>
          <th> Main </th>
          <th> Runner </th>
          <th> Main </th>
          <th> Runner </th>
          <th> Main </th>
          <th> Runner </th>
          <th> Main </th>
          <th> Runner </th>
          <th> Main </th>
          <th> Runner </th>
          <th> Main </th>
          <th> Runner </th>
          <th> Main </th>
          <th> Runner </th>
          <th class="daily" style="display:<?php echo $display_tabl_pl; ?>;"> Net G/L </th>
        </tr>
    </thead>
    <!-- ------------------------------------------------------------------------------------------------------------
        Dates generation 
    ---------------------------------------------------------------------------------------------------------------->
    <?php

    // select the date of the month
    while ($oStart->getTimestamp() < $oEnd->getTimestamp()) {
        $aDates[] = $oStart->format('D d');
        $oStart->add(new DateInterval("P1D"));
    }

    //Set the variables for each dates
    foreach ($aDates as $day) {
      $FuncDay = substr($day, -2);
      $weekend = check_weekend($FuncDay,$month,$year);  //to test if date is a weekend
      $today = check_day($FuncDay,$month,$year);        //test if the dat is today
      $fulldate = $year."-".$month."-".$FuncDay;        //to use in SELECT query     
      $btnID ++;                                        //increase butons IDs
      $popupID ++;                                      //increase butons IDs

      // Display a weekend line or a weekday line
      if ($weekend == "weekend") {
        if ($tr == 0){?>
            <tr>
              <td id="weekendDay" colspan="20">weekend</td>
            </tr>
            <?php $tr ++;}else{
            $tr = 0;
        }?>
      <?php
      }else{ //else if not weekend, displays the data 
      /*-- ------------------------------------------------------------------------------------------------------------
        PHP : Fetches the data to display the trades information according to the dates 
      ---------------------------------------------------------------------------------------------------------------*/
        $sql = "SELECT * FROM trades WHERE trade_date='$fulldate' AND acc_fid='$current_account_id'";
        $result = $conn->query($sql); 
        if ($result->num_rows > 0) { //if data to be displayed
          // output data of each row
          while($row = $result->fetch_assoc()) {

                //p&l calculation
                $pl = ($row["gain"] + $row["loss"]) - $row["costs"];
                ?>
                <!-- ------------------------------------------------------------------------------------------------------------
                    Tbody of the table if trade exists for the date 
                ---------------------------------------------------------------------------------------------------------------->
                <tbody id="<?php echo $today;?>">
                <form method="post">
                <!-- contracts line -->
                <tr class="contracts">
                    <td rowspan="2" class="dates_cell" id="<?php echo $weekend; ?>"> <?php echo $day; ?> </td>
                    <td rowspan="2"><?php echo $total = $row["pos_tr_count"]+$row["neg_tr_count"]; ?></td>
                    <td rowspan="2"><?php echo $row["pos_tr_count"]; ?></td>
                    <td rowspan="2"><?php echo $row["neg_tr_count"]; ?></td>
                    <td class="main"><input name="main_cnt01" class="editable_input contracts" id="main" type="number" value="<?php echo $row["main_cnt01"]; ?>" readonly="readonly" ></td>
                    <td class="runner"><input name="runner_cnt01" class="editable_input contracts" id="runner" type="number" value="<?php echo $row["runner_cnt01"]; ?>" readonly="readonly" ></td>
                    <td class="main"><input name="main_cnt02" class="editable_input contracts" id="main" type="number" value="<?php echo $row["main_cnt02"]; ?>" readonly="readonly" ></td>
                    <td class="runner"><input name="runner_cnt02" class="editable_input contracts" id="runner" type="number" value="<?php echo $row["runner_cnt02"]; ?>" readonly="readonly" ></td>
                    <td class="main"><input name="main_cnt03" class="editable_input contracts" id="main" type="number" value="<?php echo $row["main_cnt03"]; ?>" readonly="readonly" ></td>
                    <td class="runner"><input name="runner_cnt03" class="editable_input contracts" id="runner" type="number" value="<?php echo $row["runner_cnt03"]; ?>" readonly="readonly" ></td>
                    <td class="main"><input name="main_cnt04" class="editable_input contracts" id="main" type="number" value="<?php echo $row["main_cnt04"]; ?>" readonly="readonly" ></td>
                    <td class="runner"><input name="runner_cnt04" class="editable_input contracts" id="runner" type="number" value="<?php echo $row["runner_cnt04"]; ?>" readonly="readonly" ></td>
                    <td class="main"><input name="main_cnt05" class="editable_input contracts" id="main" type="number" value="<?php echo $row["main_cnt05"]; ?>" readonly="readonly" ></td>
                    <td class="runner"><input name="runner_cnt05" class="editable_input contracts" id="runner" type="number" value="<?php echo $row["runner_cnt05"]; ?>" readonly="readonly" ></td>
                    <td class="main"><input name="main_cnt06" class="editable_input contracts" id="main" type="number" value="<?php echo $row["main_cnt06"]; ?>" readonly="readonly" ></td>
                    <td class="runner"><input name="runner_cnt06" class="editable_input contracts" id="runner" type="number" value="<?php echo $row["runner_cnt06"]; ?>" readonly="readonly" ></td>
                    <td class="main"><input name="main_cnt07" class="editable_input contracts" id="main" type="number" value="<?php echo $row["main_cnt07"]; ?>" readonly="readonly" ></td>
                    <td class="runner"><input name="runner_cnt07" class="editable_input contracts" id="runner" type="number" value="<?php echo $row["runner_cnt07"]; ?>" readonly="readonly" ></td>
                    <td rowspan="2" style="display:<?php echo $display_tabl_pl; ?>;">
                    <div class="popup" onclick="openDetails(<?php echo $popupID; ?>)">
                        <?php echo $pl; ?>
                        <span class="popuptext" id="<?php echo $popupID; ?>">
                        Gain : <?php echo $row["gain"];?><br>
                        Loss : <?php echo $row["loss"]; ?><br>
                        <hr>
                        Fees : <?php echo $row["costs"]; ?></span>
                    </div>
                    </td>
                    <td rowspan="2"><button type="button" name="edit_trade" class="editbtn" id="<?php echo $row['id']; ?>">Edit</button><input type="hidden" name="trade_id" value="<?php echo $row['id']; ?>"><input type="hidden" name="current_account" value="<?php echo $current_account_id; ?>"></td>
                <!-- <td rowspan="2"><input type="image" class="editbtn" id="editbtn" alt="edit" value ="Edit" src="./img/edit-11-24.png"></td> -->
                </tr>
                <!-- points line -->
                <tr class="points">
                    <td class="main"><input name="main_pts01" class="editable_input points" id="main" type="number" value="<?php echo $row["main_pts01"]; ?>" readonly="readonly" ></td>
                    <td class="runner"><input name="runner_pts01" class="editable_input points " id="runner" type="number" value="<?php echo $row["runner_pts01"]; ?>" readonly="readonly" ></td>
                    <td class="main"><input name="main_pts02" class="editable_input points" id="main" type="number" value="<?php echo $row["main_pts02"]; ?>" readonly="readonly" ></td>
                    <td class="runner"><input name="runner_pts02" class="editable_input points" id="runner" type="number" value="<?php echo $row["runner_pts02"]; ?>" readonly="readonly" ></td>
                    <td class="main"><input name="main_pts03" class="editable_input points" id="main" type="number" value="<?php echo $row["main_pts03"]; ?>" readonly="readonly" ></td>
                    <td class="runner"><input name="runner_pts03" class="editable_input points" id="runner" type="number" value="<?php echo $row["runner_pts03"]; ?>" readonly="readonly" ></td>
                    <td class="main"><input name="main_pts04" class="editable_input points" id="main" type="number" value="<?php echo $row["main_pts04"]; ?>" readonly="readonly" ></td>
                    <td class="runner"><input name="runner_pts04" class="editable_input points" id="runner" type="number" value="<?php echo $row["runner_pts04"]; ?>" readonly="readonly" ></td>
                    <td class="main"><input name="main_pts05" class="editable_input points" id="main" type="number" value="<?php echo $row["main_pts05"]; ?>" readonly="readonly" ></td>
                    <td class="runner"><input name="runner_pts05" class="editable_input points" id="runner" type="number" value="<?php echo $row["runner_pts05"]; ?>" readonly="readonly" ></td>
                    <td class="main"><input name="main_pts06" class="editable_input points" id="main" type="number" value="<?php echo $row["main_pts06"]; ?>" readonly="readonly" ></td>
                    <td class="runner"><input name="runner_pts06" class="editable_input points" id="runner" type="number" value="<?php echo $row["runner_pts06"]; ?>" readonly="readonly" ></td>
                    <td class="main"><input name="main_pts07" class="editable_input points" id="main" type="number" value="<?php echo $row["main_pts07"]; ?>" readonly="readonly" ></td>
                    <td class="runner"><input name="runner_pts07" class="editable_input points" id="runner" type="number" value="<?php echo $row["runner_pts07"]; ?>" readonly="readonly" ></td>
                </tr>
                </form>
                </tbody> 
                <?php
          }
        }else{
      ?>
      <!-- ------------------------------------------------------------------------------------------------------------
        Tbody of the table if trade does NOT exists for the date 
      ---------------------------------------------------------------------------------------------------------------->
      <tbody id="<?php echo $today;?>">
        <form method="post">
        <tr class="contracts">
          <td rowspan="2" class="dates_cell" id="<?php echo $weekend; ?>"> <?php echo $day; ?> </td>
          <td rowspan="2"> 0 </td>
          <td rowspan="2"> 0 </td>
          <td rowspan="2"> 0 </td>
          <td class="main"><input name="main_cnt01" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
          <td class="runner"><input name="runner_cnt01" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
          <td class="main"><input name="main_cnt02" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
          <td class="runner"><input name="runner_cnt02" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
          <td class="main"><input name="main_cnt03" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
          <td class="runner"><input name="runner_cnt03" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
          <td class="main"><input name="main_cnt04" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
          <td class="runner"><input name="runner_cnt04" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
          <td class="main"><input name="main_cnt05" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
          <td class="runner"><input name="runner_cnt05" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
          <td class="main"><input name="main_cnt06" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
          <td class="runner"><input name="runner_cnt06" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
          <td class="main"><input name="main_cnt07" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
          <td class="runner"><input name="runner_cnt07" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
          <td rowspan="2" style="display:<?php echo $display_tabl_pl; ?>;"> 0 </td>
          <td rowspan="2"><button type="button" name="new_trade" class="editbtn" id="<?php echo 'btn'.$btnID; ?>">Edit</button><input type="hidden" name="trade_date" value="<?php echo $fulldate; ?>"><input type="hidden" name="current_account" value="<?php echo $current_account_id; ?>"></td>
          <!-- <td rowspan="2"><input type="image" class="editbtn" id="editbtn" alt="edit" value ="Edit" src="./img/edit-11-24.png"></td> -->
        </tr>
        <tr class="points">
          <td class="main"><input name="main_pts01" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
          <td class="runner"><input name="runner_pts01" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
          <td class="main"><input name="main_pts02" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
          <td class="runner"><input name="runner_pts02" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
          <td class="main"><input name="main_pts03" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
          <td class="runner"><input name="runner_pts03" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
          <td class="main"><input name="main_pts04" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
          <td class="runner"><input name="runner_pts04" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
          <td class="main"><input name="main_pts05" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
          <td class="runner"><input name="runner_pts05" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
          <td class="main"><input name="main_pts06" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
          <td class="runner"><input name="runner_pts06" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
          <td class="main"><input name="main_pts07" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
          <td class="runner"><input name="runner_pts07" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
        </tr>
    </form>
    </tbody> 
      <?php
        }// if data, else no data
      } //else not weekend ?>

  <?php } //SQL data SELECT
  // for each dates ?>
</table>
