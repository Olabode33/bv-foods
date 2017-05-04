								<table class="table order-items" width="100%">
									<thead>
										<tr>
											<th width="50%">Item</th>
											<th width="20%">Qty</th>
											<th width="25%">Price</th>
										</tr>
									</thead>
									<tbody>
									<?php 
										$count = 1;
										$total = 0;
										
										if(isset($_SESSION['order']) && count($_SESSION['order']) > 0){
											foreach($_SESSION['order'] as $id=>$value){
												if($id != 0){
													echo '<tr>
																<td>'.$utility_obj->getObjectFromID('tbl_menu_items', 'menu_item', 'menu_item_id', $id).'</td>
																<td>'.number_format($_SESSION['order'][$id]['quantity'], 0).'</td>
																<td>'.number_format($_SESSION['order'][$id]['price'], 0).'</td>
																<td>
																	<button type="button" class="btn-menu-select text-danger"  data-toggle="modal" data-target="#removeOrder" data-img="'.$utility_obj->getObjectFromID('tbl_menu_items','image', 'menu_item_id', $id).'" 
																		data-item="'.$utility_obj->getObjectFromID('tbl_menu_items', 'menu_item', 'menu_item_id', $id).'" data-id="'.$id.'" data-price="'.$_SESSION['order'][$id]['price'].'" 
																		data-tprice="'.number_format($_SESSION['order'][$id]['price'], 2).'" data-qty="'.$_SESSION['order'][$id]['quantity'].'">
																		<span class="fa fa-times-circle"></span>
																	</button>
																</td>
															</tr>';
															
													$total += $_SESSION['order'][$id]['price'] * $_SESSION['order'][$id]['quantity'];
													$count++;
												}
											}
											echo '<tr>
														<td><b>Total </b></td>
														<td>&nbsp;</td>
														<td><b>'.number_format($total,2).'</b></td>
													 </tr>';
										}
										else {
											echo '<tr><td colspan="3">You haven\'t selected any item</td></tr>';
										}
									?>
									</tbody>
								</table>
								
								