<tr style="width:100%;">
    <?php /* Designed and developed by Gilbert Karogo K., a product of umatidocs.com */   
	$myClientloan = mvc_model("simplelenderClientloan")->find_by_id($object->trans_id);
	$myClientaccount = mvc_model("simplelenderClientaccount")->find_by_id($myClientloan->client_id);
	
	//echo $this->html->traffic_manager_link($object); ?>
	<td class="sl_list_single_item">
		<?php /* Designed and developed by Gilbert Karogo K., a product of umatidocs.com */   
			if (isset($myClientaccount->acc_number)){
				echo simplelender_class("simplelender_account")->get_user_name_from_acc_no($myClientaccount->acc_number);
				echo "(".$myClientaccount->acc_number.")";
			}
			else{
				echo '-Not Set-';
			}
		?>
	
	</td>
	<td class="sl_list_single_item">
		<?php /* Designed and developed by Gilbert Karogo K., a product of umatidocs.com */   
			if (isset($object->trans_id))
				echo $object->trans_id;
			else
				echo '-Not Set-';
		?>
	</td>
	<td class="sl_list_single_item">
		<?php /* Designed and developed by Gilbert Karogo K., a product of umatidocs.com */  
		$trans_title=array(
				"1"=>"Loan Issued",
				"2"=>"Loan Repayed",
			);
			if (isset($object->dr_cr))
				echo $trans_title[$object->dr_cr]." (".$object->id.")";
			else
				echo '-Not Set-';
		?>
	</td>
	<td class="sl_list_single_item">
		<?php /* Designed and developed by Gilbert Karogo K., a product of umatidocs.com */   
			if (isset($object->trans_amount))
				echo $object->trans_amount;
			else
				echo '-Not Set-';
		?>
	</td>
	<td class="sl_list_single_item">
		<?php /* Designed and developed by Gilbert Karogo K., a product of umatidocs.com */   
			if (isset($object->__id)){
					//echo "<a class='sl_house_keeping_link' href=".mvc_admin_url(array('controller' => 'admin_simplelender_dentries', 'action' => 'edit', 'id' => $object->__id)).">Manage</a>";
					if($object->trans_type == 1 && $object->dr_cr==1){						
						//echo " | <a class='' href=".mvc_admin_url(array('controller' => 'admin_simplelender_dentries', 'action' => 'repay', 'id' => $object->__id)).">Repay</a>";
					}
				}				
				else
					//echo '---';
		?>
	</td>
</tr>