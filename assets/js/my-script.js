
		// $(window).scroll(function (event){
			// var scroll_pos = $(window).scrollTop();
			
			// if(scroll_pos > 60) {
				// $('#nav').addClass('navbar-fixed-bottom');
				// $('#navBrand').removeClass('hidden');
			// }
			// else {
				// $('#nav').removeClass('navbar-fixed-bot');
				// $('#navBrand').addClass('hidden');
			// }
			
		// });

		function loading() {
			var btn = $(event.currentTarget);
			var btn_txt = $(btn).children('i').text()
			var btn_class = $(btn).children('i').attr('class')
			//alert(btn_class);
			//$('#loading').show(); //<----here
			$(btn).children('i').removeClass(btn_class)
			$(btn).children('i').text('')
			$(btn).children('i').addClass('fa fa-spinner fa-pulse')
  			$.ajax({
				success:function(result){
					$(btn).children('i').removeClass('fa fa-spinner fa-pulse')
					$(btn).children('i').addClass(btn_class)
					$(btn).children('i').text(btn_txt)
   				}
			});
		}
		
		$('#yourOrder').on('show.bs.modal', function (event) {
			var btn = $(event.relatedTarget);
			var item = btn.data('item');
			var item_id = btn.data('id');
			var price = btn.data('price');
			var tprice = btn.data('tprice');
			var img = btn.data('img');
			var etime = btn.data('etime');
			
			var modal = $(this);
			modal.find('#menu_item').text(item);
			modal.find('#txtprice').text(tprice);
			modal.find('#ttlprice').text(tprice);
			modal.find('[name="item"]').val(item_id);
			modal.find('[name="price"]').val(price);
			modal.find('#etime').text(etime);
			modal.find('#img').attr('src', 'assets/images/menu-items/'+img);
		});
		
		$('#removeOrder').on('show.bs.modal', function (event) {
			var btn = $(event.relatedTarget);
			var item = btn.data('item');
			var item_id = btn.data('id');
			var price = btn.data('price');
			var qty = btn.data('qty');
			var img = btn.data('img');
			var tprice = qty * price;
			
			var modal = $(this);
			modal.find('#menu_item').text(item);
			modal.find('#txtprice').text(price);
			modal.find('#ttlprice').text(tprice);
			modal.find('#qty').text(qty);
			modal.find('[name="item"]').val(item_id);
			modal.find('#img').attr('src', 'assets/images/menu-items/'+img);
		});
		
		$('#deleteItem').on('show.bs.modal', function(event) {
			var btn = $(event.relatedTarget);
			var title = btn.data('title');
			var msg = btn.data('msg');
			var link = btn.data('link');
			
			var modal = $(this);
			modal.find('#del_title').text(title);
			modal.find('#del_msg').text(msg);
			modal.find('#del_link').attr('href', link);
		});
		
		$(function () {
			$('#qty').change(function() {
				var ttl_price = $(this).val() * $('#price').val();	
					
				$('#ttlprice').text(ttl_price);
			}).change();
		});
		
		function loadDetails(order_key){
			console.log(order_key);
			//$('#table_orders').load("index.php?a=a=bar&v="+order_key+ " #table_orders");
			window.location.href = 'index.php?a=bar&v=' + order_key;
			var new_url = 'index.php';
			$.ajax({
				type: "GET",
				url: new_url,
				data: "a=bar&v="+order_key+" #table_orders",
				success: function(msg){
					$('#table_orders').html(msg);
				}
			});
		}
		
		function update_orderCount(){
			//setInterval(refresher, 2000);
			$.get('app/auto_reload_result.php?data=order_count', function(data) {
				$('#order_count').html(data);
				//console.log('Order Count Reloaded:' +data);
			});
		}
		
		function update_orderStatus(){
			//setInterval(refresher, 2000);
			$.get('app/auto_reload_result.php?data=order_status', function(data) {
				$('#order_status').html(data);
				//console.log('Order Status Reloaded:' +data);
			});
		}
		
		setInterval(function () {
			update_orderCount();
			update_orderStatus();
		}, 2000);
		
		$('.disabled').click(function(ev) {
			ev.preventDefault();
		});
		
		
		
		
		
