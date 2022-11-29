<?php

add_action( 'pmxi_saved_post', 'soflyy_add_data', 10, 3 );

function soflyy_add_data( $id, $xml, $update ) {
//function add_user_repeater_data( $id) {

    // Parent field name.
    $selector = 'new_investment';//investor_data
	
	$user_id = 'user_' . $id;


	$user_passport_id = get_user_meta( $id, 'user_passport_id', true);
	if ( empty( $user_passport_id ) ) {
		wp_delete_user($id);
	}
	
	$rows = get_field($selector,$user_id);	
	
	
	$temp_new_date_of_joining_the_fund = get_user_meta( $id, 'temp_new_date_of_joining_the_fund', true);
	$temp_new_investment_date = get_user_meta( $id, 'temp_new_investment_date', true);
	$temp_new_import_date = get_user_meta( $id, 'temp_new_import_date', true);
	$temp_new_original_investment_amount_in_the_fund_on_the_date_of_investment = get_user_meta( $id, 'temp_new_original_investment_amount_in_the_fund_on_the_date_of_investment', true);
	$temp_new_investment_fund = get_user_meta( $id, 'temp_new_investment_fund', true);	
	
	//тут нужно понять есть ли уже такая строка или нужно создавать новую
	$investment_exist = false;
	foreach($rows as $row) {
		$date_of_joining_the_fund = $row['date_of_joining_the_fund'];
		$new_investment_date = $row['new_investment_date'];
		$investment_fund = $row['investment_fund'];
		/*echo "<br />";
		echo date("d/m/Y", strtotime($temp_new_date_of_joining_the_fund));
		echo "<br />";
		echo date("d/m/Y", strtotime($temp_new_date_of_joining_the_fund));*/
		if (
			($date_of_joining_the_fund == date("d/m/Y", strtotime($temp_new_date_of_joining_the_fund)))
			&&
			($new_investment_date == date("d/m/Y", strtotime($temp_new_investment_date)))
			&&
			($investment_fund == $temp_new_investment_fund)
			){
				$investment_exist = true;
				echo "<br /><b>investment_exist = true</b><br />";
		}else{
			echo "<br /><b>investment_exist = false</b><br />";
		}
	}
	
	//если инвистиция существует
	if ( $investment_exist == true ) {
		$i = 1;
		foreach($rows as $row) {
			$date_of_joining_the_fund = $row['date_of_joining_the_fund'];
			$new_investment_date = $row['new_investment_date'];			
			$new_original_investment_amount_in_the_fund_on_the_date_of_investment = $row['new_original_investment_amount_in_the_fund_on_the_date_of_investment'];
			$investment_fund = $row['investment_fund'];
			
			
			// если Date of joining the fund, Original investment amount in the fund on the date of investment и ID фонда  совпали в экселе и у юзера
			// мы должны или обновить данные или добавить новые
			if ( ($new_investment_date == date("d/m/Y", strtotime($temp_new_investment_date)))
				&&
				($date_of_joining_the_fund == date("d/m/Y", strtotime($temp_new_date_of_joining_the_fund)))
				&&
				($investment_fund == $temp_new_investment_fund) ){
					$sub_rows = $row['variable_data'];
					$sub_i = 1;
					
					//берем все даты из истории импортов и смотрим есть ли там наша текущая дата импорта
					//если нету (if) то создадим 
					//если есть (else) то обновим
					if ( !empty($temp_new_import_date) && !in_array(date("d/m/Y", strtotime($temp_new_import_date)), array_column($sub_rows, 'variable_import_date')) ) {
						$temp_variable_annual_opening_balance = get_user_meta( $id, 'temp_variable_annual_opening_balance', true);
						$temp_variable_monthly_expenses = get_user_meta( $id, 'temp_variable_monthly_expenses', true);
						$temp_variable_management_fee = get_user_meta( $id, 'temp_variable_management_fee', true);
						$temp_variable_success_fees = get_user_meta( $id, 'temp_variable_success_fees', true);
						$temp_variable_tax_to_be_paid = get_user_meta( $id, 'temp_variable_tax_to_be_paid', true);
						$temp_variable_balance_to_partner_after_expenses_and_management_fees = get_user_meta( $id, 'temp_variable_balance_to_partner_after_expenses_and_management_fees', true);
						$temp_variable_yield_percentage_for_the_month_of_the_report = get_user_meta( $id, 'temp_variable_yield_percentage_for_the_month_of_the_report', true);
						$temp_variable_cumulative_return_for_year = get_user_meta( $id, 'temp_variable_cumulative_return_for_year', true);
						$temp_variable_cumulative_gain_lose = get_user_meta( $id, 'temp_variable_cumulative_gain_lose', true);
						$temp_variable_balance_after_success_fee = get_user_meta( $id, 'temp_variable_balance_after_success_fee', true);
						$temp_variable_success_fee_percentage = get_user_meta( $id, 'temp_variable_success_fee_percentage', true);
						$row = array(
								'variable_import_date' => $temp_new_import_date,
								'variable_annual_opening_balance' => $temp_variable_annual_opening_balance,
								'variable_monthly_expenses'  => $temp_variable_monthly_expenses,
								'variable_management_fee'  => $temp_variable_management_fee,
								'variable_success_fees'  => $temp_variable_success_fees,
								'variable_tax_to_be_paid'  => $temp_variable_tax_to_be_paid,
								'variable_balance_to_partner_after_expenses_and_management_fees'  => $temp_variable_balance_to_partner_after_expenses_and_management_fees,
								'variable_yield_percentage_for_the_month_of_the_report'  => $temp_variable_yield_percentage_for_the_month_of_the_report,
								'variable_cumulative_return_for_year'  => $temp_variable_cumulative_return_for_year,
								'variable_cumulative_gain_lose'  => $temp_variable_cumulative_gain_lose,
								'variable_balance_after_success_fee'  => $temp_variable_balance_after_success_fee,
								'variable_success_fee_percentage'  => $temp_variable_success_fee_percentage,
							);
						
						add_sub_row( array('new_investment', $i, 'variable_data'), $row, $user_id );
					} else {
						// нужно понять в какой строке наша дата импорта. Найти и обновить данные по ней
						foreach($sub_rows as $sub_row) {
							$variable_import_date = $sub_row['variable_import_date'];
							/*$variable_annual_opening_balance = $sub_row['variable_annual_opening_balance'];
							$variable_monthly_expenses = $sub_row['variable_monthly_expenses'];
							$variable_management_fee = $sub_row['variable_management_fee'];
							$variable_success_fees = $sub_row['variable_success_fees'];
							$variable_tax_to_be_paid = $sub_row['variable_tax_to_be_paid'];
							$variable_balance_to_partner_after_expenses_and_management_fees = $sub_row['variable_balance_to_partner_after_expenses_and_management_fees'];
							$variable_yield_percentage_for_the_month_of_the_report = $sub_row['variable_yield_percentage_for_the_month_of_the_report'];
							$variable_cumulative_return_for_year = $sub_row['variable_cumulative_return_for_year'];
							$variable_cumulative_gain_lose = $sub_row['variable_cumulative_gain_lose'];
							$variable_balance_after_success_fee = $sub_row['variable_balance_after_success_fee'];
							$variable_success_fee_percentage = $sub_row['variable_success_fee_percentage'];*/
							
							$temp_new_import_date = get_user_meta( $id, 'temp_new_import_date', true);
							
							//в этом месте я нахожу строку в которой совпали даты импорта
							//именно её нужно обновить новыми данными с экселя
							if ( $variable_import_date == date("d/m/Y", strtotime($temp_new_import_date)) ){
								$temp_variable_annual_opening_balance = get_user_meta( $id, 'temp_variable_annual_opening_balance', true);
								$temp_variable_monthly_expenses = get_user_meta( $id, 'temp_variable_monthly_expenses', true);
								$temp_variable_management_fee = get_user_meta( $id, 'temp_variable_management_fee', true);
								$temp_variable_success_fees = get_user_meta( $id, 'temp_variable_success_fees', true);
								$temp_variable_tax_to_be_paid = get_user_meta( $id, 'temp_variable_tax_to_be_paid', true);
								$temp_variable_balance_to_partner_after_expenses_and_management_fees = get_user_meta( $id, 'temp_variable_balance_to_partner_after_expenses_and_management_fees', true);
								$temp_variable_yield_percentage_for_the_month_of_the_report = get_user_meta( $id, 'temp_variable_yield_percentage_for_the_month_of_the_report', true);
								$temp_variable_cumulative_return_for_year = get_user_meta( $id, 'temp_variable_cumulative_return_for_year', true);
								$temp_variable_cumulative_gain_lose = get_user_meta( $id, 'temp_variable_cumulative_gain_lose', true);
								$temp_variable_balance_after_success_fee = get_user_meta( $id, 'temp_variable_balance_after_success_fee', true);
								$temp_variable_success_fee_percentage = get_user_meta( $id, 'temp_variable_success_fee_percentage', true);
								
								$value = array(
									'variable_import_date' => $temp_new_import_date,
									'variable_annual_opening_balance' => $temp_variable_annual_opening_balance,
									'variable_monthly_expenses'  => $temp_variable_monthly_expenses,
									'variable_management_fee'  => $temp_variable_management_fee,
									'variable_success_fees'  => $temp_variable_success_fees,
									'variable_tax_to_be_paid'  => $temp_variable_tax_to_be_paid,
									'variable_balance_to_partner_after_expenses_and_management_fees'  => $temp_variable_balance_to_partner_after_expenses_and_management_fees,
									'variable_yield_percentage_for_the_month_of_the_report'  => $temp_variable_yield_percentage_for_the_month_of_the_report,
									'variable_cumulative_return_for_year'  => $temp_variable_cumulative_return_for_year,
									'variable_cumulative_gain_lose'  => $temp_variable_cumulative_gain_lose,
									'variable_balance_after_success_fee'  => $temp_variable_balance_after_success_fee,
									'variable_success_fee_percentage'  => $temp_variable_success_fee_percentage,
								);
								update_sub_row( array('new_investment', $i, 'variable_data'), $sub_i, $value, $user_id );
							}
							$sub_i ++;
						}
					}
			}		
			$i ++;
		}
	} else {
		//тут мы добавляем новую инвестицию
		$row_data = array(
			'date_of_joining_the_fund' => $temp_new_date_of_joining_the_fund,
			'new_investment_date' => $temp_new_investment_date,			
			'new_original_investment_amount_in_the_fund_on_the_date_of_investment' => $temp_new_original_investment_amount_in_the_fund_on_the_date_of_investment,
			'investment_fund' => $temp_new_investment_fund,
			'variable_data' => array(
			)
		);
		add_row($selector,$row_data,$user_id);
		$temp_variable_annual_opening_balance = get_user_meta( $id, 'temp_variable_annual_opening_balance', true);
		$temp_variable_monthly_expenses = get_user_meta( $id, 'temp_variable_monthly_expenses', true);
		$temp_variable_management_fee = get_user_meta( $id, 'temp_variable_management_fee', true);
		$temp_variable_success_fees = get_user_meta( $id, 'temp_variable_success_fees', true);
		$temp_variable_tax_to_be_paid = get_user_meta( $id, 'temp_variable_tax_to_be_paid', true);
		$temp_variable_balance_to_partner_after_expenses_and_management_fees = get_user_meta( $id, 'temp_variable_balance_to_partner_after_expenses_and_management_fees', true);
		$temp_variable_yield_percentage_for_the_month_of_the_report = get_user_meta( $id, 'temp_variable_yield_percentage_for_the_month_of_the_report', true);
		$temp_variable_cumulative_return_for_year = get_user_meta( $id, 'temp_variable_cumulative_return_for_year', true);
		$temp_variable_cumulative_gain_lose = get_user_meta( $id, 'temp_variable_cumulative_gain_lose', true);
		$temp_variable_balance_after_success_fee = get_user_meta( $id, 'temp_variable_balance_after_success_fee', true);
		$temp_variable_success_fee_percentage = get_user_meta( $id, 'temp_variable_success_fee_percentage', true);
		$row = array(
				'variable_import_date' => $temp_new_import_date,
				'variable_annual_opening_balance' => $temp_variable_annual_opening_balance,
				'variable_monthly_expenses'  => $temp_variable_monthly_expenses,
				'variable_management_fee'  => $temp_variable_management_fee,
				'variable_success_fees'  => $temp_variable_success_fees,
				'variable_tax_to_be_paid'  => $temp_variable_tax_to_be_paid,
				'variable_balance_to_partner_after_expenses_and_management_fees'  => $temp_variable_balance_to_partner_after_expenses_and_management_fees,
				'variable_yield_percentage_for_the_month_of_the_report'  => $temp_variable_yield_percentage_for_the_month_of_the_report,
				'variable_cumulative_return_for_year'  => $temp_variable_cumulative_return_for_year,
				'variable_cumulative_gain_lose'  => $temp_variable_cumulative_gain_lose,
				'variable_balance_after_success_fee'  => $temp_variable_balance_after_success_fee,
				'variable_success_fee_percentage'  => $temp_variable_success_fee_percentage,
			);
		$rows = get_field($selector,$user_id);
		add_sub_row( array('new_investment', count($rows), 'variable_data'), $row, $user_id );
		
		
	}
	
	

	
	
	/*
	if ( !empty($temp_new_investment_date) && !in_array(date("d/m/Y", strtotime($temp_new_investment_date)), array_column($rows, 'new_investment_date')) ) {
		$row_data = array(
			'date_of_joining_the_fund' => $temp_new_date_of_joining_the_fund,
			'new_investment_date' => $temp_new_investment_date,
			'new_original_investment_amount_in_the_fund_on_the_date_of_investment' => $temp_new_original_investment_amount_in_the_fund_on_the_date_of_investment,
			'investment_fund' => $temp_new_investment_fund,			
		);		
		add_row($selector,$row_data,$user_id);
		
	} else if ( !empty($temp_new_investment_date) && in_array($date->format('d/m/Y'), array_column($rows, 'new_investment_date')) ) {
		$i = 1;
		foreach($rows as $row) {
			$date_of_joining_the_fund = $row['date_of_joining_the_fund'];
			$new_investment_date = $row['new_investment_date'];			
			$new_original_investment_amount_in_the_fund_on_the_date_of_investment = $row['new_original_investment_amount_in_the_fund_on_the_date_of_investment'];
			$investment_fund = $row['investment_fund'];
			
			echo "$new_investment_date = " . $new_investment_date . "<br />";			
			echo "$temp_new_investment_date = " . date("d/m/Y", strtotime($temp_new_investment_date)) . "<br />";
			echo "<br />" . "------------" . "<br />";
			if ( $new_investment_date == date("d/m/Y", strtotime($temp_new_investment_date)) ){			
				$row_data = array(
					'date_of_joining_the_fund' => $temp_new_date_of_joining_the_fund,
					'new_investment_date' => $temp_new_investment_date,
					'new_original_investment_amount_in_the_fund_on_the_date_of_investment' => $temp_new_original_investment_amount_in_the_fund_on_the_date_of_investment,
					'investment_fund' => $temp_new_investment_fund,				
				);
				update_row("new_investment", $i, $row_data, $user_id);	
			}
			$i++;
		}
	}*/
	delete_user_meta( $id, 'temp_new_date_of_joining_the_fund' );
	delete_user_meta( $id, 'temp_new_investment_date' );
	delete_user_meta( $id, 'temp_new_import_date' );
	delete_user_meta( $id, 'temp_new_original_investment_amount_in_the_fund_on_the_date_of_investment' );
	delete_user_meta( $id, 'temp_variable_annual_opening_balance' );
	delete_user_meta( $id, 'temp_variable_monthly_expenses' );
	delete_user_meta( $id, 'temp_variable_management_fee' );
	delete_user_meta( $id, 'temp_variable_success_fees' );
	delete_user_meta( $id, 'temp_variable_tax_to_be_paid' );
	delete_user_meta( $id, 'temp_variable_balance_to_partner_after_expenses_and_management_fees' );
	delete_user_meta( $id, 'temp_variable_yield_percentage_for_the_month_of_the_report' );
	delete_user_meta( $id, 'temp_variable_cumulative_return_for_year' );
	delete_user_meta( $id, 'temp_variable_cumulative_gain_lose' );
	delete_user_meta( $id, 'temp_variable_balance_after_success_fee' );
	delete_user_meta( $id, 'temp_variable_success_fee_percentage' );
	delete_user_meta( $id, 'temp_new_investment_fund' );

}

?>