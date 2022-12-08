<!-- Wallets



MY_Controller

 -->

<div class="modal modal-wallet" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">

<?php echo form_open('user/mainpage', 'class="modal-content"'); ?>
		<!-- <form class="modal-content" method="post" action="test.php">
		 -->	<div class="loading"></div>
			<div class="modal-header bg-green text-white">
				<h5 class="modal-title">Select Wallet</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="text-white">&times;</span>
				</button>
			</div>
			
			<div class="modal-body">
					<div class="col-md-9">
						<a class="row mb-2 item-hover text-dark" href="<?php echo base_url('index.php/user/allwallets')?>">
					<div class="col-md-2 text-center">
						<span class="fas fa-globe fs-40 d-block"></span>
					</div>
					<div class="col-md-9">
						<span class="d-block">All Wallets</span>
					</div>
				</a>
				</div>
			</div>

			<div  data-v-5d313186="" class="subtitle" style="margin-left:30px;">Cash</div>
			
			<div class="modal-body">
			
			<?php foreach($wallets as $value):?>	
				<a class="row mb-2 item-hover text-dark" href="<?php echo base_url('index.php/user/selectwallet/'.$value['id'])?>">
					<div class="col-md-2 text-center">
						<span class="fas fa-wallet fs-30"></span>
					</div>
					<div class="col-md-9">
						<span class="d-block"><?php echo $value['wallet']?></span>
						<span class="d-block"><?php echo $value['money']?></span>
					</div>
				</a>
			<?php endforeach;?>
				<!-- <a class="row mb-2 item-hover text-dark" href="#">
					<div class="col-md-2 text-center">
						<span class="fas fa-wallet fs-30"></span>
					</div>	
					<div class="col-md-9">
						<span class="d-block">Wallet name 2</span>
						<span class="d-block">USD 100</span>
					</div>
				</a> -->
			</div>

			<div class="modal-footer">
				<button type="button" class="btn" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-danger" data-toggle="modal" data-target=".modal-wallet-delete">Delete Wallet</button>
				<button type="button" class="btn btn-success" data-toggle="modal" data-target=".modal-wallet-add">Add Wallet</button>
			</div>
		</form>

	</div>
</div>


<div class="modal modal-wallet-add" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">

		<?php echo form_open('user/addwallet', 'class="modal-content"'); ?>
		
		<!-- <form class="modal-content" method="post" action="user/addwallet"> -->
			<div class="loading"></div>
			<div class="modal-header bg-green text-white">
				<h5 class="modal-title">Add wallet</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="text-white">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<div class="row">
					<div class="col-md-2 text-center">
						<span class="fas fa-wallet fs-30"></span>
					</div>
					<div class="col-md-9">
						<div class="form-group">
							<label class="d-block">
								<input type="text" placeholder="Wallet Name" class="form-control" name="wallet" required>
							</label>
						  </div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-2 text-center">
						<span class="fas fa-dollar-sign fs-30"></span>
					</div>
					<div class="col-md-9">
						<label class="d-block">
							<select class="custom-select" name="currency" id="">
								<option value="0">USD <span>(US Dollar)</span></option>
								<option value="1">EUR <span>(Euro)</span></option>
								<option value="2">TR <span>(Turkish Lira)</span></option>
								<option value="3">AZN <span>(Azerbaijani Manat)</span></option>
							</select>
						</label>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn" data-dismiss="modal">Close</button>
				<button type="submit" name="add" class="btn btn-success">Add</button>
			</div>
		</form>

	</div>
</div>


<div class="modal modal-wallet-delete" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">


<?php echo form_open('user/deletewallet', 'class="modal-content"'); ?>
		<!-- <form class="modal-content" method="post" action="test.php">
		 -->	<div class="loading"></div>
			<div class="modal-header bg-green text-white">
				<h5 class="modal-title">Delete wallet</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="text-white">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<?php foreach($wallets as $value):?>
				<div class="row">
					<div class="col-md-2 text-center">
						<div class="form-check">
							<input class="form-check-input mx-auto" type="checkbox" value="<?php echo $value['id']?>" name="wallet-id[]" id="">
						</div>
					</div>

					<div class="col-md-10">	
						<div class="form-check">
							<label class="form-check-label" for="check1"><?php echo $value['wallet'] ?></label>
						</div>
					</div>
					
					
				</div>
				<?php endforeach; ?>
			<!-- 	<div class="row">
					<div class="col-md-2 text-center">
						<div class="form-check">
							<input class="form-check-input mx-auto" type="checkbox" value="1" name="wallet-id[]" id="check2">
						</div>
					</div>

					<div class="col-md-10">
						<div class="form-check">
							<label class="form-check-label" for="check2">Wallet name 2 (AZN)</label>
						</div>
					</div>
				</div> -->
			</div>

			<div class="modal-footer">
				<button type="button" class="btn" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-danger">Delete</button>
			</div>
		</form>

	</div>
</div>


<!-- Transactions -->
<div class="modal modal-transaction" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">

		<?php
$attributes = array('class' => 'modal-content', 'data-edit-url' => '/budget/user/edittrans');
echo form_open('/user/addtrans', $attributes);

		 //echo form_open('user/addtrans', 'class="modal-content"', 'data-edit-url="user/edittrans"'); ?>
		<!-- <form class="modal-content" method="post" action="test.php" data-edit-url="asdad.p"> 
		 -->	<div class="loading"></div>
		 <input type="hidden" name="id" value="" id="js-trans-id">
			<div class="modal-header bg-green text-white">
				<h5 class="modal-title">Add transaction</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="text-white">&times;</span>
				</button>
			</div>
<!-- 

valuelere categori id leri yazmaq


 -->			<div class="modal-body">
				<div class="row mb-2">
					<div class="col-md-2 text-center">
						<span class="fas fa-question fs-30"></span>
					</div>
					<div class="col-md-9">
						<label class="d-block">
							<select class="custom-select" name="trans-cat" id="js-trans-type" required>
								
							
								<?php
								
								$a="";
								
								foreach ($category as $key => $value) : ?>
								<?php if ($a != $value['category']) : ?>
								
								<optgroup label="<?php echo $value['category'];?>"></optgroup>
								
								<?php endif; 
								
								$a=$value['category'];
								
								?>
								 <option value="<?php echo $value['id'];?>" data-trans-type="<?php echo $value['trans_type'];?>"><?php echo $value['name'];?></option>
									

								<?php endforeach; ?>

						
							 </select>
						</label>
					</div>
				</div>

				<div class="row mb-2">
					<div class="col-md-2 text-center">
						<span class="fas fa-money-bill-alt fs-30"></span>
					</div>
					<div class="col-md-9">
						<div class="form-group">
							<label class="d-block">
								<input type="number" placeholder="How much?" class="form-control" id="js-trans-amount" name="trans-amount" required>
							</label>
					  </div>
					</div>
				</div>

				<div class="row mb-2">
					<div class="col-md-2 text-center">
						<span class="fas fa-pen fs-30"></span>
					</div>
					<div class="col-md-9">
						<div class="form-group">
							<label class="d-block">
								<input type="text" placeholder="Note" class="form-control" id="js-trans-note" name="trans-note" required>
							</label>
						  </div>
					</div>
				</div>

				<div class="row mb-2">
					<div class="col-md-2 text-center">
						<span class="fas fa-calendar-alt fs-30"></span>
					</div>
					<div class="col-md-9">
						<div class="form-group">
							<label class="d-block">
								<input type="text" placeholder="date" class="form-control datepicker" id="js-trans-date" name="trans-date" required>
							</label>
						  </div>
					</div>
				</div>

	

				<div class="row mb-2">
					<div class="col-md-2 text-center">
						<span class="fas fa-wallet fs-30"></span>
					</div>
					<div class="col-md-9">
						<div class="form-group">
							<label class="d-block">
								<select class="custom-select" name="trans-wallet" id="js-trans-wallet" required>
									<?php foreach($wallets as $value):?>
									<option value="<?php echo $value['id']?>"><?php echo $value['wallet'];?></option>
							
									<?php endforeach ?>
								</select>
							</label>
						  </div>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="submit" class="btn btn-success">Add</button>
			</div>
		</form>

	</div>
</div>


<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-3.3.1.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.bundle.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap-datepicker.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/main.js?v='. time()) ?>"></script>
</body>
</html>