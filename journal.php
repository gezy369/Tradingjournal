<table>
    <!-- ---------------------------------------------
        table header (not in a loop)
    ------------------------------------------------->
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
            <th colspan="2" class="trade" style="display:<?php echo $display_full_table; ?>;"> Trade - 8 </th>
            <th colspan="2" class="trade" style="display:<?php echo $display_full_table; ?>;"> Trade - 9 </th>
            <th colspan="2" class="trade" style="display:<?php echo $display_full_table; ?>;"> Trade - 10 </th>
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
            <th style="display:<?php echo $display_full_table; ?>;"> Main </th>
            <th style="display:<?php echo $display_full_table; ?>;"> Runner </th>
            <th style="display:<?php echo $display_full_table; ?>;"> Main </th>
            <th style="display:<?php echo $display_full_table; ?>;"> Runner </th>
            <th style="display:<?php echo $display_full_table; ?>;"> Main </th>
            <th style="display:<?php echo $display_full_table; ?>;"> Runner </th>
            <th class="daily" style="display:<?php echo $display_tabl_pl; ?>;"> Net G/L </th>
        </tr>
    </thead>

    <!-- ---------------------------------------------
        Put all the days of the month in an array
        to be used to populate the journal table
    ------------------------------------------------->
    <?php
    while ($oStart->getTimestamp() < $oEnd->getTimestamp()) {
        $aDates[] = $oStart->format('D d');
        $oStart->add(new DateInterval("P1D"));
    }

    /*-- ---------------------------------------------
        Sets different variables dates 
    -------------------------------------------------*/
    foreach ($aDates as $day) {
        $FuncDay = substr($day, -2);
        $weekend = check_weekend($FuncDay,$month,$year);    //to test if date is a weekend
        $today = check_day($FuncDay,$month,$year);          //test if the dat is today
        $fulldate = $year."-".$month."-".$FuncDay;          //to use in SELECT query     
        $btnID ++;                                          //increase butons IDs
        $popupID ++;                                        //increase butons IDs

        
        
        /*-- ---------------------------------------------
            Will display a <tr> if detected as a weekend
            ELSE displays the week days
        -------------------------------------------------*/
        if ($weekend == "weekend") {
            if ($tr == 0){?>
                <tr>
                <td id="weekendDay" colspan="26">weekend</td>
                </tr>
                <?php $tr ++;
            }else{
                $tr = 0;
            }?>
            <?php
        }else{
            
            /*-- ---------------------------------------------
                Fetch trades in DB
            -------------------------------------------------*/
            $sql = "SELECT * FROM trades WHERE trade_date='$fulldate' AND acc_fid='$current_account_id'";
            $result = $conn->query($sql); 

            /*-- ---------------------------------------------
                IF trades for the date, diaplays them
            -------------------------------------------------*/
            if ($result->num_rows > 0) {
                
                //while there are data to display
                while($row = $result->fetch_assoc()) {
                    
                    //p&l calculation
                    $pl = ($row["gain"] + $row["loss"]) - $row["costs"];
                    ?>
                    <tbody id="<?php echo $today;?>">

                        <form method="post">

                            <!-- ---------------------------------------------
                                CONTRACTS
                            ------------------------------------------------->
                            <tr class="contracts">
                                <td rowspan="2" class="dates_cell" id="<?php echo $weekend; ?>"> <?php echo $day; ?> </td>
                                <td rowspan="2"><?php echo $total = $row["pos_tr_count"]+$row["neg_tr_count"]; ?></td>
                                <td rowspan="2"><?php echo $row["pos_tr_count"]; ?></td>
                                <td rowspan="2"><?php echo $row["neg_tr_count"]; ?></td>
                                <td class="main"><input name="main_cnt1" class="editable_input contracts" id="main" type="number" value="<?php echo $row["main_cnt1"]; ?>" readonly="readonly" ></td>
                                <td class="runner"><input name="runner_cnt1" class="editable_input contracts" id="runner" type="number" value="<?php echo $row["runner_cnt1"]; ?>" readonly="readonly" ></td>
                                <td class="main"><input name="main_cnt2" class="editable_input contracts" id="main" type="number" value="<?php echo $row["main_cnt2"]; ?>" readonly="readonly" ></td>
                                <td class="runner"><input name="runner_cnt2" class="editable_input contracts" id="runner" type="number" value="<?php echo $row["runner_cnt2"]; ?>" readonly="readonly" ></td>
                                <td class="main"><input name="main_cnt3" class="editable_input contracts" id="main" type="number" value="<?php echo $row["main_cnt3"]; ?>" readonly="readonly" ></td>
                                <td class="runner"><input name="runner_cnt3" class="editable_input contracts" id="runner" type="number" value="<?php echo $row["runner_cnt3"]; ?>" readonly="readonly" ></td>
                                <td class="main"><input name="main_cnt4" class="editable_input contracts" id="main" type="number" value="<?php echo $row["main_cnt4"]; ?>" readonly="readonly" ></td>
                                <td class="runner"><input name="runner_cnt4" class="editable_input contracts" id="runner" type="number" value="<?php echo $row["runner_cnt4"]; ?>" readonly="readonly" ></td>
                                <td class="main"><input name="main_cnt5" class="editable_input contracts" id="main" type="number" value="<?php echo $row["main_cnt5"]; ?>" readonly="readonly" ></td>
                                <td class="runner"><input name="runner_cnt5" class="editable_input contracts" id="runner" type="number" value="<?php echo $row["runner_cnt5"]; ?>" readonly="readonly" ></td>
                                <td class="main"><input name="main_cnt6" class="editable_input contracts" id="main" type="number" value="<?php echo $row["main_cnt6"]; ?>" readonly="readonly" ></td>
                                <td class="runner"><input name="runner_cnt6" class="editable_input contracts" id="runner" type="number" value="<?php echo $row["runner_cnt6"]; ?>" readonly="readonly" ></td>
                                <td class="main"><input name="main_cnt7" class="editable_input contracts" id="main" type="number" value="<?php echo $row["main_cnt7"]; ?>" readonly="readonly" ></td>
                                <td class="runner"><input name="runner_cnt7" class="editable_input contracts" id="runner" type="number" value="<?php echo $row["runner_cnt7"]; ?>" readonly="readonly" ></td>
                                <td class="main" style="display:<?php echo $display_full_table; ?>;"><input name="main_cnt8" class="editable_input contracts" id="main" type="number" value="<?php echo $row["main_cnt8"]; ?>" readonly="readonly" ></td>
                                <td class="runner" style="display:<?php echo $display_full_table; ?>;"><input name="runner_cnt8" class="editable_input contracts" id="runner" type="number" value="<?php echo $row["runner_cnt8"]; ?>" readonly="readonly" ></td>
                                <td class="main" style="display:<?php echo $display_full_table; ?>;"><input name="main_cnt9" class="editable_input contracts" id="main" type="number" value="<?php echo $row["main_cnt9"]; ?>" readonly="readonly" ></td>
                                <td class="runner" style="display:<?php echo $display_full_table; ?>;"><input name="runner_cnt9" class="editable_input contracts" id="runner" type="number" value="<?php echo $row["runner_cnt9"]; ?>" readonly="readonly" ></td>
                                <td class="main" style="display:<?php echo $display_full_table; ?>;"><input name="main_cnt10" class="editable_input contracts" id="main" type="number" value="<?php echo $row["main_cnt10"]; ?>" readonly="readonly" ></td>
                                <td class="runner" style="display:<?php echo $display_full_table; ?>;"><input name="runner_cnt10" class="editable_input contracts" id="runner" type="number" value="<?php echo $row["runner_cnt10"]; ?>" readonly="readonly" ></td>
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

                            <!-- ---------------------------------------------
                                POINTS
                            ------------------------------------------------->
                            <tr class="points">
                                <td class="main"><input name="main_pts1" class="editable_input points" id="main" type="number" value="<?php echo $row["main_pts1"]; ?>" readonly="readonly" ></td>
                                <td class="runner"><input name="runner_pts1" class="editable_input points " id="runner" type="number" value="<?php echo $row["runner_pts1"]; ?>" readonly="readonly" ></td>
                                <td class="main"><input name="main_pts2" class="editable_input points" id="main" type="number" value="<?php echo $row["main_pts2"]; ?>" readonly="readonly" ></td>
                                <td class="runner"><input name="runner_pts2" class="editable_input points" id="runner" type="number" value="<?php echo $row["runner_pts2"]; ?>" readonly="readonly" ></td>
                                <td class="main"><input name="main_pts3" class="editable_input points" id="main" type="number" value="<?php echo $row["main_pts3"]; ?>" readonly="readonly" ></td>
                                <td class="runner"><input name="runner_pts3" class="editable_input points" id="runner" type="number" value="<?php echo $row["runner_pts3"]; ?>" readonly="readonly" ></td>
                                <td class="main"><input name="main_pts4" class="editable_input points" id="main" type="number" value="<?php echo $row["main_pts4"]; ?>" readonly="readonly" ></td>
                                <td class="runner"><input name="runner_pts4" class="editable_input points" id="runner" type="number" value="<?php echo $row["runner_pts4"]; ?>" readonly="readonly" ></td>
                                <td class="main"><input name="main_pts5" class="editable_input points" id="main" type="number" value="<?php echo $row["main_pts5"]; ?>" readonly="readonly" ></td>
                                <td class="runner"><input name="runner_pts5" class="editable_input points" id="runner" type="number" value="<?php echo $row["runner_pts5"]; ?>" readonly="readonly" ></td>
                                <td class="main"><input name="main_pts6" class="editable_input points" id="main" type="number" value="<?php echo $row["main_pts6"]; ?>" readonly="readonly" ></td>
                                <td class="runner"><input name="runner_pts6" class="editable_input points" id="runner" type="number" value="<?php echo $row["runner_pts6"]; ?>" readonly="readonly" ></td>
                                <td class="main"><input name="main_pts7" class="editable_input points" id="main" type="number" value="<?php echo $row["main_pts7"]; ?>" readonly="readonly" ></td>
                                <td class="runner"><input name="runner_pts7" class="editable_input points" id="runner" type="number" value="<?php echo $row["runner_pts7"]; ?>" readonly="readonly" ></td>
                                <td class="main" style="display:<?php echo $display_full_table; ?>;"><input name="main_pts8" class="editable_input contracts" id="main" type="number" value="<?php echo $row["main_pts8"]; ?>" readonly="readonly" ></td>
                                <td class="runner" style="display:<?php echo $display_full_table; ?>;"><input name="runner_pts8" class="editable_input contracts" id="runner" type="number" value="<?php echo $row["runner_pts8"]; ?>" readonly="readonly" ></td>
                                <td class="main" style="display:<?php echo $display_full_table; ?>;"><input name="main_pts9" class="editable_input contracts" id="main" type="number" value="<?php echo $row["main_pts9"]; ?>" readonly="readonly" ></td>
                                <td class="runner" style="display:<?php echo $display_full_table; ?>;"><input name="runner_pts9" class="editable_input contracts" id="runner" type="number" value="<?php echo $row["runner_pts9"]; ?>" readonly="readonly" ></td>
                                <td class="main" style="display:<?php echo $display_full_table; ?>;"><input name="main_pts10" class="editable_input contracts" id="main" type="number" value="<?php echo $row["main_pts10"]; ?>" readonly="readonly" ></td>
                                <td class="runner" style="display:<?php echo $display_full_table; ?>;"><input name="runner_pts10" class="editable_input contracts" id="runner" type="number" value="<?php echo $row["runner_pts10"]; ?>" readonly="readonly" ></td>
                            </tr>
                        </form>
                    </tbody> 
                    <?php
                } //while

            }else{ ?>





                <!-- ---------------------------------------------
                    table body without trade informationaaa
                ------------------------------------------------->
                <tbody id="<?php echo $today;?>">
                    <form method="post">
                        <!-- ---------------------------------------------
                            CONTRACTS
                        ------------------------------------------------->
                        <tr class="contracts">
                            <td rowspan="2" class="dates_cell" id="<?php echo $weekend; ?>"> <?php echo $day; ?> </td>
                            <td rowspan="2"> 0 </td>
                            <td rowspan="2"> 0 </td>
                            <td rowspan="2"> 0 </td>
                            <td class="main"><input name="main_cnt1" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                            <td class="runner"><input name="runner_cnt1" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                            <td class="main"><input name="main_cnt2" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                            <td class="runner"><input name="runner_cnt2" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                            <td class="main"><input name="main_cnt3" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                            <td class="runner"><input name="runner_cnt3" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                            <td class="main"><input name="main_cnt4" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                            <td class="runner"><input name="runner_cnt4" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                            <td class="main"><input name="main_cnt5" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                            <td class="runner"><input name="runner_cnt5" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                            <td class="main"><input name="main_cnt6" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                            <td class="runner"><input name="runner_cnt6" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                            <td class="main"><input name="main_cnt7" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                            <td class="runner"><input name="runner_cnt7" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                            <td class="main" style="display:<?php echo $display_full_table; ?>;"><input name="main_cnt8" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                            <td class="runner" style="display:<?php echo $display_full_table; ?>;"><input name="runner_cnt8" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                            <td class="main" style="display:<?php echo $display_full_table; ?>;"><input name="main_cnt9" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                            <td class="runner" style="display:<?php echo $display_full_table; ?>;"><input name="runner_cnt9" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                            <td class="main" style="display:<?php echo $display_full_table; ?>;"><input name="main_cnt010" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                            <td class="runner" style="display:<?php echo $display_full_table; ?>;"><input name="runner_cnt10" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                            <td rowspan="2" style="display:<?php echo $display_tabl_pl; ?>;"> 0 </td>
                            <td rowspan="2"><button type="button" name="new_trade" class="editbtn" id="<?php echo 'btn'.$btnID; ?>">Edit</button><input type="hidden" name="trade_date" value="<?php echo $fulldate; ?>"><input type="hidden" name="current_account" value="<?php echo $current_account_id; ?>"></td>
                        <!-- <td rowspan="2"><input type="image" class="editbtn" id="editbtn" alt="edit" value ="Edit" src="./img/edit-11-24.png"></td> -->
                        </tr>
                        <!-- ---------------------------------------------
                            POINTS
                        ------------------------------------------------->
                        <tr class="points">
                            <td class="main"><input name="main_pts1" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                            <td class="runner"><input name="runner_pts1" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                            <td class="main"><input name="main_pts2" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                            <td class="runner"><input name="runner_pts2" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                            <td class="main"><input name="main_pts3" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                            <td class="runner"><input name="runner_pts3" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                            <td class="main"><input name="main_pts4" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                            <td class="runner"><input name="runner_pts4" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                            <td class="main"><input name="main_pts5" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                            <td class="runner"><input name="runner_pts5" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                            <td class="main"><input name="main_pts6" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                            <td class="runner"><input name="runner_pts6" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                            <td class="main"><input name="main_pts7" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                            <td class="runner"><input name="runner_pts7" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                            <td class="main"style="display:<?php echo $display_full_table; ?>;"><input name="main_pts8" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                            <td class="runner" style="display:<?php echo $display_full_table; ?>;"><input name="runner_pts8" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                            <td class="main" style="display:<?php echo $display_full_table; ?>;"><input name="main_pts9" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                            <td class="runner" style="display:<?php echo $display_full_table; ?>;"><input name="runner_pts9" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                            <td class="main" style="display:<?php echo $display_full_table; ?>;"><input name="main_pts10" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                            <td class="runner" style="display:<?php echo $display_full_table; ?>;"><input name="runner_pts10" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                        </tr>
                    </form>
                </tbody> 
                <?php
            }// if data, else no data
        } //else not weekend ?>
            
        <?php 
    }   // for each dates 
        ?>
</table>